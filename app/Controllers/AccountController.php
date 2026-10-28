<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Middleware\AuthMiddleware;
use Flight;
use InvalidArgumentException;
use Throwable;

class AccountController
{
    public function index(): void
    {
        $userId = filter_var($_SESSION['user'] ?? null, FILTER_VALIDATE_INT);
        if ($userId === false || $userId < 1) {
            Flight::redirect('/login');
            return;
        }

        try {
            $customer = (new User())->getById($userId);
            if ($customer === null) {
                unset($_SESSION['user']);
                Flight::redirect('/login');
                return;
            }
            $names = preg_split('/\s+/u', trim($customer['name']), -1, PREG_SPLIT_NO_EMPTY);
            $initials = '';
            if ($names) {
                $initials = mb_substr($names[0], 0, 1);
                if (count($names) > 1) {
                    $initials .= mb_substr($names[count($names) - 1], 0, 1);
                }
            }
            $_SESSION['account_csrf'] ??= bin2hex(random_bytes(32));
            $notice = $_SESSION['account_notice'] ?? null;
            $accountError = $_SESSION['account_error'] ?? null;
            unset($_SESSION['account_notice'], $_SESSION['account_error']);
            Flight::render('account.twig', [
                'customer' => $customer,
                'initials' => mb_strtoupper($initials),
                'orders' => (new Order())->getForCurrentUser(),
                'cart_count' => (new Cart())->getCount(),
                'csrf_token' => $_SESSION['account_csrf'],
                'account_notice' => $notice,
                'account_error' => $accountError,
            ]);
        } catch (Throwable $error) {
            error_log('Account display failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::halt(500, 'Could not load your account. Please try again.');
        }
    }

    public function cancelOrder(string $id): void
    {
        if (!AuthMiddleware::requireLogin()) {
            return;
        }
        $token = $_POST['csrf_token'] ?? null;
        if (!is_string($token) || !isset($_SESSION['account_csrf']) || !hash_equals($_SESSION['account_csrf'], $token)) {
            Flight::halt(403, 'Please reload your account and try again.');
            return;
        }
        try {
            $orderId = filter_var($id, FILTER_VALIDATE_INT);
            if ($orderId === false || $orderId < 1) {
                throw new InvalidArgumentException('Invalid order ID.');
            }
            (new Order())->cancelForCurrentUser($orderId);
            $_SESSION['account_notice'] = 'Your order has been cancelled.';
        } catch (InvalidArgumentException $error) {
            $_SESSION['account_error'] = $error->getMessage();
        } catch (Throwable $error) {
            error_log('Order cancellation failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            $_SESSION['account_error'] = 'Could not cancel your order. Please try again.';
        }
        Flight::redirect('/account#orders', 303);
    }
}
