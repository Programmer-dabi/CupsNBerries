<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Middleware\AuthMiddleware;
use DateTimeImmutable;
use DateTimeZone;
use Flight;
use InvalidArgumentException;
use Throwable;

class OrderController
{
    public function place(): void
    {
        if (!AuthMiddleware::requireLogin(str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json'))) {
            return;
        }

        $values = [];
        foreach (['name', 'phone_number', 'email', 'payment_method', 'pickup_at', 'notes', 'barangay', 'street', 'house_no'] as $field) {
            $values[$field] = is_string($_POST[$field] ?? null) ? trim($_POST[$field], " \t\n\r\v") : '';
        }
        $errors = [];
        if ($values['name'] === '') {
            $errors['name'] = 'Full name is required.';
        } elseif (mb_strlen($values['name']) > 100) {
            $errors['name'] = 'Full name must be 100 characters or fewer.';
        }
        if ($values['phone_number'] === '') {
            $errors['phone_number'] = 'Contact number is required.';
        } elseif (strlen($values['phone_number']) > 20 || !preg_match('/\A\+?[0-9 ()-]+\z/', $values['phone_number']) || !preg_match('/\A[0-9]{7,15}\z/', preg_replace('/\D/', '', $values['phone_number']))) {
            $errors['phone_number'] = 'Enter a valid contact number with 7 to 15 digits.';
        }
        if ($values['email'] === '') {
            $errors['email'] = 'Email address is required.';
        } elseif (strlen($values['email']) > 150 || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter a valid email address (150 characters or fewer).';
        }
        if (!array_key_exists($values['payment_method'], Order::PAYMENT_METHODS)) {
            $errors['payment_method'] = 'Choose a valid mode of payment.';
        }
        $errors = array_merge($errors, Order::deliveryAddressErrors($values));
        $pickup = null;
        if ($values['payment_method'] === 'store_pickup') {
            foreach (Order::ADDRESS_FIELDS as $field => $settings) {
                $values[$field] = '';
            }
            $timezone = new DateTimeZone('Asia/Manila');
            $pickup = preg_match('/\A[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}\z/', $values['pickup_at'])
                ? DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $values['pickup_at'], $timezone)
                : false;
            $dateErrors = DateTimeImmutable::getLastErrors();
            if ($values['pickup_at'] === '') {
                $errors['pickup_at'] = 'Pickup date and time are required.';
            } elseif (!$pickup || ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0)) || $pickup->format('Y-m-d\TH:i') !== $values['pickup_at']) {
                $errors['pickup_at'] = 'Enter a valid pickup date and time.';
            } elseif ($pickup <= new DateTimeImmutable('now', $timezone)) {
                $errors['pickup_at'] = 'Choose a pickup date and time in the future.';
            }
        } else {
            $values['pickup_at'] = '';
        }
        if (mb_strlen($values['notes']) > 2000) {
            $errors['notes'] = 'Order notes must be 2,000 characters or fewer.';
        }
        $token = $_POST['checkout_token'] ?? null;
        if (!is_string($token) || !isset($_SESSION['checkout_token']) || !hash_equals($_SESSION['checkout_token'], $token)) {
            $errors['form'] = 'Your checkout form has expired. Please review your details and submit again.';
        }
        if ($errors !== []) {
            $this->returnToCheckout($values, $errors);
            return;
        }

        try {
            $details = $values;
            $details['pickup_at'] = $pickup ? $pickup->format('Y-m-d H:i:s') : null;
            $order = (new Order())->create($details, $token);
            $_SESSION['checkout_completed_token'] = $token;
            unset($_SESSION['checkout_values'], $_SESSION['checkout_errors']);
            Flight::redirect('/order-success/' . $order['order_number'], 303);
        } catch (InvalidArgumentException $error) {
            $this->returnToCheckout($values, ['cart' => $error->getMessage()]);
        } catch (Throwable $error) {
            error_log('Order placement failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            $this->returnToCheckout($values, ['form' => 'Could not place your order. Please try again.']);
        }
    }

    public function success(string $number): void
    {
        try {
            if (!preg_match('/\AKP-[A-F0-9]{12}\z/', $number)) {
                Flight::halt(404, 'Order not found.');
                return;
            }
            $order = (new Order())->getByNumber($number);
            if ($order === null) {
                Flight::halt(404, 'Order not found.');
                return;
            }
            $order['pickup_time'] = $order['pickup_at'] !== null ? new DateTimeImmutable($order['pickup_at'], new DateTimeZone('Asia/Manila')) : null;
            Flight::render('order-success.twig', [
                'order' => $order,
                'cart_count' => (new Cart())->getCount(),
            ]);
        } catch (Throwable $error) {
            error_log('Order confirmation failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::halt(500, 'Could not load your order confirmation. Please try again.');
        }
    }

    public function tracking(string $id): void
    {
        $orderId = filter_var($id, FILTER_VALIDATE_INT);
        if ($orderId === false || $orderId < 1) {
            Flight::halt(404, 'Order not found.');
            return;
        }

        try {
            $order = (new Order())->getById($orderId);
            if ($order === null) {
                Flight::halt(404, 'Order not found.');
                return;
            }
            $order['pickup_time'] = $order['pickup_at'] !== null ? new DateTimeImmutable($order['pickup_at'], new DateTimeZone('Asia/Manila')) : null;
            Flight::render('tracking.twig', array_merge($this->trackingState($order['status'], $order['payment_method']), [
                'order' => $order,
                'cart_count' => (new Cart())->getCount(),
            ]));
        } catch (Throwable $error) {
            error_log('Order tracking failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::halt(500, 'Could not load your order. Please try again.');
        }
    }

    public function trackingStatus(string $id): void
    {
        Flight::response()->header('Cache-Control', 'no-store, private');
        $orderId = filter_var($id, FILTER_VALIDATE_INT);
        if ($orderId === false || $orderId < 1) {
            Flight::json(['success' => false, 'message' => 'Order not found.'], 404);
            return;
        }
        try {
            $order = (new Order())->getTrackingStatus($orderId);
            if ($order === null) {
                Flight::json(['success' => false, 'message' => 'Order not found.'], 404);
                return;
            }
            Flight::json(array_merge(['success' => true], $this->trackingState($order['status'], $order['payment_method'])));
        } catch (Throwable $error) {
            error_log('Order status refresh failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::json(['success' => false, 'message' => 'Could not refresh your order status.'], 500);
        }
    }

    private function trackingState(string $status, string $paymentMethod): array
    {
        $gcash = $paymentMethod === 'gcash';
        $delivery = $gcash || $paymentMethod === 'cash_on_delivery';
        $steps = match ($paymentMethod) {
            'gcash' => ['Placed order', 'Order confirmed', 'Payed', 'Preparing your order', 'On delivery', 'Completed'],
            'cash_on_delivery' => ['Placed order', 'Order confirmed', 'Preparing your order', 'Delivery', 'Completed'],
            default => ['Placed order', 'Order confirmed', 'Preparing your order', 'Ready for pickup', 'Completed'],
        };
        $normalized = strtolower(trim(preg_replace('/[\s_-]+/', ' ', $status)));
        $normalized = str_replace('pick up', 'pickup', $normalized);
        [$step, $heading, $class] = match ($normalized) {
            'placed order' => [1, 'Your order has been placed and is awaiting confirmation.', 'placed_order'],
            'confirmed' => [2, 'We have received your order.', 'confirmed'],
            'pending' => [1, 'We have received your order.', 'pending'],
            'preparing' => [$gcash ? 4 : 3, 'Your order is being prepared.', 'preparing'],
            'ready', 'ready for pickup', 'ready to pickup' => $delivery
                ? ($gcash ? [4, 'Your order is ready for delivery.', 'ready'] : [4, 'Your order is on delivery.', 'delivery'])
                : [4, 'Your order is ready for pickup.', 'ready'],
            'paid', 'payed' => $gcash ? [3, 'Your payment has been confirmed.', 'payed'] : [0, 'Your order status', ''],
            'delivery', 'on delivery', 'out for delivery' => $delivery
                ? [$gcash ? 5 : 4, 'Your order is on delivery.', 'delivery'] : [0, 'Your order status', ''],
            'completed', 'complete', 'picked up', 'collected' => [count($steps), 'Your order is complete.', 'completed'],
            'cancelled', 'canceled' => [0, 'Your order has been cancelled.', 'cancelled'],
            default => [0, 'Your order status', ''],
        };
        return [
            'status' => $paymentMethod === 'cash_on_delivery' && in_array($normalized, ['ready', 'ready for pickup', 'ready to pickup'], true) ? 'Delivery' : $status,
            'progress_step' => $step,
            'tracking_heading' => $heading,
            'status_class' => $class,
            'tracking_steps' => $steps,
        ];
    }

    private function returnToCheckout(array $values, array $errors): void
    {
        $_SESSION['checkout_values'] = $values;
        $_SESSION['checkout_errors'] = $errors;
        Flight::redirect('/checkout', 303);
    }
}
