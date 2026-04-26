<?php

require_once __DIR__ . '/../../app/middleware/Auth.php';
Auth::adminOnly();

require_once __DIR__ . '/../../app/config/Database.php';
require_once __DIR__ . '/../../app/models/Product.php';
require_once __DIR__ . '/../../app/models/ProductManager.php';
require_once __DIR__ . '/../../app/controllers/AdminProductController.php';

$db = Database::getInstance()->getConnection();
$pm = new ProductManager($db);
$admin = new AdminProductController($pm);

/* DELETE */
if (isset($_GET['delete'])) {
    $admin->delete($_GET['delete']);
    header("Location: products.php");
    exit;
}

/* CREATE */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $admin->store($_POST);
    header("Location: products.php");
    exit;
}

$products = $admin->index();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Products</title>
    <link rel="stylesheet" href="/salma-house/public/assets/style.css">
</head>
<body>

<h1>🍰 Salma's House - Admin Panel</h1>

<p style="text-align:center;">
    <a href="/salma-house/public/products.php">← Back to Store</a> |
    <a href="/salma-house/public/logout.php">Logout</a>
</p>

<!-- ADD PRODUCT FORM -->
<h2>Add New Product</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Product name" required>
    <input type="text" name="description" placeholder="Description" required>
    <input type="number" step="0.01" name="price" placeholder="Price (TND)" required>
    <input type="text" name="image" placeholder="Image filename (optional)">
    <input type="number" name="category_id" placeholder="Category ID" required>

    <button type="submit">➕ Add Product</button>
</form>

<!-- PRODUCTS LIST -->
<h2>All Products</h2>

<div class="container">

<?php foreach ($products as $p): ?>

    <div class="product-card">

        <h3><?= htmlspecialchars($p->getName()) ?></h3>

        <p><?= htmlspecialchars($p->getDescription()) ?></p>

        <p><strong><?= $p->getPrice() ?> TND</strong></p>

        <p>Category: <?= $p->getCategoryId() ?></p>

        <a href="?delete=<?= $p->getId() ?>"
           onclick="return confirm('Delete this product?')">
           🗑 Delete
        </a>

    </div>

<?php endforeach; ?>

</div>

</body>
</html>