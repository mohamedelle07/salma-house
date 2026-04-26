<?php
require_once __DIR__ . '/../app/models/Product.php';

$product = new Product(
    1,
    "Chocolate Cake",
    "Very good cake",
    25.5,
    "cake.jpg",
    2
);

echo $product->getName();
echo "<br>";
echo $product->getPrice();