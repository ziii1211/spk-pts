<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$pts_id = isset($_GET['pts_id']) ? $_GET['pts_id'] : 0;

// Ambil PTS
$query_pts = mysqli_query($conn, "SELECT * FROM pts WHERE id = '$pts_id'");
$data_pts = mysqli_fetch_assoc($query_pts);

// Jika tidak ada PTS
if ($pts_id == 0 || !$data_pts) {
    header("Location: pilih_pts.php");
    exit();
}

// Simulasi: hasil ranking
$hasil_ranking = [
    ['nama_pts' => $data_pts['nama_pts'], 'nilai' => 0.85],
    ['nama_pts' => 'PTS Lain 1', 'nilai' => 0.80],
    ['nama_pts' => 'PTS Lain 2', 'nilai' => 0.75]
];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Ranking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Hasil Ranking — <?= htmlspecialchars($data_pts['nama_pts']); ?></h2>

    <!-- Tabel Ranking -->
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Rank</th>
                <th>Nama PTS</th>
                <th>Nilai Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $rank = 1; foreach ($hasil_ranking as $row): ?>
                <tr>
                    <td><?= $rank++; ?></td>
                    <td><?= htmlspecialchars($row['nama_pts']); ?></td>
                    <td><?= number_format($row['nilai'], 4); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tombol: Cetak PDF + Kembali ke Dashboard -->
    <div class="d-flex gap-2 mt-3">
        <!-- Cetak PDF -->
        <a href="cetak_ranking.php?pts_id=<?= $pts_id; ?>" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf"></i> Cetak PDF Ranking
        </a>

        <!-- Kembali ke Dashboard (auto cek role) -->
        <?php if ($role == 'admin'): ?>
            <a href="dashboard_admin.php" class="btn btn-secondary">
                <i class="fas fa-home"></i> Kembali ke Dashboard
            </a>
        <?php else: ?>
            <a href="dashboard_user.php" class="btn btn-secondary">
                <i class="fas fa-home"></i> Kembali ke Dashboard
            </a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted py-3 border-top mt-4">
        &copy; <?= date('Y'); ?> Sistem SPK PTS
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
