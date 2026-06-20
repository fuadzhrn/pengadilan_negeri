<?php
// Konfigurasi koneksi database
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "pengadilan_db";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");
