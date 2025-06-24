<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit();
}

$query_user = mysqli_query($conn, "
    SELECT * FROM users
");

// Tentukan link dashboard
$dashboard_link = 'dashboard_admin.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Total User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Daftar User</h2>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query_user)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td><?= htmlspecialchars($row['role']); ?></td>
                        <td>
                            <a href="hapus_user.php?id=<?= $row['id']; ?>" 
                               onclick="return confirm('Yakin ingin hapus user ini?');" 
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
