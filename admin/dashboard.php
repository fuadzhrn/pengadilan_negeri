<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/auth.php';
requireRole('admin', '/auth/login-admin.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

function hitungTotal($koneksi, $table) {
    $result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM " . $table);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return (int) $row['total'];
    }
    return 0;
}

$total_layanan = hitungTotal($koneksi, 'layanan');
$total_pengajuan = hitungTotal($koneksi, 'pengajuan_layanan');
$total_jadwal = hitungTotal($koneksi, 'jadwal_sidang');
$total_user = hitungTotal($koneksi, 'users');

$page_title = "Dashboard Admin";
require $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<div class="dashboard-wrapper">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar-admin.php'; ?>

    <div class="dashboard-content">
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success alert-auto-hide"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger alert-auto-hide"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <h2 class="mb-1">Dashboard Admin</h2>
        <p class="text-muted mb-4">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></p>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-clipboard-check fs-1 mb-3 text-gold"></i>
                    <h3 class="mb-0"><?php echo $total_layanan; ?></h3>
                    <p class="text-muted mb-0">Total Layanan</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-file-earmark-text fs-1 mb-3 text-gold"></i>
                    <h3 class="mb-0"><?php echo $total_pengajuan; ?></h3>
                    <p class="text-muted mb-0">Total Pengajuan</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-calendar-event fs-1 mb-3 text-gold"></i>
                    <h3 class="mb-0"><?php echo $total_jadwal; ?></h3>
                    <p class="text-muted mb-0">Total Jadwal Sidang</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-people fs-1 mb-3 text-gold"></i>
                    <h3 class="mb-0"><?php echo $total_user; ?></h3>
                    <p class="text-muted mb-0">Total User</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/script.js"></script>
</body>
</html>
