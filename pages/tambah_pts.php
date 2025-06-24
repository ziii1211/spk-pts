<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $nama_pts = mysqli_real_escape_string($conn, $_POST['nama_pts']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    mysqli_query($conn, "INSERT INTO pts (nama_pts, alamat) VALUES ('$nama_pts', '$alamat')");
    header("Location: total_pts.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah PTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah PTS</h2>
        <form method="post">
            <div class="mb-3">
                <label>Nama PTS</label>
                <input type="text" name="nama_pts" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" rows="3" class="form-control" required></textarea>
            </div>
            <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
            <a href="total_pts.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
