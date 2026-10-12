<?php
namespace App\Database;

use mysqli;
use Dotenv\Dotenv;

// Load Composer's autoloader
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->safeLoad();

class Database
{
    private string $host;
    private string $username;
    private string $password;
    private string $database;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->database = $_ENV['DB_DATABASE'];
    }

    // Return the MySQLi connection
     public function getConnection(): mysqli
    {
        $connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($connection->connect_error) {
            throw new \RuntimeException(
                'Database connection failed: ' . $connection->connect_error
            );
        }

        $connection->set_charset('utf8mb4');

        return $connection;
    }
}

?>