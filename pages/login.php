<?php
session_start();
include "../config/db.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_array($query);

    if ($data) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // Redirect ke dashboard sesuai role
        if ($data['role'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_user.php");
        }
    } else {
        echo "<script>alert('Login gagal! Cek username & password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SPK PTS</title>
    <link rel="stylesheet" href="../assets/css/style_login.css">
</head>
<link rel="stylesheet" href="../assets/css/style_login.css">
<body>

<div class="login-container">
    <h2>SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN PTS DI SUKAMARA MENGGUNAKAN METODE FUZZY AHP BERBASIS WEB </h2>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Register disini</a></p>
</div>

</body>
</html>
