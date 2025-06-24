<?php

$host = "localhost";
$user = "root";
$password = "";  
$dbname = "db_spk_pts"; 

$koneksi = mysqli_connect($host, $user, $password, $dbname);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
