<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/UserManager.php';

$db = Database::getInstance()->getConnection();
$userManager = new UserManager($db);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $userManager->getByEmail($email);

    if ($user && password_verify($password, $user['password'])) {

        // Store user in session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'role' => $user['role']
        ];

        // Redirect after login (IMPORTANT)
        header("Location: /salma-house/public/products.php");
        exit;

    } else {
        $message = "Invalid credentials";
    }
}
?>

<!-- LOGIN FORM -->
<!DOCTYPE html>
<html>
<head>
    <title>Login - Salma's House</title>
    <link rel="stylesheet" href="/salma-house/public/assets/style.css">
</head>
<body>

<h2>Login</h2>

<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>