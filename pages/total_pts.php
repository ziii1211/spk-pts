<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit();
}

$query_pts = mysqli_query($conn, "
    SELECT * FROM pts
");

// Link dashboard
$dashboard_link = 'dashboard_admin.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Total PTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Daftar PTS</h2>

        <a href="tambah_pts.php" class="btn btn-primary mb-3">
            Tambah PTS
        </a>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama PTS</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query_pts)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_pts']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td>
                            <a href="hapus_pts.php?id=<?= $row['id']; ?>" 
                               onclick="return confirm('Yakin ingin hapus PTS ini?');" 
                               class="btn btn-danger btn-sm">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="<?= $dashboard_link; ?>" class="btn btn-secondary mt-3">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
