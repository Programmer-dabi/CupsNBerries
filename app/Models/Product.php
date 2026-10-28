<?php
namespace App\Models;

use App\Database\Database;
use mysqli;

class Product{
    private mysqli $db;

        public function __construct(?mysqli $db = null)
        {
            $this->db = $db ?? (new Database())->getConnection();
        }

         // 1. Insert the main product.
    public function createProduct(array $data): int
    {
        $sql = "INSERT INTO products
                (product_name, category, description,
                 base_price, availability)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "sssds",
            $data['product_name'],
            $data['category'],
            $data['description'],
            $data['base_price'],
            $data['availability']
        );

        $stmt->execute();

        $productId = $this->db->insert_id;

        $stmt->close();

        return $productId;
    }


    // 2. Insert one product image.
    public function addImage(int $productId,string $imagePath,int $imageOrder): void {
        $sql = "INSERT INTO product_images
                (product_id, image_path, image_order)
                VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "isi",
            $productId,
            $imagePath,
            $imageOrder
        );

        $stmt->execute();
        $stmt->close();
    }


    // 3. Insert one add-on.
    public function addAddon(int $productId,string $addonName,float $addonPrice): void {
        $sql = "INSERT INTO product_addons
                (product_id, addon_name, addon_price)
                VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "isd",
            $productId,
            $addonName,
            $addonPrice
        );

        $stmt->execute();
        $stmt->close();
    }


    // 4. Insert one size variant.
    public function addVariant(int $productId,string $sizeOz,float $price,int $stock): void {
        $sql = "INSERT INTO product_variants
                (product_id, size_oz, price, stock_quantity)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "isdi",
            $productId,
            $sizeOz,
            $price,
            $stock
        );

        $stmt->execute();
        $stmt->close();
    }


    // 5. Coordinate all inserts in one transaction.
    public function createComplete(array $data,array $images,array $addons,array $variants): int {
        $this->db->begin_transaction();

        try {
            // Create the main product first.
            $productId = $this->createProduct($data);

            // Save each uploaded image path.
            foreach ($images as $image) {
                $this->addImage(
                    $productId,
                    $image['path'],
                    $image['order']
                );
            }

            // Save each add-on.
            foreach ($addons as $addon) {
                $this->addAddon(
                    $productId,
                    $addon['name'],
                    $addon['price']
                );
            }

            // Save each size variant.
            foreach ($variants as $variant) {
                $this->addVariant(
                    $productId,
                    $variant['size_oz'],
                    $variant['price'],
                    $variant['stock']
                );
            }

            // Commit only after every insert succeeds.
            $this->db->commit();

            return $productId;

        } catch (\Throwable $error) {
            $this->db->rollback();

            throw $error;
        }
    }
    public function saveForAdmin(?int $id, array $data, array $images, array $addons, array $variants): int
    {
        if ($id === null) {
            return $this->createComplete($data, $images, $addons, $variants);
        }
        $this->db->begin_transaction();
        try {
            $stmt = $this->db->prepare('SELECT id FROM products WHERE id = ? FOR UPDATE');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $exists = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($exists === null) {
                throw new \InvalidArgumentException('Product not found.');
            }
            $stmt = $this->db->prepare('UPDATE products SET product_name = ?, category = ?, description = ?, base_price = ?, availability = ? WHERE id = ?');
            $stmt->bind_param('sssdsi', $data['product_name'], $data['category'], $data['description'], $data['base_price'], $data['availability'], $id);
            $stmt->execute();
            $stmt->close();

            foreach (['product_variants' => $variants, 'product_addons' => $addons] as $table => $rows) {
                // Table names come only from the fixed map above.
                $stmt = $this->db->prepare("SELECT id FROM $table WHERE product_id = ? FOR UPDATE");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $remaining = array_fill_keys(array_column($stmt->get_result()->fetch_all(MYSQLI_ASSOC), 'id'), true);
                $stmt->close();
                $used = [];
                foreach ($rows as $row) {
                    $rowId = $row['id'] ?? 0;
                    if ($rowId && (!isset($remaining[$rowId]) || isset($used[$rowId]))) {
                        throw new \InvalidArgumentException('A selected variant or add-on does not belong to this product.');
                    }
                    if ($table === 'product_variants') {
                        if ($rowId) {
                            // Existing inventory changes only through the variant stock form.
                            $stmt = $this->db->prepare('UPDATE product_variants SET size_oz = ?, price = ? WHERE id = ? AND product_id = ?');
                            $stmt->bind_param('sdii', $row['size_oz'], $row['price'], $rowId, $id);
                            $stmt->execute();
                            $stmt->close();
                        } else {
                            $this->addVariant($id, $row['size_oz'], $row['price'], $row['stock']);
                        }
                    } elseif ($rowId) {
                        $stmt = $this->db->prepare('UPDATE product_addons SET addon_name = ?, addon_price = ? WHERE id = ? AND product_id = ?');
                        $stmt->bind_param('sdii', $row['name'], $row['price'], $rowId, $id);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        $this->addAddon($id, $row['name'], $row['price']);
                    }
                    if ($rowId) {
                        $used[$rowId] = true;
                    }
                }
                foreach (array_diff_key($remaining, $used) as $rowId => $_) {
                    $stmt = $this->db->prepare("DELETE FROM $table WHERE id = ? AND product_id = ?");
                    $stmt->bind_param('ii', $rowId, $id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            foreach ($images as $image) {
                $stmt = $this->db->prepare('DELETE FROM product_images WHERE product_id = ? AND image_order = ?');
                $stmt->bind_param('ii', $id, $image['order']);
                $stmt->execute();
                $stmt->close();
                $this->addImage($id, $image['path'], $image['order']);
            }
            $this->db->commit();
            return $id;
        } catch (\Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }

    public function setVariantStock(int $productId, int $variantId, int $quantity, int $expected): void
    {
        if ($productId < 1 || $variantId < 1 || $quantity < 0 || $quantity > 4294967295 || $expected < 0) {
            throw new \InvalidArgumentException('Enter a valid variant and a non-negative whole stock quantity.');
        }
        $this->db->begin_transaction();
        try {
            $stmt = $this->db->prepare('SELECT stock_quantity FROM product_variants WHERE id = ? AND product_id = ? FOR UPDATE');
            $stmt->bind_param('ii', $variantId, $productId);
            $stmt->execute();
            $variant = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($variant === null) {
                throw new \InvalidArgumentException('The selected variant does not belong to this product.');
            }
            if ((int) $variant['stock_quantity'] !== $expected) {
                throw new \InvalidArgumentException('Stock changed since this form was opened. Review the current stock and try again.');
            }
            $stmt = $this->db->prepare('UPDATE product_variants SET stock_quantity = ? WHERE id = ? AND product_id = ?');
            $stmt->bind_param('iii', $quantity, $variantId, $productId);
            $stmt->execute();
            $stmt->close();
            $this->db->commit();
        } catch (\Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }

    public function deleteProduct(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $deleted = $stmt->affected_rows;
        $stmt->close();
        if ($deleted !== 1) {
            throw new \InvalidArgumentException('Product not found.');
        }
    }

    public function getProductAll() {
        $sqlmaintable = "SELECT
                p.id,
                p.product_name,
                p.category,
                p.description,
                p.base_price,
                p.availability,
                p.created_at
            FROM products p
            ORDER BY p.created_at DESC";


        $result = $this->db->query($sqlmaintable);

        if (!$result) {
            throw new \RuntimeException(
                'Failed to retrieve products.'
            );
        }

        $sqlImageTable = '';
        $rowmain = $result->fetch_all(MYSQLI_ASSOC);

            $sqlImageTable = "SELECT
                p.id,
                p.product_id,
                p.image_path,
                p.image_order
            FROM product_images p
            ORDER BY p.image_order ASC";
        $resultimage = $this->db->query($sqlImageTable);
        $rowImage = $resultimage->fetch_all(MYSQLI_ASSOC);
        $products = [];

        foreach ($rowmain as $valuemain) {
            $productId = $valuemain['id'];

            $products[$productId] = $valuemain;
            $products[$productId]['images'] = [];
        }

        foreach ($rowImage as $valueimg) {
            $productId = $valueimg['product_id'];

            if (isset($products[$productId])) {
                $products[$productId]['images'][] = $valueimg;
            }
        }

        

            
        return($products);
    }

    public function getProduct(string $params, mixed $value)
    {
        // 1. Allow only specific column names.
        $allowedColumns = [
            'id' => 'p.id',
            'product_name' => 'p.product_name',
            'category' => 'p.category',
            'availability' => 'p.availability'
        ];

        // 2. Reject any column that is not on the whitelist.
        if (!isset($allowedColumns[$params])) {
            throw new \InvalidArgumentException(
                'Invalid search column.'
            );
        }

        // 3. Validate the value if searching by ID.
        if ($params === 'id') {
            $value = filter_var($value, FILTER_VALIDATE_INT);

            if ($value === false || $value < 1) {
                throw new \InvalidArgumentException(
                    'Invalid product ID.'
                );
            }
        }

        // 4. Safely query the main products table.
        $column = $allowedColumns[$params];

        $sql = "SELECT
                    p.id,
                    p.product_name,
                    p.category,
                    p.description,
                    p.base_price,
                    p.availability,
                    p.created_at
                FROM products p
                WHERE $column = ?
                ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $value);
        $stmt->execute();

        $result = $stmt->get_result();
        $rowmain = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        // 5. Build the associative array.
        $products = [];

        foreach ($rowmain as $product) {
            $productId = $product['id'];

            $products[$productId] = $product;
            $products[$productId]['images'] = [];
        }

        // 6. Reuse one prepared statement to fetch each product's images.
        $sqlImage = "SELECT
                        id,
                        product_id,
                        image_path,
                        image_order
                    FROM product_images
                    WHERE product_id = ?
                    ORDER BY image_order ASC";

        $imageStmt = $this->db->prepare($sqlImage);

        foreach ($products as $productId => &$product) {
            $imageStmt->bind_param('i', $productId);
            $imageStmt->execute();

            $imageResult = $imageStmt->get_result();

            $product['images'] = $imageResult->fetch_all(
                MYSQLI_ASSOC
            );
        }

        /* Fetch custom sizes and prices for each product */
        $variantSql = "
            SELECT id, size_oz, price, stock_quantity
            FROM product_variants
            WHERE product_id = ?
            ORDER BY id ASC
        ";

        $variantStmt = $this->db->prepare($variantSql);

        /* Fetch custom add-ons for each product */
        $addonSql = "
            SELECT id, addon_name, addon_price
            FROM product_addons
            WHERE product_id = ?
            ORDER BY id ASC
        ";

        $addonStmt = $this->db->prepare($addonSql);

        foreach ($products as $productId => &$product) {

            // Get variants belonging to this product
            $variantStmt->bind_param("i", $productId);
            $variantStmt->execute();

            $product['variants'] = $variantStmt
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);

            // Get add-ons belonging to this product
            $addonStmt->bind_param("i", $productId);
            $addonStmt->execute();

            $product['addons'] = $addonStmt
                ->get_result()
                ->fetch_all(MYSQLI_ASSOC);
        }

        unset($product);

        $variantStmt->close();
        $addonStmt->close();

        return $products;
    }
}

?>
