<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';

$id_user = $_SESSION['id_user'];
$nama_pelapor = trim($_POST['nama_pelapor'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$judul_pengaduan = trim($_POST['judul_pengaduan'] ?? '');
$isi_pengaduan = trim($_POST['isi_pengaduan'] ?? '');

if ($nama_pelapor === '' || $no_hp === '' || $judul_pengaduan === '' || $isi_pengaduan === '') {
    $_SESSION['error'] = 'Semua field wajib diisi.';
    header('Location: ' . BASE_URL . '/user/pengaduan.php');
    exit;
}

$tanggal_kode = date('Ymd');
$prefix_kode = "ADU-{$tanggal_kode}-";

$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) AS total FROM pengaduan WHERE kode_pengaduan LIKE CONCAT(?, '%')");
mysqli_stmt_bind_param($stmt, "s", $prefix_kode);
mysqli_stmt_execute($stmt);
$total_hari_ini = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
mysqli_stmt_close($stmt);

$kode_pengaduan = $prefix_kode . str_pad((string) ($total_hari_ini + 1), 4, '0', STR_PAD_LEFT);

$stmt = mysqli_prepare($koneksi, "INSERT INTO pengaduan
    (kode_pengaduan, id_user, nama_pelapor, no_hp, judul_pengaduan, isi_pengaduan, status_pengaduan)
    VALUES (?, ?, ?, ?, ?, ?, 'Menunggu Verifikasi')");
mysqli_stmt_bind_param($stmt, "sissss", $kode_pengaduan, $id_user, $nama_pelapor, $no_hp, $judul_pengaduan, $isi_pengaduan);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = 'Pengaduan berhasil dikirim dengan kode ' . $kode_pengaduan . '.';
} else {
    $_SESSION['error'] = 'Pengaduan gagal dikirim. Silakan coba lagi.';
}
mysqli_stmt_close($stmt);

header('Location: ' . BASE_URL . '/user/pengaduan.php');
exit;
