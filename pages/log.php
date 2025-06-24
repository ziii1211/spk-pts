<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Ambil data log aktivitas
$query_log = mysqli_query($conn, "
    SELECT l.*, u.username 
    FROM log_aktivitas l
    JOIN users u ON l.user_id = u.id
    ORDER BY l.waktu DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Log Aktivitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="mb-4">Log Aktivitas</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Aksi</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while ($row = mysqli_fetch_assoc($query_log)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= htmlspecialchars($row['aksi']); ?></td>
                <td><?= $row['waktu']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard_admin.php" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
<li>
    <a href="log.php">
        <i class="fas fa-history"></i> Log Aktivitas
    </a>
</li>


</body>
</html>
