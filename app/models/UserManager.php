<?php

class UserManager
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    // Get user by email (used for login)
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Optional: create user (if needed later)
    public function create($name, $email, $password, $role = 'user')
    {
        $sql = "INSERT INTO users (name, email, password, role)
                VALUES (:name, :email, :password, :role)";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role
        ]);
    }
}