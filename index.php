<?php
session_start();

if (isset($_SESSION['role'])) {
    // Jika sudah login, redirect dashboard
    if ($_SESSION['role'] == 'admin') {
        header("Location: pages/dashboard_admin.php");
    } elseif ($_SESSION['role'] == 'user') {
        header("Location: pages/dashboard_user.php");
    }
} else {
    // Kalau belum login
    header("Location: pages/login.php");
}
?>
