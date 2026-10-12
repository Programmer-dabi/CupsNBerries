<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function before()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user'])) {

            // Not logged in → send them back to login
            \Flight::redirect('/');

            exit;
        }
    }
}
?>