<?php

require_once __DIR__ . '/Product.php';

class ProductManager
{

    private PDO $connection;

    // FIXED: accept PDO directly
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function create(Product $product): bool
    {
        $sql = 'INSERT INTO products (name, description, price, image, category_id) 
                VALUES (:name, :description, :price, :image, :category_id)';
        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            ':name' => $product->getName(),
            ':description' => $product->getDescription(),
            ':price' => $product->getPrice(),
            ':image' => $product->getImage(),
            ':category_id' => $product->getCategoryId(),
        ]);
    }

    public function getAll(): array
    {
        $sql = 'SELECT id, name, description, price, image, category_id FROM products';
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $products = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['image'],
                $row['category_id']
            );
        }

        return $products;
    }

    public function getById($id): ?Product
    {
        $sql = 'SELECT id, name, description, price, image, category_id 
                FROM products 
                WHERE id = :id';
        $statement = $this->connection->prepare($sql);
        $statement->execute([':id' => $id]);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Product(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['price'],
            $row['image'],
            $row['category_id']
        );
    }

    public function update(Product $product): bool
    {
        $sql = 'UPDATE products 
                SET name = :name,
                    description = :description,
                    price = :price,
                    image = :image,
                    category_id = :category_id
                WHERE id = :id';

        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            ':id' => $product->getId(),
            ':name' => $product->getName(),
            ':description' => $product->getDescription(),
            ':price' => $product->getPrice(),
            ':image' => $product->getImage(),
            ':category_id' => $product->getCategoryId(),
        ]);
    }

    public function delete($id): bool
    {
        $sql = 'DELETE FROM products WHERE id = :id';
        $statement = $this->connection->prepare($sql);

        return $statement->execute([':id' => $id]);
    }

public function search($filters): array
{
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    if (!empty($filters['name'])) {
        $sql .= " AND name LIKE :name";
        $params[':name'] = '%' . $filters['name'] . '%';
    }

    if (!empty($filters['category_id'])) {
        $sql .= " AND category_id = :category_id";
        $params[':category_id'] = $filters['category_id'];
    }

    if (!empty($filters['max_price'])) {
        $sql .= " AND price <= :max_price";
        $params[':max_price'] = $filters['max_price'];
    }

    $stmt = $this->connection->prepare($sql);
    $stmt->execute($params);

    $products = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $products[] = new Product(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['price'],
            $row['image'],
            $row['category_id']
        );
    }

    return $products;
}    }

