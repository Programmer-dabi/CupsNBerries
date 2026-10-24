<?php
namespace App\Controllers;

use App\Models\Cart;
use Flight;
use InvalidArgumentException;
use Throwable;

class CartController
{
    public function index(): void
    {
        try {
            $data = $this->cartData(new Cart());

            if (!isset($_SESSION['cart_csrf'])) {
                $_SESSION['cart_csrf'] = bin2hex(random_bytes(32));
            }
            $error = $_SESSION['cart_error'] ?? null;
            unset($_SESSION['cart_error']);

            Flight::render('cart.twig', array_merge($data, [
                'csrf_token' => $_SESSION['cart_csrf'],
                'cart_error' => $error,
            ]));
        } catch (Throwable $error) {
            error_log('Cart display failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::halt(500, 'Could not load your cart. Please try again.');
        }
    }

    public function updateQuantity(string $key): void
    {
        $this->change($key, false);
    }

    public function remove(string $key): void
    {
        $this->change($key, true);
    }

    private function change(string $key, bool $remove): void
    {
        $wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
        $token = $_POST['csrf_token'] ?? null;
        if (!is_string($token) || !isset($_SESSION['cart_csrf']) || !hash_equals($_SESSION['cart_csrf'], $token)) {
            if ($wantsJson) {
                Flight::json(['success' => false, 'message' => 'Please reload your cart and try again.'], 403);
                return;
            }
            Flight::halt(403, 'Please reload your cart and try again.');
            return;
        }

        try {
            if (!preg_match('/\A[a-f0-9]{64}\z/', $key)) {
                throw new InvalidArgumentException('Invalid cart item.');
            }
            $cart = new Cart();
            if ($remove) {
                $cart->deleteFromCart($key);
            } else {
                $quantity = filter_var($_POST['quantity'] ?? null, FILTER_VALIDATE_INT);
                if ($quantity === false || $quantity < 1 || $quantity > 99) {
                    throw new InvalidArgumentException('Quantity must be between 1 and 99.');
                }
                $cart->updateQuantity($key, $quantity);
            }
            if ($wantsJson) {
                Flight::json(array_merge(['success' => true], $this->cartData($cart)));
                return;
            }
        } catch (InvalidArgumentException $error) {
            if ($wantsJson) {
                Flight::json(['success' => false, 'message' => $error->getMessage()], 422);
                return;
            }
            $_SESSION['cart_error'] = $error->getMessage();
        } catch (Throwable $error) {
            error_log('Cart update failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            if ($wantsJson) {
                Flight::json(['success' => false, 'message' => 'Could not update your cart. Please try again.'], 500);
                return;
            }
            $_SESSION['cart_error'] = 'Could not update your cart. Please try again.';
        }
        Flight::redirect('/cart', 303);
    }

    private function cartData(Cart $cart): array
    {
        $items = $cart->getItems();
        $subtotalCentavos = 0;
        foreach ($items as &$item) {
            $lineCentavos = (int) round($item['unit_price'] * 100) * $item['quantity'];
            $item['line_total'] = $lineCentavos / 100;
            $subtotalCentavos += $lineCentavos;
        }
        unset($item);

        return [
            'items' => $items,
            'cart_count' => array_sum(array_column($items, 'quantity')),
            'subtotal' => $subtotalCentavos / 100,
            'total' => $subtotalCentavos / 100,
        ];
    }
}
