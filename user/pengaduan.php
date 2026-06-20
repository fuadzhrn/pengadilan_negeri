<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

$id_user = $_SESSION['id_user'];

$stmt = mysqli_prepare($koneksi, "SELECT no_hp FROM users WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$user_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($koneksi, "SELECT * FROM pengaduan WHERE id_user = ? ORDER BY tanggal_pengaduan DESC");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$riwayat_pengaduan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $riwayat_pengaduan[] = $row;
}
mysqli_stmt_close($stmt);

$page_title = "Pengaduan Masyarakat";
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

        <h2 class="page-title">Pengaduan Masyarakat</h2>
        <p class="text-muted mb-4">Sampaikan pengaduan Anda terkait pelayanan Pengadilan Negeri.</p>

        <div class="form-card mb-4">
            <form action="<?php echo BASE_URL; ?>/proses/proses-pengaduan.php" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                        <input type="text" class="form-control" id="nama_pelapor" name="nama_pelapor" value="<?php echo htmlspecialchars($_SESSION['nama']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($user_data['no_hp'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="judul_pengaduan" class="form-label">Judul Pengaduan</label>
                    <input type="text" class="form-control" id="judul_pengaduan" name="judul_pengaduan" required>
                </div>
                <div class="mb-3">
                    <label for="isi_pengaduan" class="form-label">Isi Pengaduan</label>
                    <textarea class="form-control" id="isi_pengaduan" name="isi_pengaduan" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-gold">
                    <i class="bi bi-send me-2"></i>Kirim Pengaduan
                </button>
            </form>
        </div>

        <div class="card card-pn shadow-sm">
            <div class="card-header">Riwayat Pengaduan</div>
            <div class="card-body">
                <?php if (empty($riwayat_pengaduan)) : ?>
                    <div class="alert alert-warning mb-0">Belum ada riwayat pengaduan.</div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-pn table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pengaduan</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Tanggapan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($riwayat_pengaduan as $aduan) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($aduan['kode_pengaduan']); ?></td>
                                        <td><?php echo htmlspecialchars($aduan['judul_pengaduan']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($aduan['tanggal_pengaduan']))); ?></td>
                                        <td><span class="badge status-badge <?php echo badgeStatusProses($aduan['status_pengaduan']); ?>"><?php echo htmlspecialchars($aduan['status_pengaduan']); ?></span></td>
                                        <td><?php echo htmlspecialchars($aduan['tanggapan_admin'] ?: '-'); ?></td>
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
