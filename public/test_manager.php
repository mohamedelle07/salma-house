<?php
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/ProductManager.php';

$db = Database::getInstance()->getConnection();

$pm = new ProductManager($db);

$products = $pm->getAll();

foreach ($products as $p) {
    echo $p->getName() . " - " . $p->getPrice() . "<br>";
}