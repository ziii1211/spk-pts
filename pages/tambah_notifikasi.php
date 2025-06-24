<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);

    mysqli_query($conn, "INSERT INTO notifikasi (judul, isi) VALUES ('$judul', '$isi')");
    header("Location: notifikasi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Notifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Notifikasi</h2>
        <form method="post">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Isi</label>
                <textarea name="isi" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
            <a href="notifikasi.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
