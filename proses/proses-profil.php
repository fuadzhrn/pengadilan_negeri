<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';

$id_user = $_SESSION['id_user'];
$form_type = $_POST['form_type'] ?? '';

if ($form_type === 'password') {
    $password_lama = $_POST['password_lama'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi_password_baru = $_POST['konfirmasi_password_baru'] ?? '';

    if ($password_lama === '' || $password_baru === '' || $konfirmasi_password_baru === '') {
        $_SESSION['error'] = 'Semua field password wajib diisi untuk mengubah password.';
        header('Location: ' . BASE_URL . '/user/profil.php');
        exit;
    }

    if (strlen($password_baru) < 6) {
        $_SESSION['error'] = 'Password baru minimal 6 karakter.';
        header('Location: ' . BASE_URL . '/user/profil.php');
        exit;
    }

    if ($password_baru !== $konfirmasi_password_baru) {
        $_SESSION['error'] = 'Konfirmasi password baru tidak sama.';
        header('Location: ' . BASE_URL . '/user/profil.php');
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "SELECT password FROM users WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    $user_row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if (!$user_row || !password_verify($password_lama, $user_row['password'])) {
        $_SESSION['error'] = 'Password lama tidak sesuai.';
        header('Location: ' . BASE_URL . '/user/profil.php');
        exit;
    }

    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, "si", $password_hash, $id_user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['success'] = 'Password berhasil diubah.';
    header('Location: ' . BASE_URL . '/user/profil.php');
    exit;
}

// Update data profil
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

if ($nama === '' || $email === '') {
    $_SESSION['error'] = 'Nama dan email wajib diisi.';
    header('Location: ' . BASE_URL . '/user/profil.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Format email tidak valid.';
    header('Location: ' . BASE_URL . '/user/profil.php');
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT id_user FROM users WHERE email = ? AND id_user != ?");
mysqli_stmt_bind_param($stmt, "si", $email, $id_user);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    $_SESSION['error'] = 'Email sudah digunakan oleh akun lain.';
    header('Location: ' . BASE_URL . '/user/profil.php');
    exit;
}
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($koneksi, "UPDATE users SET nama = ?, email = ?, no_hp = ?, alamat = ? WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "ssssi", $nama, $email, $no_hp, $alamat, $id_user);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;
    $_SESSION['success'] = 'Profil berhasil diperbarui.';
} else {
    $_SESSION['error'] = 'Gagal memperbarui profil. Silakan coba lagi.';
}
mysqli_stmt_close($stmt);

header('Location: ' . BASE_URL . '/user/profil.php');
exit;
