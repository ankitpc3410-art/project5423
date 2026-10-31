<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

function requireRole($role)
{
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: ../index.php");
        exit;
    }
}
?>