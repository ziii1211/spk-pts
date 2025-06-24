<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

include "../config/db.php";

if (!isset($_GET['pts_id'])) {
    echo "PTS belum dipilih!";
    exit();
}

$pts_id = $_GET['pts_id'];

$query_pts = mysqli_query($conn, "SELECT * FROM pts WHERE id = '$pts_id'");
$data_pts = mysqli_fetch_assoc($query_pts);
$nama_pts = $data_pts['nama_pts'];

$query_kriteria = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY id ASC");
$list_kriteria = [];
while ($row = mysqli_fetch_assoc($query_kriteria)) {
    $list_kriteria[] = $row;
}

$jml_kriteria = count($list_kriteria);

// Ambil matrix dari DB (perbandingan_kriteria)
$matrix = [];
$jumlah_kolom = array_fill(0, $jml_kriteria, 0);

for ($i = 0; $i < $jml_kriteria; $i++) {
    for ($j = 0; $j < $jml_kriteria; $j++) {
        $q = mysqli_query($conn, "
            SELECT nilai FROM perbandingan_kriteria 
            WHERE kriteria_1_id = '{$list_kriteria[$i]['id']}' 
            AND kriteria_2_id = '{$list_kriteria[$j]['id']}'
        ");
        $row = mysqli_fetch_assoc($q);
        $matrix[$i][$j] = $row['nilai'];

        $jumlah_kolom[$j] += $matrix[$i][$j];
    }
}

// Hitung normalisasi & bobot
$normalisasi = [];
$bobot = [];

for ($i = 0; $i < $jml_kriteria; $i++) {
    $jumlah_baris = 0;
    for ($j = 0; $j < $jml_kriteria; $j++) {
        $normalisasi[$i][$j] = $matrix[$i][$j] / $jumlah_kolom[$j];
        $jumlah_baris += $normalisasi[$i][$j];
    }
    $bobot[$i] = $jumlah_baris / $jml_kriteria;
}

// Buat HTML untuk PDF
$html = '
<h2>Hasil Bobot Kriteria (AHP)</h2>
<p>PTS: <b>' . htmlspecialchars($nama_pts) . '</b></p>

<h4>Normalisasi Matriks</h4>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th>Kriteria</th>';

foreach ($list_kriteria as $k) {
    $html .= '<th>' . htmlspecialchars($k['nama_kriteria']) . '</th>';
}

$html .= '</tr>';

for ($i = 0; $i < $jml_kriteria; $i++) {
    $html .= '<tr><th>' . htmlspecialchars($list_kriteria[$i]['nama_kriteria']) . '</th>';
    for ($j = 0; $j < $jml_kriteria; $j++) {
        $html .= '<td>' . round($normalisasi[$i][$j], 4) . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</table>';

$html .= '<h4>Bobot Kriteria</h4>
<table border="1" cellpadding="5" cellspacing="0" width="50%">
    <tr>
        <th>Kriteria</th>
        <th>Bobot</th>
    </tr>';

for ($i = 0; $i < $jml_kriteria; $i++) {
    $html .= '<tr>
        <td>' . htmlspecialchars($list_kriteria[$i]['nama_kriteria']) . '</td>
        <td>' . round($bobot[$i], 4) . '</td>
    </tr>';
}

$html .= '</table>';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Bobot_PTS_$pts_id.pdf", ["Attachment" => false]);
$dompdf->stream("NamaFile.pdf", array("Attachment" => true));

exit();
?>
