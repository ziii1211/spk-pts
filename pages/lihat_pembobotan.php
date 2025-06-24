<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
}

$query_kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
$list_kriteria = [];
while ($row = mysqli_fetch_assoc($query_kriteria)) {
    $list_kriteria[] = $row;
}

$jml_kriteria = count($list_kriteria);

if (isset($_POST['simpan'])) {
    mysqli_query($conn, "DELETE FROM perbandingan_kriteria");

    for ($i = 0; $i < $jml_kriteria; $i++) {
        for ($j = 0; $j < $jml_kriteria; $j++) {

            if ($i != $j) {
                $nilai = $_POST['nilai'][$i][$j];
                $kriteria_1 = $list_kriteria[$i]['id'];
                $kriteria_2 = $list_kriteria[$j]['id'];

                mysqli_query($conn, "
                    INSERT INTO perbandingan_kriteria (kriteria_1_id, kriteria_2_id, nilai)
                    VALUES ('$kriteria_1', '$kriteria_2', '$nilai')
                ");
            }
        }
    }

    // Setelah simpan → langsung redirect ke lihat_pembobotan.php
    header("Location: lihat_pembobotan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembobotan Kriteria - SPK PTS</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: center; }
        input[type='number'] { width: 60px; }
        .btn {
            margin-top: 20px;
            padding: 10px 20px;
            background: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .btn:hover { background: #0056b3; }
        .btn-secondary {
            margin-top: 10px;
            display: inline-block;
            padding: 8px 16px;
            background: #6c757d;
            color: #fff;
            text-decoration: none;
        }
        .btn-secondary:hover { background: #5a6268; }
    </style>
</head>
<body>

<h2>Matrix Pembobotan Kriteria (AHP)</h2>

<form method="post" action="">
    <table>
        <tr>
            <th>Kriteria</th>
            <?php foreach ($list_kriteria as $kriteria): ?>
                <th><?php echo $kriteria['nama_kriteria']; ?></th>
            <?php endforeach; ?>
        </tr>

        <?php for ($i = 0; $i < $jml_kriteria; $i++): ?>
            <tr>
                <th><?php echo $list_kriteria[$i]['nama_kriteria']; ?></th>

                <?php for ($j = 0; $j < $jml_kriteria; $j++): ?>

                    <?php if ($i == $j): ?>
                        <td>1</td>
                    <?php else: ?>
                        <td>
                            <input type="number" name="nilai[<?php echo $i; ?>][<?php echo $j; ?>]" 
                                   min="1" max="9" step="1" required>
                        </td>
                    <?php endif; ?>

                <?php endfor; ?>

            </tr>
        <?php endfor; ?>

    </table>

    <button type="submit" name="simpan" class="btn">Simpan Pembobotan</button>
</form>

<p>
    <a href="dashboard_user.php" class="btn-secondary">Kembali ke Dashboard</a>
</p>

</body>
</html>
