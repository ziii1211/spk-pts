<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM notifikasi ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Manajemen Notifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Manajemen Notifikasi</h2>
        <a href="tambah_notifikasi.php" class="btn btn-primary mb-3">Tambah Notifikasi</a>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <td><?= nl2br(htmlspecialchars($row['isi'])); ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td>
                            <a href="hapus_notifikasi.php?id=<?= $row['id']; ?>" 
                               onclick="return confirm('Yakin ingin hapus notifikasi ini?');" 
                               class="btn btn-danger btn-sm">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="dashboard_admin.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>
</body>
</html>
