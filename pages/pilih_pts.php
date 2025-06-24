<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Ambil semua PTS
$query_pts = mysqli_query($conn, "SELECT * FROM pts");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pilih PTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Pilih PTS untuk Pembobotan Kriteria</h2>

    <table class="table table-striped">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama PTS</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($query_pts)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_pts']); ?></td>
                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                    <td>
                        <a href="pembobotan_kriteria.php?pts_id=<?= $row['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Lanjut Pembobotan
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
