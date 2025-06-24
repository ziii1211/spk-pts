<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$username = $_SESSION['username'];
$current_page = basename($_SERVER['PHP_SELF']);

// Total user
$query_user = mysqli_query($conn, "SELECT COUNT(*) as total_user FROM users");
$data_user = mysqli_fetch_assoc($query_user);
$total_user = $data_user['total_user'];

// Total pts
$query_pts = mysqli_query($conn, "SELECT COUNT(*) as total_pts FROM pts");
$data_pts = mysqli_fetch_assoc($query_pts);
$total_pts = $data_pts['total_pts'];

// Total laporan
$query_laporan = mysqli_query($conn, "SELECT COUNT(*) as total_laporan FROM laporan");
$data_laporan = mysqli_fetch_assoc($query_laporan);
$total_laporan = $data_laporan['total_laporan'];

// Ambil notifikasi
$query_notif = mysqli_query($conn, "SELECT * FROM notifikasi ORDER BY tanggal DESC LIMIT 5");
$notifikasi_jumlah = mysqli_num_rows($query_notif);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard Admin</a>
        <div class="d-flex">
            <ul class="navbar-nav me-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <?php if ($notifikasi_jumlah > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $notifikasi_jumlah; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php while ($row = mysqli_fetch_assoc($query_notif)): ?>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <?= htmlspecialchars($row['pesan']); ?> <br>
                                    <small class="text-muted"><?= $row['tanggal']; ?></small>
                                </a>
                            </li>
                        <?php endwhile; ?>
                        <?php if ($notifikasi_jumlah == 0): ?>
                            <li><a class="dropdown-item text-muted">Tidak ada notifikasi</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
            <a href="logout.php" class="btn btn-outline-light">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container">

    <!-- Menu Laporan & Menu User / PTS -->
    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="lihat_ranking.php" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> Laporan
        </a>
        <a href="total_user.php" class="btn btn-info">
            <i class="fas fa-users"></i> Total User
        </a>
        <a href="total_pts.php" class="btn btn-info">
            <i class="fas fa-school"></i> Total PTS
        </a>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total User</h5>
                    <p class="card-text fs-4"><?= $total_user; ?> User</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-school"></i> Total PTS</h5>
                    <p class="card-text fs-4"><?= $total_pts; ?> Kampus</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-file-alt"></i> Laporan Dibuat</h5>
                    <p class="card-text fs-4"><?= $total_laporan; ?> Laporan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted py-3 border-top">
        &copy; <?= date('Y'); ?> Sistem SPK PTS — Dashboard Admin
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
