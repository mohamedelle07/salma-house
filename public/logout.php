<a href="logout.php">Logout</a>
<?php

session_start();

session_unset();
session_destroy();

header("Location: /salma-house/public/login.php");
exit;