<?php
function get_ranking() {
    global $conn;
    $sql = "SELECT a.nama_alternatif, r.nilai
            FROM ranking r
            JOIN alternatif a ON r.id_alternatif = a.id_alternatif
            ORDER BY r.nilai DESC";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}
