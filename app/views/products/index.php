<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Salma's House - Products</title>
    <link rel="stylesheet" href="/salma-house/public/assets/style.css">
</head>
<body>

<h1>Our Pastries</h1>

<!-- NAVIGATION -->
<p style="text-align:center;">

    <a href="/salma-house/public/logout.php">Logout</a>

    <!-- ADMIN LINK (ONLY FOR ADMIN) -->
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        | <a href="/salma-house/public/admin/products.php">Admin Panel</a>
    <?php endif; ?>

</p>

<!-- SEARCH FORM -->
<h2>Search</h2>

<form method="GET">

    <input type="text" name="name" placeholder="Search by name">

    <input type="number" name="category_id" placeholder="Category ID">

    <input type="number" step="0.01" name="max_price" placeholder="Max price">

    <button type="submit">Search</button>

</form>

<!-- PRODUCTS -->
<div class="container">

<?php foreach ($products as $product): ?>

    <div class="product-card">

        <?php if ($product->getImage()): ?>
            <img src="/salma-house/public/uploads/<?= $product->getImage() ?>" width="120">
        <?php endif; ?>

        <h3><?= htmlspecialchars($product->getName()) ?></h3>

        <p><?= htmlspecialchars($product->getDescription()) ?></p>

        <p class="price"><?= $product->getPrice() ?> TND</p>

    </div>

<?php endforeach; ?>

</div>

</body>
</html>