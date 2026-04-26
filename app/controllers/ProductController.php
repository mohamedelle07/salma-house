<?php

class ProductController
{
    private ProductManager $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    public function index(): array
    {
        return $this->productManager->getAll();
    }

    public function show($id): ?Product
    {
        return $this->productManager->getById($id);
    }

    public function create($data): bool
    {
        $product = new Product(
            null,
            $data['name'],
            $data['description'],
            $data['price'],
            $data['image'],
            $data['category_id']
        );

        return $this->productManager->create($product);
    }

    public function delete($id): bool
    {
        return $this->productManager->delete($id);
    }

    public function search($filters): array
    {
        return $this->productManager->search($filters);
    }
}