<?php

require_once '../app/config/Database.php';
require_once '../app/models/ProductManager.php';
require_once '../app/controllers/ProductController.php';

$db = Database::getInstance()->getConnection();
$pm = new ProductManager($db);
$pc = new ProductController($pm);

$products = $pc->index();

foreach ($products as $p) {
    echo $p->getName() . "<br>";
}