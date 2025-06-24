<?php
require '../vendor/autoload.php';
include '../config/db.php';

use Dompdf\Dompdf;

$query_ranking = mysqli_query($conn, "
    SELECT ranking.*, pts.nama_pts 
    FROM ranking 
    JOIN pts ON ranking.pts_id = pts.id 
    ORDER BY ranking.nilai_total DESC
");

$html = '
<h2 style="text-align:center;">Laporan Ranking PTS</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama PTS</th>
            <th>Nilai Total</th>
        </tr>
    </thead>
    <tbody>';
$no = 1;
while ($row = mysqli_fetch_assoc($query_ranking)) {
    $html .= '<tr>
        <td>'.$no++.'</td>
        <td>'.htmlspecialchars($row['nama_pts']).'</td>
        <td>'.number_format($row['nilai_total'], 4).'</td>
    </tr>';
}
$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('Laporan_Ranking_PTS.pdf', ['Attachment' => false]); // false = view, true = download
?>
