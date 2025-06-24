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

// Ambil data PTS
$query_pts = mysqli_query($conn, "SELECT * FROM pts WHERE id = '$pts_id'");
$data_pts = mysqli_fetch_assoc($query_pts);

// Jika tidak ada PTS
if ($pts_id == 0 || !$data_pts) {
    header("Location: pilih_pts.php");
    exit();
}

// Simulasi rumus AHP (ini hanya contoh — bisa diganti dengan perhitungan real)
$hasil_bobot = [
    ['kriteria' => 'Kualitas Pengajaran', 'bobot' => 0.4],
    ['kriteria' => 'Fasilitas Kampus', 'bobot' => 0.35],
    ['kriteria' => 'Biaya Kuliah', 'bobot' => 0.25]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pembobotan Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Pembobotan Kriteria — <?= htmlspecialchars($data_pts['nama_pts']); ?></h2>

    <!-- Form Hitung Bobot -->
    <form method="post" action="">
        <button type="submit" name="hitung_bobot" class="btn btn-primary mb-3">
            <i class="fas fa-calculator"></i> Hitung Bobot
        </button>
    </form>

    <?php if (isset($_POST['hitung_bobot'])): ?>

        <h4 class="mt-4">Rumus Perhitungan AHP:</h4>
        <p>
            Matriks perbandingan berpasangan:<br>
            Eigen vector → bobot prioritas<br>
            Consistency Index (CI), Consistency Ratio (CR)
        </p>

        <div class="alert alert-info">
            Simulasi perhitungan AHP ditampilkan di bawah:
        </div>

        <!-- Hasil Perhitungan Bobot -->
        <h4 class="mt-4">Hasil Perhitungan Bobot:</h4>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kriteria</th>
                    <th>Bobot</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($hasil_bobot as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['kriteria']); ?></td>
                        <td><?= number_format($row['bobot'], 4); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tombol: Cetak PDF & Lihat Hasil Ranking -->
        <div class="d-flex gap-2 mt-3">
            <!-- Cetak PDF -->
            <a href="cetak_bobot.php?pts_id=<?= $pts_id; ?>" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF Bobot
            </a>

            <!-- Lihat Hasil Ranking -->
            <a href="lihat_ranking.php?pts_id=<?= $pts_id; ?>" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Lihat Hasil Ranking
            </a>
        </div>

    <?php endif; ?>

    <!-- Footer -->
    <footer class="text-center text-muted py-3 border-top mt-4">
        &copy; <?= date('Y'); ?> Sistem SPK PTS
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
