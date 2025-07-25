<?php
namespace App\Core;

use PDO;
use PDOException;

class DataBase
{
    private static ?DataBase $database = null;
    private ?PDO $conn = null;

    private function __construct()
    {
       
    }

    public static function getInstance(): DataBase
    {
        if (self::$database === null) {
            self::$database = new DataBase();
        }
        return self::$database;
    }

    public function connect(): PDO
    {
        if ($this->conn === null) {
            try {
                $driver = $_ENV['DB_DRIVER'];
                $host = $_ENV['DB_HOST'];
                $port = $_ENV['DB_PORT'];
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $pass = $_ENV['DB_PASSWORD'];

                $dsn = "{$driver}:host={$host};port={$port};dbname={$dbname}";
                $this->conn = new PDO($dsn, $user, $pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("Erreur de connexion PDO : " . $e->getMessage());
            }
        }
        return $this->conn;
    }

    // Méthode pour créer une connexion sans spécifier de base de données (pour la création de DB)
    public function connectWithoutDB(): PDO
    {
        try {
            $driver = $_ENV['DB_DRIVER'];
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];

            $dsn = "{$driver}:host={$host};port={$port}";
            $conn = new PDO($dsn, $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn;
        } catch (PDOException $e) {
            die("Erreur de connexion PDO : " . $e->getMessage());
        }
    }
}
