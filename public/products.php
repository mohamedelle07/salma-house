<?php

require_once __DIR__ . '/../app/middleware/Auth.php';
Auth::check();

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/Product.php';
require_once __DIR__ . '/../app/models/ProductManager.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';

$db = Database::getInstance()->getConnection();
$pm = new ProductManager($db);
$pc = new ProductController($pm);

/* SEARCH FILTERS */
$filters = [
    'name' => $_GET['name'] ?? '',
    'category_id' => $_GET['category_id'] ?? '',
    'max_price' => $_GET['max_price'] ?? ''
];

/* DECIDE SEARCH OR ALL */
if (!empty(array_filter($filters))) {
    $products = $pc->search($filters);
} else {
    $products = $pc->index();
}

/* LOAD VIEW */
require_once __DIR__ . '/../app/views/products/index.php';
