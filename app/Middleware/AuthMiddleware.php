<?php

namespace App\Middleware;

class AuthMiddleware
{
    public static function isLoggedIn(): bool
    {
        $userId = filter_var($_SESSION['user'] ?? null, FILTER_VALIDATE_INT);
        return $userId !== false && $userId > 0;
    }

    public static function requireLogin(bool $json = false): bool
    {
        if (self::isLoggedIn()) {
            return true;
        }

        if ($json) {
            \Flight::json([
                'success' => false,
                'message' => 'Please sign in to add items to your cart or place an order.',
                'redirect_url' => '/login',
            ], 401);
        } else {
            \Flight::redirect('/login', 303);
        }
        return false;
    }

    public function before()
    {
        return self::requireLogin();
    }
}
?>
