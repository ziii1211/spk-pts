<?php
include '../config/koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #198754;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            transition: all 0.3s ease-in-out;
            z-index: 1030;
        }
        .sidebar .logo {
            font-size: 1.6rem;
            font-weight: bold;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 14px 22px;
            margin-bottom: 6px;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #157347;
            border-radius: 6px;
        }
        .sidebar .profile {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar .profile img {
            width: 65px;
            border-radius: 50%;
            margin-bottom: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .main-content {
            margin-left: 250px;
            padding: 25px;
            transition: all 0.3s ease-in-out;
        }
        .main-content .header {
            margin-bottom: 25px;
        }
        .card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        .card .card-body i {
            color: #20c997;
        }
        footer {
            text-align: center;
            padding: 15px 0;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 50px;
        }
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <nav class="sidebar" id="sidebarMenu">
        <div class="logo">
            <i class="fas fa-user-circle"></i> Pengguna
        </div>
        <div class="profile">
            <img src="https://via.placeholder.com/60" alt="Profile">
            <div><?php echo htmlspecialchars($username); ?></div>
        </div>
        <a href="pilih_pts.php"><i class="fas fa-university"></i> Pilih PTS</a>
        <a href="pembobotan_kriteria.php"><i class="fas fa-balance-scale"></i> Pembobotan Kriteria</a>
        <a href="lihat_ranking.php"><i class="fas fa-chart-line"></i> Lihat Hasil Ranking</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

    <div class="main-content">
        <nav class="navbar navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <button class="btn btn-outline-success d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-brand mb-0 h1">Dashboard Pengguna</span>
            </div>
        </nav>

        <div class="header">
            <h2>Selamat datang, <?php echo htmlspecialchars($username); ?>!</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-university fa-3x mb-3"></i>
                        <h5 class="card-title">Pilih PTS</h5>
                        <a href="pilih_pts.php" class="btn btn-success mt-3">Akses</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-balance-scale fa-3x mb-3"></i>
                        <h5 class="card-title">Pembobotan Kriteria</h5>
                        <a href="pembobotan_kriteria.php" class="btn btn-success mt-3">Akses</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                        <h5 class="card-title">Lihat Hasil Ranking</h5>
                        <a href="lihat_ranking.php" class="btn btn-success mt-3">Akses</a>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-5">
            &copy; 2025 Sistem Pendukung Keputusan PTS - <?php echo htmlspecialchars($username); ?>
        </footer>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarMenu = document.getElementById('sidebarMenu');
        sidebarToggle.addEventListener('click', () => {
            sidebarMenu.classList.toggle('active');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
