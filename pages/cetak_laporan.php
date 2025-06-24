<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Tentukan link dashboard sesuai role
if ($role == 'admin') {
    $link_dashboard = 'dashboard_admin.php';
} else {
    $link_dashboard = 'dashboard_user.php';
}

$query_ranking = mysqli_query($conn, "
    SELECT ranking.*, pts.nama_pts 
    FROM ranking 
    JOIN pts ON ranking.pts_id = pts.id 
    ORDER BY ranking.nilai_total DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Ranking PTS - SPK PTS</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px 15px; text-align: center; font-size: 14px; }
        th { background: #007BFF; color: #fff; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            color: #fff;
            background-color: #6c757d;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #5a6268;
        }
        .btn-primary {
            background-color: #007BFF;
        }
        .btn-primary:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>

<h2>Cetak Laporan Ranking PTS</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama PTS</th>
            <th>Nilai Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        while ($row = mysqli_fetch_assoc($query_ranking)): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_pts']); ?></td>
                <td><?php echo number_format($row['nilai_total'], 4); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Tombol -->
<a href="<?php echo $link_dashboard; ?>" class="btn">
    &larr; Kembali ke Dashboard
</a>

<button class="btn btn-primary" onclick="window.print()">
    🖨️ Cetak Laporan
</button>
<a href="export_pdf.php" class="btn btn-primary" target="_blank">
    📄 Export PDF
</a>
</body>
</html>
