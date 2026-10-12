<?php
namespace App\Controllers;
use App\Models\Product;
use Flight;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class ProducController{

  private array $variantCategories = [
        'Coffee',
        'Tea',
        'Desserts'
    ];
    public function index(){
        Flight::render('addproduct.twig');
    }
    
 // Handle the product creation form.
    public function add(): void
    {
        // Only accept POST requests.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Flight::halt(405, 'Method not allowed.');
            return;
        }

        // Track uploaded files in case saving fails.
        $uploadedFiles = [];

        try {
            // 1. Validate the basic product details.
            $name = trim($_POST['name'] ?? '');
            $category = $_POST['category'] ?? '';
            $description = trim($_POST['description'] ?? '');
            $availability = $_POST['availability'] ?? 'Available';
            // die($name .' '. $category .' '. $description .' '. $availability);
            $allowedCategories = [
                'Coffee',
                'Iced-Coffee',
                'Tea',
                'Pastries',
                'Desserts'
            ];

            if ($name === '' || mb_strlen($name) > 150) {
                throw new InvalidArgumentException(
                    'Product name is required and must be 150 characters or fewer.'
                );
            }

            if (!in_array($category, $allowedCategories, true)) {
                throw new InvalidArgumentException(
                    'Please select a valid category.'
                );
            }

            if (!in_array(
                $availability,
                ['Available', 'Unavailable'],
                true
            )) {
                throw new InvalidArgumentException(
                    'Invalid availability option.'
                );
            }

           $variants = [];

            if (in_array($category, $this->variantCategories, true)) {

                $sizes = $_POST['variant_oz'] ?? null;
                $prices = $_POST['variant_price'] ?? null;
                $stocks = $_POST['variant_stock'] ?? null;

                // Make sure all three arrays exist and have matching rows.
                if (
                    !is_array($sizes) ||
                    !is_array($prices) ||
                    !is_array($stocks) ||
                    count($sizes) === 0 ||
                    count($sizes) !== count($prices) ||
                    count($sizes) !== count($stocks)
                ) {
                    throw new InvalidArgumentException(
                        'Add at least one complete size variant.'
                    );
                }

                // Track sizes to prevent duplicates.
                $usedSizes = [];

                foreach ($sizes as $i => $sizeValue) {

                    $priceValue = $prices[$i] ?? null;
                    $stockValue = $stocks[$i] ?? null;

                    if (
                        !is_scalar($sizeValue) ||
                        !is_scalar($priceValue) ||
                        !is_scalar($stockValue)
                    ) {
                        throw new InvalidArgumentException(
                            'Invalid variant data.'
                        );
                    }

                    // Sizes are now strings, not numbers.
                    $size = trim((string) $sizeValue);

                    // Validate price and stock separately.
                    $price = filter_var(
                        $priceValue,
                        FILTER_VALIDATE_FLOAT
                    );

                    $stock = filter_var(
                        $stockValue,
                        FILTER_VALIDATE_INT
                    );

                    if (
                        $size === '' ||
                        mb_strlen($size) > 50 ||
                        $price === false ||
                        !is_finite((float) $price) ||
                        $price < 0 ||
                        $stock === false ||
                        $stock < 0
                    ) {
                        throw new InvalidArgumentException(
                            'Check the size, price, and stock of each variant.'
                        );
                    }

                    // Prevent duplicate sizes, ignoring letter case.
                    $sizeKey = mb_strtolower($size);

                    if (isset($usedSizes[$sizeKey])) {
                        throw new InvalidArgumentException(
                            'Each variant must have a different size.'
                        );
                    }

                    $usedSizes[$sizeKey] = true;

                    $variants[] = [
                        'size_oz' => $size,
                        'price' => (float) $price,
                        'stock' => $stock
                    ];
                }

                // Base price is the cheapest variant price.
                $basePrice = $_POST['price'];

            } else {

                // Non-variant products use the base price input.
                $basePrice = filter_var(
                    $_POST['price'] ?? null,
                    FILTER_VALIDATE_FLOAT
                );
                // die($basePrice);
                if (
                    $basePrice === false ||
                    !is_finite((float) $basePrice) ||
                    $basePrice < 0
                ) {
                    throw new InvalidArgumentException(
                        'Enter a valid base price.'
                    );
                }

                $basePrice = (float) $basePrice;
            }

            // 3. Process the optional add-ons.
            $addons = [];

            $addonNames = $_POST['addon_name'] ?? [];
            $addonPrices = $_POST['addon_price'] ?? [];

            if (
                !is_array($addonNames) ||
                !is_array($addonPrices) ||
                count($addonNames) !== count($addonPrices)
            ) {
                throw new InvalidArgumentException(
                    'Invalid add-on data.'
                );
            }

            foreach ($addonNames as $i => $addonNameValue) {
                $addonPriceValue = $addonPrices[$i];

                if (
                    !is_scalar($addonNameValue) ||
                    !is_scalar($addonPriceValue)
                ) {
                    throw new InvalidArgumentException(
                        'Invalid add-on values.'
                    );
                }

                $addonName = trim((string) $addonNameValue);
                $addonPrice = trim((string) $addonPriceValue);

                // Ignore completely empty rows.
                if ($addonName === '' && $addonPrice === '') {
                    continue;
                }

                if (
                    $addonName === '' ||
                    mb_strlen($addonName) > 100 ||
                    $addonPrice === ''
                ) {
                    throw new InvalidArgumentException(
                        'Complete each add-on name and price.'
                    );
                }

                $validatedPrice = filter_var(
                    $addonPrice,
                    FILTER_VALIDATE_FLOAT
                );

                if (
                    $validatedPrice === false ||
                    !is_finite((float) $validatedPrice) ||
                    $validatedPrice < 0
                ) {
                    throw new InvalidArgumentException(
                        'Enter a valid add-on price.'
                    );
                }

                $addons[] = [
                    'name' => $addonName,
                    'price' => (float) $validatedPrice
                ];
            }

            // 4. Prepare the main product data.
            $data = [
                'product_name' => $name,
                'category' => $category,
                'description' => $description,
                'base_price' => $basePrice,
                'availability' => $availability
            ];

            // 5. Upload the three product images.
            $projectRoot = dirname(__DIR__, 2);
            $uploadDirectory = $projectRoot . '/public/images/products';

            if (
                !is_dir($uploadDirectory) &&
                !mkdir($uploadDirectory, 0755, true) &&
                !is_dir($uploadDirectory)
            ) {
                throw new RuntimeException(
                    'Could not create the product image directory.'
                );
            }

            $allowedMimeTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            $images = [];
            foreach (
                ['image1', 'image2', 'image3'] as $index => $field
            ) {
                
                if (
                    !isset($_FILES[$field]) ||
                    !is_array($_FILES[$field]) ||
                    $_FILES[$field]['error'] !== UPLOAD_ERR_OK
                ) {
                    throw new InvalidArgumentException(
                        "Please upload image " . ($index + 1) . "."
                    );
                }

                $file = $_FILES[$field];

                if (
                    !is_uploaded_file($file['tmp_name']) ||
                    $file['size'] <= 0 ||
                    $file['size'] > 5 * 1024 * 1024
                ) {
                    throw new InvalidArgumentException(
                        'Each image must be under 5 MB.'
                    );
                }

                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($file['tmp_name']);

                if (
                    !isset($allowedMimeTypes[$mimeType]) ||
                    @getimagesize($file['tmp_name']) === false
                ) {
                    throw new InvalidArgumentException(
                        'Use a valid JPG, PNG, or WebP image.'
                    );
                }

                $filename = bin2hex(random_bytes(16))
                    . '.'
                    . $allowedMimeTypes[$mimeType];

                $destination = $uploadDirectory . '/' . $filename;

                if (
                    !move_uploaded_file(
                        $file['tmp_name'],
                        $destination
                    )
                ) {
                    throw new RuntimeException(
                        'Could not upload a product image.'
                    );
                }

                // Remember the physical file for cleanup on failure.
                $uploadedFiles[] = $destination;

                // Save the relative path in the database.
                $images[] = [
                    'path' => 'public/images/products/' . $filename,
                    'order' => $index + 1
                ];
            }

            // 6. Save everything using the Product model.
            $product = new Product();

            $productId = $product->createComplete(
                $data,
                $images,
                $addons,
                $variants
            );

            // 7. Redirect after successful creation.
            Flight::redirect('/final-project/admin-products');
            return;

        } catch (InvalidArgumentException $error) {
            // Delete any files already uploaded.
            foreach ($uploadedFiles as $path) {
                if (is_file($path)) {
                    unlink($path);
                }
            }

            Flight::halt(400, $error->getMessage());
            return;

        } catch (Throwable $error) {
            // Also clean up files if the database operation fails.
            foreach ($uploadedFiles as $path) {
                if (is_file($path)) {
                    unlink($path);
                }
            }

            error_log($error->__toString());

            Flight::halt(
                500,
                'Could not save the product. Check the server error log.'
            );
            return;
        }
    }

public function openProduct($id): void
{
    try {
        $productModel = new Product();

        $products = $productModel->getProduct('id', $id);

        // Check whether the product exists.
        if (empty($products)) {
            Flight::halt(404, 'Product not found.');
            return;
        }

        // Get the single product from the array.
        // $product = reset($products);
        // echo '<pre>';
        // var_dump($products);
        // echo '</pre>';
        // die();

        Flight::render('product.twig', [
            'products' => $products
        ]);

    } catch (InvalidArgumentException $error) {
        Flight::halt(400, $error->getMessage());
        return;

    } catch (Throwable $error) {
        error_log($error->__toString());

        Flight::halt(500, $error->getMessage());
        return;
    }
}
}

?>