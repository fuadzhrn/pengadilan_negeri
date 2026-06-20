<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

if ($nama === '' || $email === '' || $password === '' || $konfirmasi_password === '' || $no_hp === '' || $alamat === '') {
    $_SESSION['error'] = 'Semua field wajib diisi.';
    header('Location: /auth/register.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Format email tidak valid.';
    header('Location: /auth/register.php');
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = 'Password minimal 6 karakter.';
    header('Location: /auth/register.php');
    exit;
}

if ($password !== $konfirmasi_password) {
    $_SESSION['error'] = 'Password dan konfirmasi password tidak sama.';
    header('Location: /auth/register.php');
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT id_user FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    $_SESSION['error'] = 'Email sudah terdaftar. Gunakan email lain.';
    header('Location: /auth/register.php');
    exit;
}
mysqli_stmt_close($stmt);

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($koneksi, "INSERT INTO users (nama, email, password, no_hp, alamat, role, status) VALUES (?, ?, ?, ?, ?, 'user', 'aktif')");
mysqli_stmt_bind_param($stmt, "sssss", $nama, $email, $password_hash, $no_hp, $alamat);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = 'Registrasi berhasil. Silakan login.';
    mysqli_stmt_close($stmt);
    header('Location: /auth/login-user.php');
    exit;
}

mysqli_stmt_close($stmt);
$_SESSION['error'] = 'Registrasi gagal. Silakan coba lagi.';
header('Location: /auth/register.php');
exit;
