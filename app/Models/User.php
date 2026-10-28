<?php
namespace App\Models;

use App\Database\Database;
use mysqli;
class User
{
    private mysqli $db;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->getConnection();
    }

    public function getUsers()
    {
        $sql = "SELECT * FROM users";

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT name, email, phone_number FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $user ?: null;
    }

    public function getByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT id, password, role FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $user ?: null;
    }

    public function getAdministrator(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, name, email, phone_number FROM users WHERE id = ? AND role = 'admin'");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user ?: null;
    }

    public function makeAdministrator(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        if ($this->getAdministrator($id) === null) {
            throw new \InvalidArgumentException('Account not found.');
        }
    }

    public function createAdministrator(string $name, string $email, string $phoneNumber, string $password): int
    {
        $name = trim($name);
        $email = trim($email);
        $phoneNumber = trim($phoneNumber);
        if ($name === '' || mb_strlen($name) > 100 || strlen($email) > 150 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Enter a name of up to 100 characters and a valid email address.');
        }
        if (strlen($phoneNumber) > 20 || !preg_match('/\A\+?[0-9 ()-]+\z/', $phoneNumber) || !preg_match('/\A[0-9]{7,15}\z/', preg_replace('/\D/', '', $phoneNumber))) {
            throw new \InvalidArgumentException('Contact number must contain 7 to 15 digits.');
        }
        if (mb_strlen($password) < 12 || strlen($password) > 72 || str_contains($password, "\0")) {
            throw new \InvalidArgumentException('A new administrator password must have at least 12 characters and at most 72 bytes, without null characters.');
        }
        $this->db->begin_transaction();
        try {
            $this->register($name, $email, $phoneNumber, $password);
            $id = $this->db->insert_id;
            $this->makeAdministrator($id);
            $this->db->commit();
            return $id;
        } catch (\Throwable $error) {
            $this->db->rollback();
            throw $error;
        }
    }

     public function register( string $name, string $email, string $phoneNumber, string $password):bool {
        $hashedPassword = password_hash( $password, PASSWORD_DEFAULT);
        $sql = " INSERT INTO users (name, email, phone_number, password, role) VALUES (?, ?, ?, ?, 'customer')";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "ssss",
            $name,
            $email,
            $phoneNumber,
            $hashedPassword
        );
        return $stmt->execute();
    }

}
