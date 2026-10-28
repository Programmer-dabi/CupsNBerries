<?php
// Local administrator provisioning only. This file cannot run as a web endpoint.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require dirname(__DIR__) . '/app/Database/database.php';

use App\Models\User;

function adminPrompt(string $label): string
{
    fwrite(STDOUT, $label);
    $value = fgets(STDIN);
    if ($value === false) {
        throw new RuntimeException('Input cancelled.');
    }
    return rtrim($value, "\r\n");
}

function adminPassword(string $label): string
{
    $terminalState = null;
    if (function_exists('stream_isatty') && stream_isatty(STDIN)) {
        if (!function_exists('exec')) {
            throw new RuntimeException('This PHP runtime cannot hide terminal password input.');
        }
        $output = [];
        exec('stty -g', $output, $code);
        if ($code !== 0 || $output === []) {
            throw new RuntimeException('Could not prepare hidden password entry.');
        }
        $terminalState = $output[0];
        exec('stty -echo', $unused, $code);
        if ($code !== 0) {
            throw new RuntimeException('Could not hide password entry.');
        }
    }
    try {
        return adminPrompt($label);
    } finally {
        if ($terminalState !== null) {
            exec('stty ' . escapeshellarg($terminalState));
            fwrite(STDOUT, "\n");
        }
    }
}

try {
    fwrite(STDOUT, "Cups & Berries — administrator setup\nCreates a new administrator or grants access to an existing account.\n");
    $email = trim(adminPrompt('Administrator email: '));
    if (strlen($email) > 150 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Enter a valid email address.');
    }
    $users = new User();
    $existing = $users->getByEmail($email);
    if ($existing !== null) {
        $users->makeAdministrator((int) $existing['id']);
        fwrite(STDOUT, "Administrator access granted. The account's password was kept.\nSign in at /admin/login with its email and existing password.\n");
        exit;
    }
    $name = trim(adminPrompt('Full name: '));
    $phone = trim(adminPrompt('Contact number: '));
    $password = adminPassword('Password (at least 12 characters, at most 72 bytes): ');
    $confirmation = adminPassword('Confirm password: ');
    if ($password !== $confirmation) {
        throw new InvalidArgumentException('Passwords do not match.');
    }
    $users->createAdministrator($name, $email, $phone, $password);
    unset($password, $confirmation);
    fwrite(STDOUT, "Administrator created. Sign in at /admin/login with the email and password you entered.\n");
} catch (Throwable $error) {
    $message = $error instanceof mysqli_sql_exception ? 'Database setup failed. Check the database configuration and role migration.' : $error->getMessage();
    fwrite(STDERR, $message . "\n");
    exit(1);
}
