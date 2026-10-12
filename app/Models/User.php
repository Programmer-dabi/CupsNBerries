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

     public function register( string $name, string $email, string $phoneNumber, string $password):bool {
        $hashedPassword = password_hash( $password, PASSWORD_DEFAULT);
        $sql = " INSERT INTO users (name, email, phone_number, password) VALUES (?, ?, ?, ?)";

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