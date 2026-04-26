<?php

class Auth
{
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: /salma-house/public/login.php");
            exit;
        }
    }

    public static function adminOnly()
    {
        self::check();

        if ($_SESSION['user']['role'] !== 'admin') {
            echo "Access denied (Admin only)";
            exit;
        }
    }
}