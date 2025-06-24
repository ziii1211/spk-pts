<?php
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

include "../config/db.php";
session_start();

if ($_SESSION['role'] != 'user') {
    header("Location: dashboard_admin.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil ranking PTS user
$query_ranking = mysqli_query($conn, "
    SELECT ranking.*, pts.nama_pts 
    FROM ranking 
    JOIN pts ON ranking.pts_id = pts.id 
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

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($filename, array("Attachment" => true));
$filename = "Ranking_PTS_User.pdf";
$dompdf->stream($filename, array("Attachment" => true));
exit;
?>
