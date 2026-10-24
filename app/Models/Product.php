<?php
namespace App\Models;

use App\Database\Database;
use mysqli;

class Product{
    private mysqli $db;

        public function __construct()
        {
            $database = new Database();

            $this->db = $database->getConnection();
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
