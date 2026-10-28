<?php
namespace App\Controllers;

use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Flight;
use InvalidArgumentException;
use Throwable;

class AdminController
{
    // Recheck the persisted role on every management request, including POSTs.
    private function signedInAdmin(): ?array
    {
        Flight::response()->header('Cache-Control', 'no-store, private');
        $id = filter_var($_SESSION['admin_user'] ?? null, FILTER_VALIDATE_INT);
        $user = $id !== false && $id > 0 ? (new User())->getAdministrator($id) : null;
        if ($user === null) {
            unset($_SESSION['admin_user'], $_SESSION['admin_csrf']);
            Flight::redirect('/admin/login', 303);
        }
        return $user;
    }

    private function csrf(): void
    {
        $token = $_POST['csrf_token'] ?? null;
        if (!is_string($token) || !isset($_SESSION['admin_csrf']) || !hash_equals($_SESSION['admin_csrf'], $token)) {
            throw new InvalidArgumentException('Please reload the admin page and try again.');
        }
    }

    private function positiveId(mixed $value): int
    {
        $id = filter_var($value, FILTER_VALIDATE_INT);
        if ($id === false || $id < 1 || $id > 2147483647) {
            throw new InvalidArgumentException('Invalid record ID.');
        }
        return $id;
    }

    public function index(): void
    {
        try {
            $user = $this->signedInAdmin();
            if ($user === null) { return; }
            $admin = new Admin();
            $data = $admin->dashboard();
            $modal = $_GET['modal'] ?? '';
            if (!is_string($modal) || !in_array($modal, ['', 'add-product', 'edit-product', 'stock', 'order', 'customer', 'delete-product'], true)) {
                Flight::halt(404, 'Admin form not found.');
                return;
            }
            $data['modal'] = $modal;
            $data['selected_product'] = null;
            $data['selected_variant'] = null;
            $data['selected_order'] = null;
            $data['selected_customer'] = null;
            if (in_array($modal, ['edit-product', 'stock', 'delete-product'], true)) {
                $id = $this->positiveId($_GET['product_id'] ?? null);
                $product = $data['products'][$id] ?? null;
                if ($product === null) {
                    Flight::halt(404, 'Product not found.');
                    return;
                }
                $data['selected_product'] = $product;
                if ($modal === 'stock') {
                    $variantId = isset($_GET['variant_id']) ? $this->positiveId($_GET['variant_id']) : null;
                    foreach ($product['variants'] as $variant) {
                        if ($variantId === null || (int) $variant['id'] === $variantId) {
                            $data['selected_variant'] = $variant;
                            break;
                        }
                    }
                    if ($data['selected_variant'] === null) {
                        Flight::halt(404, 'Variant not found for this product.');
                        return;
                    }
                }
            } elseif ($modal === 'order' || $modal === 'customer') {
                $id = $this->positiveId($_GET['id'] ?? null);
                $record = $modal === 'order' ? $admin->order($id) : $admin->customer($id);
                if ($record === null) {
                    Flight::halt(404, 'Record not found.');
                    return;
                }
                $data[$modal === 'order' ? 'selected_order' : 'selected_customer'] = $record;
            }
            $product = $data['selected_product'];
            $data['product_form'] = $_SESSION['admin_product_values'] ?? [
                'name' => $product['product_name'] ?? '', 'category' => $product['category'] ?? 'Coffee',
                'description' => $product['description'] ?? '', 'price' => $product['base_price'] ?? '0.00',
                'availability' => $product['availability'] ?? 'Available',
                'variants' => array_map(static fn($v) => ['id' => $v['id'], 'size_oz' => $v['size_oz'], 'price' => $v['price'], 'stock' => $v['stock_quantity']], $product['variants'] ?? []),
                'addons' => array_map(static fn($a) => ['id' => $a['id'], 'name' => $a['addon_name'], 'price' => $a['addon_price']], $product['addons'] ?? []),
            ];
            $_SESSION['admin_csrf'] ??= bin2hex(random_bytes(32));
            Flight::render('admin.twig', array_merge($data, [
                'current_user' => $user,
                'csrf_token' => $_SESSION['admin_csrf'],
                'admin_error' => $_SESSION['admin_error'] ?? null,
                'admin_success' => $_SESSION['admin_success'] ?? null,
                'allowed_categories' => Admin::CATEGORIES,
                'allowed_statuses' => $data['selected_order'] !== null
                    ? Admin::availableOrderStatuses($data['selected_order']['payment_method'], $data['selected_order']['status'])
                    : Admin::STATUSES,
            ]));
            unset($_SESSION['admin_error'], $_SESSION['admin_success'], $_SESSION['admin_product_values']);
        } catch (InvalidArgumentException $error) {
            Flight::halt(404, 'Admin record not found.');
        } catch (Throwable $error) {
            error_log('Admin display failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::halt(500, 'Could not load the admin page. Please try again.');
        }
    }

    public function newProduct(): void
    {
        try {
            if ($this->signedInAdmin() === null) { return; }
            Flight::redirect('/admin?modal=add-product', 303);
        } catch (Throwable $error) {
            error_log('Admin product form failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::halt(500, 'Could not load the product form. Please try again.');
        }
    }

    public function createProduct(): void { $this->saveProduct(null); }
    public function editProduct(string $id): void { $this->saveProduct($id); }

    private function text(mixed $value): string
    {
        return is_string($value) ? trim($value) : '';
    }

    private function formValues(): array
    {
        $form = [];
        foreach (['name', 'category', 'description', 'price', 'availability'] as $field) {
            $form[$field] = $this->text($_POST[$field] ?? null);
        }
        $form['variants'] = [];
        $form['addons'] = [];
        foreach (['variants' => ['variant_oz', 'variant_id', 'variant_price', 'variant_stock'], 'addons' => ['addon_name', 'addon_id', 'addon_price']] as $group => $fields) {
            $columns = [];
            foreach ($fields as $field) {
                $values = $_POST[$field] ?? [];
                if (!is_array($values) || count($values) > 100) {
                    throw new InvalidArgumentException('Check the product options (maximum 100 rows).');
                }
                $columns[] = array_values($values);
            }
            if (count($columns[0]) !== count($columns[2]) || ($group === 'variants' && count($columns[0]) !== count($columns[3]))) {
                throw new InvalidArgumentException('Complete every product option row.');
            }
            foreach ($columns[0] as $i => $name) {
                $row = ['id' => $this->text($columns[1][$i] ?? '0'), 'price' => $this->text($columns[2][$i] ?? null)];
                if ($group === 'variants') {
                    $row['size_oz'] = $this->text($name);
                    $row['stock'] = $this->text($columns[3][$i] ?? null);
                } else {
                    $row['name'] = $this->text($name);
                }
                $form[$group][] = $row;
            }
        }
        return $form;
    }

    private function price(string $value): float
    {
        if (!preg_match('/\A[0-9]{1,8}(?:\.[0-9]{1,2})?\z/', $value)) {
            throw new InvalidArgumentException('Prices must be non-negative amounts with at most two decimal places.');
        }
        return (float) $value;
    }

    private function stock(mixed $value): int
    {
        $quantity = filter_var($value, FILTER_VALIDATE_INT);
        if ($quantity === false || $quantity < 0 || $quantity > 4294967295) {
            throw new InvalidArgumentException('Stock must be a non-negative whole number.');
        }
        return $quantity;
    }

    private function validateProduct(array $form): array
    {
        if ($form['name'] === '' || mb_strlen($form['name']) > 150 || strlen($form['description']) > 65535) {
            throw new InvalidArgumentException('Enter a product name (up to 150 characters) and a valid description.');
        }
        if (!in_array($form['category'], Admin::CATEGORIES, true) || !in_array($form['availability'], ['Available', 'Unavailable'], true)) {
            throw new InvalidArgumentException('Select a valid category and availability.');
        }
        $data = ['product_name' => $form['name'], 'category' => $form['category'], 'description' => $form['description'], 'base_price' => $this->price($form['price']), 'availability' => $form['availability']];
        if ($form['variants'] === []) {
            throw new InvalidArgumentException('Add at least one variant with its price and initial stock.');
        }
        $variants = [];
        $names = [];
        foreach ($form['variants'] as $row) {
            $name = $row['size_oz'];
            if ($name === '' || mb_strlen($name) > 50 || isset($names[mb_strtolower($name)])) {
                throw new InvalidArgumentException('Each variant needs a different label of up to 50 characters.');
            }
            $names[mb_strtolower($name)] = true;
            $variants[] = ['id' => $row['id'] === '0' ? 0 : $this->positiveId($row['id']), 'size_oz' => $name, 'price' => $this->price($row['price']), 'stock' => $this->stock($row['stock'])];
        }
        $addons = [];
        foreach ($form['addons'] as $row) {
            if ($row['name'] === '' && $row['price'] === '' && $row['id'] === '0') { continue; }
            if ($row['name'] === '' || mb_strlen($row['name']) > 100) {
                throw new InvalidArgumentException('Each add-on needs a name of up to 100 characters.');
            }
            $addons[] = ['id' => $row['id'] === '0' ? 0 : $this->positiveId($row['id']), 'name' => $row['name'], 'price' => $this->price($row['price'])];
        }
        return [$data, $variants, $addons];
    }

    private function uploads(bool $required, array &$uploaded): array
    {
        $images = [];
        $directory = dirname(__DIR__, 2) . '/public/images/products';
        foreach ([1, 2, 3] as $order) {
            $file = $_FILES['image' . $order] ?? null;
            if (!$required && ($file === null || ($file['error'] ?? null) === UPLOAD_ERR_NO_FILE)) { continue; }
            if (!is_array($file) || ($file['error'] ?? null) !== UPLOAD_ERR_OK || !is_string($file['tmp_name'] ?? null) || !is_uploaded_file($file['tmp_name'])) {
                throw new InvalidArgumentException('Please upload all three product images when adding a product.');
            }
            $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
            $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            if (!isset($extensions[$mime]) || !is_int($file['size']) || $file['size'] < 1 || $file['size'] > 5 * 1024 * 1024 || @getimagesize($file['tmp_name']) === false) {
                throw new InvalidArgumentException('Each image must be a valid JPG, PNG, or WebP up to 5 MiB.');
            }
            if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
                throw new \RuntimeException('Image directory unavailable.');
            }
            $path = 'public/images/products/' . bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
            $destination = dirname(__DIR__, 2) . '/' . $path;
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                throw new \RuntimeException('Image upload failed.');
            }
            $uploaded[] = $destination;
            $images[] = ['path' => $path, 'order' => $order];
        }
        return $images;
    }

    private function saveProduct(?string $rawId): void
    {
        $uploaded = [];
        $id = null;
        $form = null;
        try {
            if ($this->signedInAdmin() === null) { return; }
            $this->csrf();
            $id = $rawId === null ? null : $this->positiveId($rawId);
            $form = $this->formValues();
            [$data, $variants, $addons] = $this->validateProduct($form);
            $images = $this->uploads($id === null, $uploaded);
            (new Product())->saveForAdmin($id, $data, $images, $addons, $variants);
            unset($_SESSION['admin_product_values']);
            $_SESSION['admin_success'] = $id === null ? 'Product added.' : 'Product updated. Existing variant stock was kept.';
            Flight::redirect('/admin#admin-products', 303);
        } catch (Throwable $error) {
            foreach ($uploaded as $path) { if (is_file($path)) { unlink($path); } }
            if ($form !== null) { $_SESSION['admin_product_values'] = $form; }
            $this->failure($error, $id === null ? '/admin?modal=add-product' : '/admin?modal=edit-product&product_id=' . $id);
        }
    }

    public function updateStock(string $id): void
    {
        $productId = null;
        try {
            if ($this->signedInAdmin() === null) { return; }
            $this->csrf();
            $productId = $this->positiveId($id);
            $variantId = $this->positiveId($_POST['variant_id'] ?? null);
            (new Product())->setVariantStock($productId, $variantId, $this->stock($_POST['quantity'] ?? null), $this->stock($_POST['expected_stock'] ?? null));
            $_SESSION['admin_success'] = 'Stock updated for the selected variant.';
            Flight::redirect('/admin#admin-inventory', 303);
        } catch (Throwable $error) {
            $this->failure($error, $productId === null ? '/admin' : '/admin?modal=stock&product_id=' . $productId);
        }
    }

    public function deleteProduct(string $id): void
    {
        try {
            if ($this->signedInAdmin() === null) { return; }
            $this->csrf();
            (new Product())->deleteProduct($this->positiveId($id));
            $_SESSION['admin_success'] = 'Product deleted.';
            Flight::redirect('/admin#admin-products', 303);
        } catch (Throwable $error) { $this->failure($error, '/admin#admin-products'); }
    }

    public function updateOrderStatus(string $id): void
    {
        $orderId = null;
        try {
            if ($this->signedInAdmin() === null) { return; }
            $this->csrf();
            $orderId = $this->positiveId($id);
            (new Admin())->updateOrderStatus($orderId, $this->text($_POST['status'] ?? null));
            $_SESSION['admin_success'] = 'Order status updated.';
            Flight::redirect('/admin?modal=order&id=' . $orderId, 303);
        } catch (Throwable $error) { $this->failure($error, $orderId === null ? '/admin' : '/admin?modal=order&id=' . $orderId); }
    }

    private function failure(Throwable $error, string $url): void
    {
        if ($error instanceof InvalidArgumentException) {
            $_SESSION['admin_error'] = $error->getMessage();
        } else {
            error_log('Admin update failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            $_SESSION['admin_error'] = 'Could not save your changes. Check the details and try again.';
        }
        Flight::redirect($url, 303);
    }
}
