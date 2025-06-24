<?php
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

include "../config/db.php";
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$pts_id = isset($_GET['pts_id']) ? $_GET['pts_id'] : 0;

// Ambil ranking untuk PTS tertentu
$query_ranking = mysqli_query($conn, "
    SELECT ranking.*, pts.nama_pts 
    FROM ranking 
    JOIN pts ON ranking.pts_id = pts.id 
    WHERE pts.id = '$pts_id'
    ORDER BY ranking.nilai_total DESC
");

$html = '
<h3 style="text-align:center;">Laporan Ranking PTS</h3>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>PTS</th>
            <th>Nilai Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($query_ranking)) {
    $html .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($row['nama_pts']) . '</td>
        <td>' . round($row['nilai_total'], 4) . '</td>
        <td>' . $row['tanggal'] . '</td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = "Ranking_PTS_" . date('Ymd') . ".pdf";

// AUTO DOWNLOAD:
$dompdf->stream($filename, array("Attachment" => true));
exit;
?>
