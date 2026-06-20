<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/auth.php';
requireRole('user', '/auth/login-user.php');

$page_title = "Dashboard Masyarakat";
require $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<div class="dashboard-wrapper">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar-user.php'; ?>

    <div class="dashboard-content">
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success alert-auto-hide"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger alert-auto-hide"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <h2 class="mb-1">Dashboard Masyarakat</h2>
        <p class="text-muted mb-4">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></p>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-file-earmark-plus fs-1 mb-3 text-gold"></i>
                    <h6>Ajukan Layanan</h6>
                    <a href="/user/ajukan-layanan.php" class="btn btn-sm btn-gold mt-2">Buka</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-list-check fs-1 mb-3 text-gold"></i>
                    <h6>Status Pengajuan</h6>
                    <a href="/user/status-pengajuan.php" class="btn btn-sm btn-gold mt-2">Buka</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-calendar-event fs-1 mb-3 text-gold"></i>
                    <h6>Jadwal Sidang</h6>
                    <a href="/user/jadwal-sidang.php" class="btn btn-sm btn-gold mt-2">Buka</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-pn h-100 text-center p-4">
                    <i class="bi bi-megaphone fs-1 mb-3 text-gold"></i>
                    <h6>Pengaduan</h6>
                    <a href="/user/pengaduan.php" class="btn btn-sm btn-gold mt-2">Buka</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/script.js"></script>
</body>
</html>
