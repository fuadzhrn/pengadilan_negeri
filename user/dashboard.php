<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

$id_user = $_SESSION['id_user'];

$counts = [
    'Menunggu Verifikasi' => 0,
    'Diproses' => 0,
    'Selesai' => 0,
    'Ditolak' => 0,
];
$total_pengajuan = 0;

$stmt = mysqli_prepare($koneksi, "SELECT status_pengajuan, COUNT(*) AS total FROM pengajuan_layanan WHERE id_user = ? GROUP BY status_pengajuan");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $counts[$row['status_pengajuan']] = (int) $row['total'];
    $total_pengajuan += (int) $row['total'];
}
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) AS total FROM pengaduan WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$total_pengaduan = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
mysqli_stmt_close($stmt);

$pengajuan_terbaru = [];
$stmt = mysqli_prepare($koneksi, "SELECT pl.kode_pengajuan, pl.tanggal_pengajuan, pl.status_pengajuan, l.nama_layanan
    FROM pengajuan_layanan pl
    JOIN layanan l ON pl.id_layanan = l.id_layanan
    WHERE pl.id_user = ?
    ORDER BY pl.tanggal_pengajuan DESC
    LIMIT 5");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $pengajuan_terbaru[] = $row;
}
mysqli_stmt_close($stmt);

$page_title = "Dashboard Masyarakat";
require dirname(__DIR__) . '/includes/header.php';
?>

<div class="dashboard-wrapper">
    <?php require dirname(__DIR__) . '/includes/sidebar-user.php'; ?>

    <div class="dashboard-content">
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success alert-auto-hide"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger alert-auto-hide"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <h2 class="page-title">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></h2>
        <p class="text-muted mb-4">
            Melalui dashboard ini, Anda dapat mengajukan layanan, memantau status pengajuan, melihat jadwal sidang,
            dan menyampaikan pengaduan secara online.
        </p>

        <div class="row g-3 mb-4">
            <div class="col-md-4 col-lg-2">
                <div class="stat-card">
                    <i class="bi bi-folder2-open stat-icon"></i>
                    <p class="stat-value mt-2"><?php echo $total_pengajuan; ?></p>
                    <p class="stat-label">Total Pengajuan Saya</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="stat-card">
                    <i class="bi bi-hourglass-split stat-icon"></i>
                    <p class="stat-value mt-2"><?php echo $counts['Menunggu Verifikasi']; ?></p>
                    <p class="stat-label">Menunggu Verifikasi</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="stat-card">
                    <i class="bi bi-arrow-repeat stat-icon"></i>
                    <p class="stat-value mt-2"><?php echo $counts['Diproses']; ?></p>
                    <p class="stat-label">Diproses</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="stat-card">
                    <i class="bi bi-check2-circle stat-icon"></i>
                    <p class="stat-value mt-2"><?php echo $counts['Selesai']; ?></p>
                    <p class="stat-label">Selesai</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="stat-card">
                    <i class="bi bi-x-circle stat-icon"></i>
                    <p class="stat-value mt-2"><?php echo $counts['Ditolak']; ?></p>
                    <p class="stat-label">Ditolak</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="stat-card">
                    <i class="bi bi-megaphone stat-icon"></i>
                    <p class="stat-value mt-2"><?php echo $total_pengaduan; ?></p>
                    <p class="stat-label">Total Pengaduan Saya</p>
                </div>
            </div>
        </div>

        <div class="card card-pn shadow-sm">
            <div class="card-header">Pengajuan Terbaru</div>
            <div class="card-body">
                <?php if (empty($pengajuan_terbaru)) : ?>
                    <div class="alert alert-warning mb-0">Belum ada pengajuan layanan.</div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-pn table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Kode Pengajuan</th>
                                    <th>Nama Layanan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pengajuan_terbaru as $p) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($p['kode_pengajuan']); ?></td>
                                        <td><?php echo htmlspecialchars($p['nama_layanan']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($p['tanggal_pengajuan']))); ?></td>
                                        <td><span class="badge status-badge <?php echo badgeStatusProses($p['status_pengajuan']); ?>"><?php echo htmlspecialchars($p['status_pengajuan']); ?></span></td>
                                        <td><a href="<?php echo BASE_URL; ?>/user/status-pengajuan.php" class="btn btn-sm btn-gold">Detail</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</body>
</html>
