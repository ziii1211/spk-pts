function catat_log($conn, $user_id, $aksi) {
    mysqli_query($conn, "INSERT INTO log_aktivitas (user_id, aksi) VALUES ($user_id, '$aksi')");
}
