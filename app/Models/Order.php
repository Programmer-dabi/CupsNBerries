<?php
namespace App\Models;

use App\Database\Database;
use InvalidArgumentException;
use mysqli;
use Throwable;

class Order
{
    public const INITIAL_STATUS = 'Placed order';
    public const DELIVERY_CITY = 'Dagupan';
    public const ADDRESS_FIELDS = [
        'barangay' => ['label' => 'Barangay', 'max' => 100],
        'street' => ['label' => 'Street', 'max' => 150],
        'house_no' => ['label' => 'House No.', 'max' => 30],
    ];

    public const PAYMENT_METHODS = [
        'gcash' => 'Gcash',
        'cash_on_delivery' => 'Cash on Delivery',
        'store_pickup' => 'Store pick up',
    ];

    public static function paymentLabel(string $method): string
    {
        return self::PAYMENT_METHODS[$method] ?? ($method === 'cash_at_counter' ? 'Cash at counter' : $method);
    }

    public static function deliveryAddressErrors(array $details): array
    {
        if (!in_array($details['payment_method'] ?? null, ['gcash', 'cash_on_delivery'], true)) {
            return [];
        }
        $errors = [];
        foreach (self::ADDRESS_FIELDS as $field => $settings) {
            $value = is_string($details[$field] ?? null) ? trim($details[$field]) : '';
            if ($value === '') {
                $errors[$field] = $settings['label'] . ' is required for delivery.';
            } elseif (mb_strlen($value) > $settings['max']) {
                $errors[$field] = $settings['label'] . ' must be ' . $settings['max'] . ' characters or fewer.';
            } elseif (preg_match('/[\x00-\x1F\x7F]/', $value)) {
                $errors[$field] = 'Enter a valid ' . $settings['label'];
            }
        }
        return $errors;
    }

    public static function canCustomerCancel(string $status): bool
    {
        $normalized = strtolower(trim(preg_replace('/[\s_-]+/', ' ', $status)));
        return in_array($normalized, ['placed order', 'pending', 'confirmed', 'paid', 'payed'], true);
    }

    // Both customer and admin cancellation call this inside a transaction holding the order lock.
    public static function cancelLockedOrder(mysqli $db, int $id): void
    {
        $stmt = $db->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ? AND status <> 'Cancelled'");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $changed = $stmt->affected_rows;
        $stmt->close();
        if ($changed === 0) {
            return;
        }
        $stmt = $db->prepare('SELECT variant_id, SUM(quantity) AS quantity FROM order_items WHERE order_id = ? AND variant_id IS NOT NULL GROUP BY variant_id ORDER BY variant_id');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $reservations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        foreach ($reservations as $reservation) {
            $variantId = (int) $reservation['variant_id'];
            $quantity = (int) $reservation['quantity'];
            $stmt = $db->prepare('UPDATE product_variants SET stock_quantity = stock_quantity + ? WHERE id = ?');
            $stmt->bind_param('ii', $quantity, $variantId);
            $stmt->execute();
            $stmt->close();
        }
    }

    private mysqli $db;
    private Cart $cart;

    public function __construct(?mysqli $db = null)
    {
        $this->db = $db ?? (new Database())->getConnection();
        $this->cart = new Cart($this->db);
    }

    public function create(array $details, string $token): array
    {
        if ($this->cart->getUserId() === null) {
            throw new InvalidArgumentException('Please sign in to place an order.');
        }

        if (!preg_match('/\A[a-f0-9]{64}\z/', $token)) {
            throw new InvalidArgumentException('Please reload checkout and try again.');
        }

        $paymentMethod = $details['payment_method'] ?? null;
        if (!is_string($paymentMethod) || !array_key_exists($paymentMethod, self::PAYMENT_METHODS)) {
            throw new InvalidArgumentException('Choose a valid mode of payment.');
        }
        $addressErrors = self::deliveryAddressErrors($details);
        if ($addressErrors !== []) {
            throw new InvalidArgumentException(reset($addressErrors));
        }
        $address = ['barangay' => null, 'street' => null, 'house_no' => null, 'city' => null];
        if (in_array($paymentMethod, ['gcash', 'cash_on_delivery'], true)) {
            foreach (self::ADDRESS_FIELDS as $field => $settings) {
                $address[$field] = trim($details[$field]);
            }
            $address['city'] = self::DELIVERY_CITY;
        }
        $pickupAt = $paymentMethod === 'store_pickup' ? ($details['pickup_at'] ?? null) : null;
        if ($paymentMethod === 'store_pickup' && (!is_string($pickupAt) || $pickupAt === '')) {
            throw new InvalidArgumentException('Pickup date and time are required for store pick up.');
        }

        $this->db->begin_transaction();
        try {
            $items = $this->cart->getItems(true);
            $userId = $this->cart->getUserId();
            $cartKey = $this->cart->getCartKey();
            // Repeated submissions return the saved order without charging stock twice.
            $stmt = $this->db->prepare('SELECT order_number FROM orders WHERE checkout_token = ? AND user_id <=> ? AND cart_key = ? FOR UPDATE');
            $stmt->bind_param('sis', $token, $userId, $cartKey);
            $stmt->execute();
            $existing = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($existing !== null) {
                $order = $this->getByNumber($existing['order_number']);
                $this->db->commit();
                return $order;
            }
            if ($items === []) {
                throw new InvalidArgumentException('Your cart is empty. Add an item before placing an order.');
            }

            $subtotalCentavos = 0;
            $variantQuantities = [];
            foreach ($items as &$item) {
                $stmt = $this->db->prepare('SELECT availability FROM products WHERE id = ? FOR UPDATE');
                $stmt->bind_param('i', $item['product_id']);
                $stmt->execute();
                $product = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                if ($product === null || $product['availability'] !== 'Available') {
                    throw new InvalidArgumentException($item['product_name'] . ' is currently unavailable. Please update your cart.');
                }
                if ($item['variant_id'] === null && $item['variant_label'] !== null) {
                    throw new InvalidArgumentException('A selected variant is no longer available. Please update your cart.');
                }
                if ($item['variant_id'] !== null) {
                    $variantQuantities[$item['variant_id']] = ($variantQuantities[$item['variant_id']] ?? 0) + $item['quantity'];
                }
                // Prices are saved by Cart from product data; never accept posted totals.
                $lineCentavos = (int) round($item['unit_price'] * 100) * $item['quantity'];
                $item['line_total'] = number_format($lineCentavos / 100, 2, '.', '');
                $subtotalCentavos += $lineCentavos;
            }
            unset($item);

            ksort($variantQuantities);
            foreach ($variantQuantities as $variantId => $quantity) {
                $stmt = $this->db->prepare('UPDATE product_variants SET stock_quantity = stock_quantity - ? WHERE id = ? AND stock_quantity >= ?');
                $stmt->bind_param('iii', $quantity, $variantId, $quantity);
                $stmt->execute();
                $updated = $stmt->affected_rows;
                $stmt->close();
                if ($updated !== 1) {
                    throw new InvalidArgumentException('Not enough stock for your selected items. Please update your cart.');
                }
            }

            $orderNumber = 'KP-' . strtoupper(bin2hex(random_bytes(6)));
            $total = number_format($subtotalCentavos / 100, 2, '.', '');
            $initialStatus = self::INITIAL_STATUS;
            $stmt = $this->db->prepare(
                'INSERT INTO orders
                    (order_number, checkout_token, user_id, cart_key, customer_name, phone_number,
                     email, pickup_at, notes, payment_method, status, subtotal, total,
                     barangay, street, house_no, city)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->bind_param('ssissssssssssssss', $orderNumber, $token, $userId, $cartKey,
                $details['name'], $details['phone_number'], $details['email'], $pickupAt,
                $details['notes'], $paymentMethod, $initialStatus, $total, $total,
                $address['barangay'], $address['street'], $address['house_no'], $address['city']);
            $stmt->execute();
            $orderId = $this->db->insert_id;
            $stmt->close();

            foreach ($items as $item) {
                $addons = json_encode($item['addons'], JSON_THROW_ON_ERROR);
                $unitPrice = number_format($item['unit_price'], 2, '.', '');
                $stmt = $this->db->prepare(
                    'INSERT INTO order_items
                        (order_id, product_id, variant_id, product_name, variant_label, image_path,
                         addons, milk_preference, sugar_level, unit_price, quantity, line_total)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                $stmt->bind_param('iiisssssisis', $orderId, $item['product_id'], $item['variant_id'],
                    $item['product_name'], $item['variant_label'], $item['image_path'], $addons,
                    $item['milk_preference'], $item['sugar_level'], $unitPrice, $item['quantity'], $item['line_total']);
                $stmt->execute();
                $stmt->close();
            }

            $this->cart->clear();
            $order = $this->getByNumber($orderNumber);
            $this->db->commit();
            return $order;
        } catch (Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }

    public function getByNumber(string $number): ?array
    {
        $userId = $this->cart->getUserId();
        $cartKey = $this->cart->getCartKey();
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE order_number = ? AND user_id <=> ? AND cart_key = ?');
        $stmt->bind_param('sis', $number, $userId, $cartKey);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($order === null) {
            return null;
        }
        return $this->withItems($order);
    }

    public function getById(int $id): ?array
    {
        $userId = $this->cart->getUserId();
        $cartKey = $this->cart->getCartKey();
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE id = ? AND user_id <=> ? AND cart_key = ?');
        $stmt->bind_param('iis', $id, $userId, $cartKey);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $order === null ? null : $this->withItems($order);
    }

    public function getTrackingStatus(int $id): ?array
    {
        $userId = $this->cart->getUserId();
        $cartKey = $this->cart->getCartKey();
        $stmt = $this->db->prepare('SELECT status, payment_method FROM orders WHERE id = ? AND user_id <=> ? AND cart_key = ?');
        $stmt->bind_param('iis', $id, $userId, $cartKey);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $order;
    }

    public function getForCurrentUser(): array
    {
        $userId = $this->cart->getUserId();
        if ($userId === null) {
            return [];
        }
        $stmt = $this->db->prepare(
            'SELECT o.id, o.order_number, o.created_at, o.pickup_at, o.status, o.total,
                    (SELECT COALESCE(SUM(i.quantity), 0) FROM order_items i WHERE i.order_id = o.id) AS item_count
             FROM orders o WHERE o.user_id = ? ORDER BY o.created_at DESC, o.id DESC'
        );
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        foreach ($orders as &$order) {
            $order['can_cancel'] = self::canCustomerCancel($order['status']);
        }
        unset($order);

        return $orders;
    }

    public function cancelForCurrentUser(int $id): void
    {
        $userId = $this->cart->getUserId();
        if ($userId === null) {
            throw new InvalidArgumentException('Please sign in to cancel your order.');
        }
        $this->db->begin_transaction();
        try {
            $stmt = $this->db->prepare('SELECT status FROM orders WHERE id = ? AND user_id = ? FOR UPDATE');
            $stmt->bind_param('ii', $id, $userId);
            $stmt->execute();
            $order = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($order === null) {
                throw new InvalidArgumentException('Order not found.');
            }
            if (strtolower($order['status']) !== 'cancelled') {
                if (!self::canCustomerCancel($order['status'])) {
                    throw new InvalidArgumentException('This order can no longer be cancelled because preparation has started or the order is complete.');
                }
                self::cancelLockedOrder($this->db, $id);
            }
            $this->db->commit();
        } catch (Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }

    private function withItems(array $order): array
    {
        $order['payment_label'] = self::paymentLabel($order['payment_method']);
        $stmt = $this->db->prepare('SELECT * FROM order_items WHERE order_id = ? ORDER BY id');
        $stmt->bind_param('i', $order['id']);
        $stmt->execute();
        $order['items'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        foreach ($order['items'] as &$item) {
            $item['addons'] = json_decode($item['addons'], true, 512, JSON_THROW_ON_ERROR);
        }
        unset($item);
        return $order;
    }
}
