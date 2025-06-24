<?php
include "../config/db.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama = $_POST['nama'];
    $role = $_POST['role']; // ambil role dari form

    $query = mysqli_query($conn, "INSERT INTO users (username, password, role, nama) 
                                  VALUES ('$username', '$password', '$role', '$nama')");

    if ($query) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - SPK PTS</title>
    <link rel="stylesheet" href="../assets/css/style_register.css">
</head>
<body>

<div class="register-container">
    <h2>Register Akun Baru</h2>
    <form method="post" action="">
        <input type="text" name="nama" placeholder="Nama Lengkap" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <!-- Tambahkan pilihan role -->
        <label for="role">Daftar sebagai:</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <button type="submit" name="register">Register</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
</div>

</body>
</html>
