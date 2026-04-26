<?php

class AdminProductController
{
    private ProductManager $pm;

    public function __construct(ProductManager $pm)
    {
        $this->pm = $pm;
    }

    public function index()
    {
        return $this->pm->getAll();
    }

    public function store($data)
    {
        $product = new Product(
            null,
            $data['name'],
            $data['description'],
            $data['price'],
            $data['image'],
            $data['category_id']
        );

        return $this->pm->create($product);
    }

    public function delete($id)
    {
        return $this->pm->delete($id);
    }
    public function update($data)
{
    $product = new Product(
        $data['id'],
        $data['name'],
        $data['description'],
        $data['price'],
        $data['image'],
        $data['category_id']
    );

    return $this->pm->update($product);
}
}
