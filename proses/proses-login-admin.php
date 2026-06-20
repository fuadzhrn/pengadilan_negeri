<?php
require_once dirname(__DIR__) . '/config/auth.php';
require_once dirname(__DIR__) . '/config/koneksi.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    $_SESSION['error'] = 'Email dan password wajib diisi.';
    header('Location: ' . BASE_URL . '/auth/login-admin.php');
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT id_user, nama, email, password, role, status FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user || $user['role'] !== 'admin') {
    $_SESSION['error'] = 'Email atau password salah.';
    header('Location: ' . BASE_URL . '/auth/login-admin.php');
    exit;
}

if ($user['status'] !== 'aktif') {
    $_SESSION['error'] = 'Akun Anda tidak aktif.';
    header('Location: ' . BASE_URL . '/auth/login-admin.php');
    exit;
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Email atau password salah.';
    header('Location: ' . BASE_URL . '/auth/login-admin.php');
    exit;
}

$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];
$_SESSION['status'] = $user['status'];

header('Location: ' . BASE_URL . '/admin/dashboard.php');
exit;
