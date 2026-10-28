<?php
namespace App\Controllers;

use App\Models\User;
use Flight;
use Throwable;

class AdminAuthController
{
    public function login(): void
    {
        try {
            $id = filter_var($_SESSION['admin_user'] ?? null, FILTER_VALIDATE_INT);
            if ($id !== false && $id > 0 && (new User())->getAdministrator($id) !== null) {
                Flight::redirect('/admin', 303);
                return;
            }
            unset($_SESSION['admin_user'], $_SESSION['admin_csrf']);
            $this->renderLogin();
        } catch (Throwable $error) {
            error_log('Admin login display failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            Flight::halt(500, 'Could not load administrator sign-in. Please try again.');
        }
    }

    private function renderLogin(?string $error = null, string $email = ''): void
    {
        Flight::response()->header('Cache-Control', 'no-store, private');
        $_SESSION['admin_login_csrf'] ??= bin2hex(random_bytes(32));
        Flight::render('admin-login.twig', [
            'error' => $error,
            'email' => $email,
            'csrf_token' => $_SESSION['admin_login_csrf'],
        ]);
    }

    public function authenticate(): void
    {
        $email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
        $password = $_POST['password'] ?? null;
        $token = $_POST['csrf_token'] ?? null;
        try {
            if (!is_string($token) || !isset($_SESSION['admin_login_csrf']) || !hash_equals($_SESSION['admin_login_csrf'], $token)) {
                $this->renderLogin('Your sign-in form expired. Please try again.', $email);
                return;
            }
            if (strlen($email) > 150 || !filter_var($email, FILTER_VALIDATE_EMAIL) || !is_string($password) || $password === '' || strlen($password) > 4096) {
                $this->renderLogin('Enter a valid email address and password.', $email);
                return;
            }
            $user = (new User())->getByEmail($email);
            if ($user === null || !password_verify($password, $user['password']) || $user['role'] !== 'admin') {
                $this->renderLogin('Invalid administrator email or password.', $email);
                return;
            }
            session_regenerate_id(true);
            $_SESSION['admin_user'] = (int) $user['id'];
            $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
            unset($_SESSION['admin_login_csrf'], $_SESSION['admin_error'], $_SESSION['admin_success'], $_SESSION['admin_product_values']);
            Flight::redirect('/admin', 303);
        } catch (Throwable $error) {
            error_log('Admin login failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            $this->renderLogin('Could not sign in. Please try again.', $email);
        }
    }

    public function logout(): void
    {
        $token = $_POST['csrf_token'] ?? null;
        if (!is_string($token) || !isset($_SESSION['admin_csrf']) || !hash_equals($_SESSION['admin_csrf'], $token)) {
            Flight::halt(403, 'Please reload the admin page and try again.');
            return;
        }
        unset($_SESSION['admin_user'], $_SESSION['admin_csrf'], $_SESSION['admin_login_csrf'], $_SESSION['admin_error'], $_SESSION['admin_success'], $_SESSION['admin_product_values']);
        session_regenerate_id(true);
        Flight::redirect('/admin/login', 303);
    }
}
