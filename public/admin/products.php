<?php

require_once __DIR__ . '/../../app/middleware/Auth.php';
Auth::adminOnly();

require_once __DIR__ . '/../../app/config/Database.php';
require_once __DIR__ . '/../../app/models/Product.php';
require_once __DIR__ . '/../../app/models/ProductManager.php';
require_once __DIR__ . '/../../app/controllers/AdminProductController.php';
require_once __DIR__ . '/../../app/services/Uploader.php';

$db = Database::getInstance()->getConnection();
$pm = new ProductManager($db);
$admin = new AdminProductController($pm);

$uploader = new Uploader(__DIR__ . '/../uploads');

/* DELETE */
if (isset($_GET['delete'])) {
    $admin->delete($_GET['delete']);
    header("Location: products.php");
    exit;
}

/* CREATE */
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['update'])) {

    $imageName = $uploader->upload($_FILES['image']);

    $admin->store([
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'image' => $imageName,
        'category_id' => $_POST['category_id']
    ]);

    header("Location: products.php");
    exit;
}

/* UPDATE */
if (isset($_POST['update'])) {

    $imageName = $_POST['old_image'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = $uploader->upload($_FILES['image']);
    }

    $admin->update([
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'image' => $imageName,
        'category_id' => $_POST['category_id']
    ]);

    header("Location: products.php");
    exit;
}

/* EDIT */
$editProduct = null;
if (isset($_GET['edit'])) {
    $editProduct = $pm->getById($_GET['edit']);
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

<h1>Admin Panel</h1>

<p style="text-align:center;">
    <a href="/salma-house/public/products.php">Store</a> |
    <a href="/salma-house/public/logout.php">Logout</a>
</p>

<?php if ($editProduct): ?>

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $editProduct->getId() ?>">
    <input type="hidden" name="old_image" value="<?= $editProduct->getImage() ?>">

    <input type="text" name="name" value="<?= $editProduct->getName() ?>" required>

    <input type="text" name="description" value="<?= $editProduct->getDescription() ?>" required>

    <input type="number" step="0.01" name="price" value="<?= $editProduct->getPrice() ?>" required>

    <input type="file" name="image">

    <input type="number" name="category_id" value="<?= $editProduct->getCategoryId() ?>" required>

    <button type="submit" name="update">Update</button>

</form>

<?php else: ?>

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="description" placeholder="Description" required>
    <input type="number" step="0.01" name="price" placeholder="Price" required>

    <input type="file" name="image">

    <input type="number" name="category_id" placeholder="Category ID" required>

    <button type="submit">Add</button>

</form>

<?php endif; ?>

<h2>All Products</h2>

<div class="container">

<?php foreach ($products as $p): ?>

    <div class="product-card">

        <?php if ($p->getImage()): ?>
            <img src="/salma-house/public/uploads/<?= $p->getImage() ?>" width="120">
        <?php endif; ?>

        <h3><?= $p->getName() ?></h3>

        <p><?= $p->getDescription() ?></p>

        <p class="price"><?= $p->getPrice() ?> TND</p>

        <a href="?edit=<?= $p->getId() ?>">Edit</a> |
        <a href="?delete=<?= $p->getId() ?>">Delete</a>

    </div>

<?php endforeach; ?>

</div>

</body>
</html>