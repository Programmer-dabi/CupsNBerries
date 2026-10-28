<?php
namespace App\Controllers;
use App\Models\Product;
use App\Models\Cart;
use App\Middleware\AuthMiddleware;
use Flight;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class ProducController{

  private array $variantCategories = [
        'Coffee',
        'Tea',
        'Desserts',
        'Pastries',
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
            'products' => $products,
            'milk_options' => Cart::milkOptions(),
            'is_logged_in' => AuthMiddleware::isLoggedIn(),
            'cart_count' => (new Cart())->getCount(),
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

    public function passData($id)
    {
        header('Content-Type: application/json');


        
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

        echo json_encode([
            'Products' => $products,
            // 'name' => 'Spanish Latte'
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

    public function addToCart($id): void
    {
        if (!AuthMiddleware::requireLogin(true)) {
            return;
        }

        $contentType = explode(';', $_SERVER['CONTENT_TYPE'] ?? '')[0];
        if (strtolower(trim($contentType)) !== 'application/json') {
            Flight::json(['success' => false, 'message' => 'Send an application/json request.'], 415);
            return;
        }

        try {
            $data = json_decode(Flight::request()->getBody(), false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $error) {
            Flight::json(['success' => false, 'message' => 'Invalid JSON request body.'], 400);
            return;
        }

        $productId = filter_var($id, FILTER_VALIDATE_INT);
        if ($productId === false || $productId < 1) {
            Flight::json(['success' => false, 'message' => 'Invalid product ID.'], 422);
            return;
        }

        if (!$data instanceof \stdClass) {
            Flight::json(['success' => false, 'message' => 'Expected a JSON object.'], 422);
            return;
        }

        foreach (['variant_id', 'milk_preference', 'sugar_level', 'addon_ids'] as $field) {
            if (!property_exists($data, $field)) {
                Flight::json(['success' => false, 'message' => 'Missing field: ' . $field], 422);
                return;
            }
        }

        $quantity = property_exists($data, 'quantity') ? $data->quantity : 1;
        if (
            ($data->variant_id !== null && (!is_int($data->variant_id) || $data->variant_id < 1)) ||
            !in_array($data->milk_preference, [null, 'regular', 'oat', 'soy'], true) ||
            !in_array($data->sugar_level, [null, 100, 75, 50, 0], true) ||
            !is_array($data->addon_ids) ||
            !is_int($quantity) || $quantity < 1 || $quantity > 99
        ) {
            Flight::json(['success' => false, 'message' => 'Invalid product options.'], 422);
            return;
        }

        foreach ($data->addon_ids as $addonId) {
            if (!is_int($addonId) || $addonId < 1) {
                Flight::json(['success' => false, 'message' => 'Add-on IDs must be positive integers.'], 422);
                return;
            }
        }

        try {
            $cartModel = new Cart();
            $key = $cartModel->addToCart(
                $productId,
                $data->variant_id,
                $data->addon_ids,
                $quantity,
                $data->milk_preference,
                $data->sugar_level
            );
            Flight::json([
                'success' => true,
                'message' => 'Product added to your cart.',
                'cart_key' => $key,
                'redirect_url' => '/cart',
            ]);
        } catch (InvalidArgumentException $error) {
            Flight::json(['success' => false, 'message' => $error->getMessage()], 422);
        } catch (Throwable $error) {
            error_log('Cart save failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::json(['success' => false, 'message' => 'Could not save your cart. Please try again.'], 500);
        }
    }
}

?>
