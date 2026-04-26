<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $host = 'localhost';
        $dbName = 'salma_house';
        $username = 'root';
        $password = '';

        try {
            $this->connection = new PDO(
                "mysql:host={$host};dbname={$dbName};charset=utf8mb4",
                $username,
                $password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
