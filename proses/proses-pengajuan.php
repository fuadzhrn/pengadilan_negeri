<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';

$id_user = $_SESSION['id_user'];
$id_layanan = $_POST['id_layanan'] ?? '';
$nama_pemohon = trim($_POST['nama_pemohon'] ?? '');
$no_identitas = trim($_POST['no_identitas'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$keterangan = trim($_POST['keterangan'] ?? '');

if ($id_layanan === '' || $nama_pemohon === '' || $no_hp === '' || $alamat === '' || $keterangan === '') {
    $_SESSION['error'] = 'Semua field wajib (kecuali nomor identitas) harus diisi.';
    header('Location: ' . BASE_URL . '/user/ajukan-layanan.php');
    exit;
}

$id_layanan = (int) $id_layanan;

// Validasi upload dokumen (opsional)
$nama_dokumen = null;
$file_dokumen = null;

if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['dokumen']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = 'Gagal mengunggah dokumen. Silakan coba lagi.';
        header('Location: ' . BASE_URL . '/user/ajukan-layanan.php');
        exit;
    }

    if ($_FILES['dokumen']['size'] > 2 * 1024 * 1024) {
        $_SESSION['error'] = 'Ukuran dokumen maksimal 2MB.';
        header('Location: ' . BASE_URL . '/user/ajukan-layanan.php');
        exit;
    }

    $ext = strtolower(pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
    $allowed_mime = ['application/pdf', 'image/jpeg', 'image/png'];
    $mime = mime_content_type($_FILES['dokumen']['tmp_name']);

    if (!in_array($ext, $allowed_ext, true) || !in_array($mime, $allowed_mime, true)) {
        $_SESSION['error'] = 'Format dokumen tidak diizinkan. Gunakan PDF, JPG, JPEG, atau PNG.';
        header('Location: ' . BASE_URL . '/user/ajukan-layanan.php');
        exit;
    }

    $nama_dokumen = $_FILES['dokumen']['name'];
    $file_dokumen = 'DOK-' . date('Ymd') . '-' . uniqid() . '.' . $ext;
    $upload_dir = dirname(__DIR__) . '/uploads/dokumen/';
    $upload_path = $upload_dir . $file_dokumen;

    if (!move_uploaded_file($_FILES['dokumen']['tmp_name'], $upload_path)) {
        $_SESSION['error'] = 'Gagal menyimpan dokumen. Silakan coba lagi.';
        header('Location: ' . BASE_URL . '/user/ajukan-layanan.php');
        exit;
    }
}

// Buat kode pengajuan otomatis: PNG-YYYYMMDD-XXXX
$tanggal_kode = date('Ymd');
$prefix_kode = "PNG-{$tanggal_kode}-";

$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) AS total FROM pengajuan_layanan WHERE kode_pengajuan LIKE CONCAT(?, '%')");
mysqli_stmt_bind_param($stmt, "s", $prefix_kode);
mysqli_stmt_execute($stmt);
$total_hari_ini = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
mysqli_stmt_close($stmt);

$kode_pengajuan = $prefix_kode . str_pad((string) ($total_hari_ini + 1), 4, '0', STR_PAD_LEFT);

$stmt = mysqli_prepare($koneksi, "INSERT INTO pengajuan_layanan
    (kode_pengajuan, id_user, id_layanan, nama_pemohon, no_identitas, no_hp, alamat, keterangan, status_pengajuan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu Verifikasi')");
mysqli_stmt_bind_param($stmt, "siisssss", $kode_pengajuan, $id_user, $id_layanan, $nama_pemohon, $no_identitas, $no_hp, $alamat, $keterangan);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    $_SESSION['error'] = 'Pengajuan gagal disimpan. Silakan coba lagi.';
    header('Location: ' . BASE_URL . '/user/ajukan-layanan.php');
    exit;
}

$id_pengajuan = mysqli_insert_id($koneksi);
mysqli_stmt_close($stmt);

if ($file_dokumen !== null) {
    $stmt = mysqli_prepare($koneksi, "INSERT INTO dokumen_pengajuan (id_pengajuan, nama_dokumen, file_dokumen) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $id_pengajuan, $nama_dokumen, $file_dokumen);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$_SESSION['success'] = 'Pengajuan layanan berhasil dikirim dengan kode ' . $kode_pengajuan . '.';
header('Location: ' . BASE_URL . '/user/status-pengajuan.php');
exit;
