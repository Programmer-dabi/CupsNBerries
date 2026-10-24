<?php
namespace App\Models;

use App\Database\Database;
use InvalidArgumentException;
use mysqli;
use Throwable;

/**
 * Database-backed cart. Prices always come from product data and server settings.
 * A session token owns guest carts; signed-in carts belong to the current user.
 */
class Cart
{
    private const MAX_QUANTITY = 99;

    private mysqli $db;
    private string $cartKey;

    public function __construct(?mysqli $db = null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->db = $db ?? (new Database())->getConnection();
        $userId = filter_var($_SESSION['user'] ?? null, FILTER_VALIDATE_INT);

        if ($userId !== false && $userId > 0) {
            $this->cartKey = 'user:' . $userId;
        } else {
            if (!isset($_SESSION['cart_token'])) {
                $_SESSION['cart_token'] = bin2hex(random_bytes(32));
            }
            $this->cartKey = 'guest:' . $_SESSION['cart_token'];
        }
    }

    // Shared by the product page and the server-side price calculation.
    public static function milkOptions(): array
    {
        return [
            ['value' => 'regular', 'label' => 'Regular', 'price' => 0],
            ['value' => 'oat', 'label' => 'Oat', 'price' => 25],
            ['value' => 'soy', 'label' => 'Soy', 'price' => 20],
        ];
    }

    /**
     * Save a product, or increase the quantity of an identical selection.
     *
     * @param int[] $addonIds
     * @return string The cart line key.
     */
    public function addToCart(
        int $productId,
        ?int $variantId = null,
        array $addonIds = [],
        int $quantity = 1,
        ?string $milkPreference = null,
        ?int $sugarLevel = null
    ): string {
        $this->assertQuantity($quantity);
        if ($productId < 1 || ($variantId !== null && $variantId < 1)) {
            throw new InvalidArgumentException('Invalid product or variant ID.');
        }
        foreach ($addonIds as $addonId) {
            if (!is_int($addonId) || $addonId < 1) {
                throw new InvalidArgumentException('Add-on IDs must be positive integers.');
            }
        }
        if (!in_array($sugarLevel, [null, 100, 75, 50, 0], true)) {
            throw new InvalidArgumentException('Invalid sugar level.');
        }
        $milkPrices = array_column(self::milkOptions(), 'price', 'value');
        if ($milkPreference !== null && !array_key_exists($milkPreference, $milkPrices)) {
            throw new InvalidArgumentException('Invalid milk preference.');
        }

        $addonIds = array_values(array_unique($addonIds));
        sort($addonIds);
        $key = $this->lineKey($productId, $variantId, $addonIds, $milkPreference, $sugarLevel);

        $this->db->begin_transaction();
        try {
            // Serialize additions for this product, including concurrent duplicates.
            $product = $this->fetchProduct($productId);
            if ($product === null) {
                throw new InvalidArgumentException('Product not found.');
            }
            if ($product['availability'] !== 'Available') {
                throw new InvalidArgumentException('This product is currently unavailable.');
            }
            if ($variantId === null && $product['has_variants']) {
                throw new InvalidArgumentException('Please choose an in-stock variant.');
            }

            $variant = null;
            $unitCentavos = $this->toCentavos($product['base_price']);
            if ($variantId !== null) {
                $variant = $this->fetchVariant($productId, $variantId);
                if ($variant === null) {
                    throw new InvalidArgumentException('Invalid variant for this product.');
                }
                $unitCentavos += $this->toCentavos($variant['price']);
            }
            if ($milkPreference !== null) {
                $unitCentavos += $this->toCentavos($milkPrices[$milkPreference]);
            }

            $addons = $this->fetchAddons($productId, $addonIds);
            if (count($addons) !== count($addonIds)) {
                throw new InvalidArgumentException('Invalid add-on for this product.');
            }
            foreach ($addons as $addon) {
                $unitCentavos += $this->toCentavos($addon['addon_price']);
            }

            $existing = $this->fetchLine($key, true);
            $newQuantity = (int) ($existing['quantity'] ?? 0) + $quantity;
            $this->assertQuantity($newQuantity);
            if ($variant !== null && $newQuantity > (int) $variant['stock_quantity']) {
                throw new InvalidArgumentException('Not enough stock for the selected variant.');
            }

            $variantLabel = $variant['size_oz'] ?? null;
            $addonJson = json_encode(array_map(
                static fn(array $addon): array => [
                    'id' => (int) $addon['id'],
                    'name' => $addon['addon_name'],
                    'price' => (float) $addon['addon_price'],
                ],
                $addons
            ), JSON_THROW_ON_ERROR);
            $unitPrice = number_format($unitCentavos / 100, 2, '.', '');
            $stmt = $this->db->prepare(
                'INSERT INTO cart_items
                    (cart_key, line_key, product_id, product_name, variant_id,
                     variant_label, addons, milk_preference, sugar_level, unit_price, quantity)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    product_name = VALUES(product_name), variant_label = VALUES(variant_label),
                    addons = VALUES(addons), unit_price = VALUES(unit_price), quantity = VALUES(quantity)'
            );
            $stmt->bind_param(
                'ssisisssisi',
                $this->cartKey, $key, $productId, $product['product_name'], $variantId,
                $variantLabel, $addonJson, $milkPreference, $sugarLevel, $unitPrice, $newQuantity
            );
            $stmt->execute();
            $stmt->close();
            $this->db->commit();

            return $key;
        } catch (Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }

    // Setting quantity to zero removes the line.
    public function updateQuantity(string $key, int $quantity): void
    {
        if ($quantity === 0) {
            $this->deleteFromCart($key);
            return;
        }
        $this->assertQuantity($quantity);
        $this->db->begin_transaction();
        try {
            $line = $this->fetchLine($key, true);
            if ($line === null) {
                throw new InvalidArgumentException('Cart item not found.');
            }
            if ($line['variant_id'] !== null) {
                $variant = $this->fetchVariant((int) $line['product_id'], (int) $line['variant_id']);
                if ($variant === null || $quantity > (int) $variant['stock_quantity']) {
                    throw new InvalidArgumentException('Not enough stock for the selected variant.');
                }
            }
            $stmt = $this->db->prepare('UPDATE cart_items SET quantity = ? WHERE cart_key = ? AND line_key = ?');
            $stmt->bind_param('iss', $quantity, $this->cartKey, $key);
            $stmt->execute();
            $stmt->close();
            $this->db->commit();
        } catch (Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }

    public function deleteFromCart(string $key): void
    {
        $stmt = $this->db->prepare('DELETE FROM cart_items WHERE cart_key = ? AND line_key = ?');
        $stmt->bind_param('ss', $this->cartKey, $key);
        $stmt->execute();
        $deleted = $stmt->affected_rows;
        $stmt->close();
        if ($deleted === 0) {
            throw new InvalidArgumentException('Cart item not found.');
        }
    }

    // Keep the existing return structure: cart lines keyed by their selection hash.
    public function getItems(): array
    {
        $stmt = $this->db->prepare(
            'SELECT c.line_key, c.product_id, c.product_name, c.variant_id, c.variant_label,
                    c.addons, c.milk_preference, c.sugar_level, c.unit_price, c.quantity,
                    p.category,
                    (SELECT i.image_path FROM product_images i
                     WHERE i.product_id = c.product_id ORDER BY i.image_order ASC LIMIT 1) AS image_path
             FROM cart_items c JOIN products p ON p.id = c.product_id
             WHERE c.cart_key = ? ORDER BY c.created_at, c.line_key'
        );
        $stmt->bind_param('s', $this->cartKey);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $items = [];
        foreach ($rows as $row) {
            $key = $row['line_key'];
            unset($row['line_key']);
            $row['product_id'] = (int) $row['product_id'];
            $row['variant_id'] = $row['variant_id'] === null ? null : (int) $row['variant_id'];
            $row['sugar_level'] = $row['sugar_level'] === null ? null : (int) $row['sugar_level'];
            $row['unit_price'] = (float) $row['unit_price'];
            $row['quantity'] = (int) $row['quantity'];
            $row['addons'] = json_decode($row['addons'], true, 512, JSON_THROW_ON_ERROR);
            $items[$key] = $row;
        }
        return $items;
    }

    public function getCount(): int
    {
        return array_sum(array_column($this->getItems(), 'quantity'));
    }

    public function getTotal(): float
    {
        $totalCentavos = 0;
        foreach ($this->getItems() as $line) {
            $totalCentavos += $this->toCentavos($line['unit_price']) * $line['quantity'];
        }
        return $totalCentavos / 100;
    }

    public function clear(): void
    {
        $stmt = $this->db->prepare('DELETE FROM cart_items WHERE cart_key = ?');
        $stmt->bind_param('s', $this->cartKey);
        $stmt->execute();
        $stmt->close();
    }

    private function lineKey(int $productId, ?int $variantId, array $addonIds, ?string $milk, ?int $sugar): string
    {
        return hash('sha256', json_encode([$productId, $variantId, $addonIds, $milk, $sugar]));
    }

    private function toCentavos(string|int|float $price): int
    {
        return (int) round((float) $price * 100);
    }

    private function assertQuantity(int $quantity): void
    {
        if ($quantity < 1 || $quantity > self::MAX_QUANTITY) {
            throw new InvalidArgumentException('Quantity must be between 1 and ' . self::MAX_QUANTITY . '.');
        }
    }

    private function fetchLine(string $key, bool $lock = false): ?array
    {
        $sql = 'SELECT product_id, variant_id, quantity FROM cart_items WHERE cart_key = ? AND line_key = ?';
        $stmt = $this->db->prepare($sql . ($lock ? ' FOR UPDATE' : ''));
        $stmt->bind_param('ss', $this->cartKey, $key);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    private function fetchProduct(int $productId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.id, p.product_name, p.base_price, p.availability,
                    EXISTS(SELECT 1 FROM product_variants v WHERE v.product_id = p.id) AS has_variants
             FROM products p WHERE p.id = ? FOR UPDATE'
        );
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    private function fetchVariant(int $productId, int $variantId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, size_oz, price, stock_quantity FROM product_variants WHERE id = ? AND product_id = ?'
        );
        $stmt->bind_param('ii', $variantId, $productId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    private function fetchAddons(int $productId, array $addonIds): array
    {
        if ($addonIds === []) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($addonIds), '?'));
        $stmt = $this->db->prepare(
            "SELECT id, addon_name, addon_price FROM product_addons
             WHERE product_id = ? AND id IN ($placeholders) ORDER BY id"
        );
        $stmt->bind_param('i' . str_repeat('i', count($addonIds)), $productId, ...$addonIds);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }
}
