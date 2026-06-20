<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';

$id_user = $_SESSION['id_user'];

$stmt = mysqli_prepare($koneksi, "SELECT nama, no_hp, alamat FROM users WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$user_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

$daftar_layanan = [];
$result = mysqli_query($koneksi, "SELECT id_layanan, nama_layanan FROM layanan WHERE status = 'aktif' ORDER BY nama_layanan ASC");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $daftar_layanan[] = $row;
    }
}

$page_title = "Ajukan Layanan";
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

        <h2 class="page-title">Ajukan Layanan</h2>
        <p class="text-muted mb-4">Silakan lengkapi formulir berikut untuk mengajukan layanan Pengadilan Negeri.</p>

        <div class="form-card">
            <?php if (empty($daftar_layanan)) : ?>
                <div class="alert alert-warning mb-0">Belum ada layanan yang tersedia saat ini.</div>
            <?php else : ?>
                <form action="<?php echo BASE_URL; ?>/proses/proses-pengajuan.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="id_layanan" class="form-label">Pilih Layanan</label>
                        <select class="form-select" id="id_layanan" name="id_layanan" required>
                            <option value="" selected disabled>-- Pilih Layanan --</option>
                            <?php foreach ($daftar_layanan as $layanan) : ?>
                                <option value="<?php echo (int) $layanan['id_layanan']; ?>"><?php echo htmlspecialchars($layanan['nama_layanan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
                            <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon" value="<?php echo htmlspecialchars($user_data['nama'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_identitas" class="form-label">Nomor Identitas (KTP)</label>
                            <input type="text" class="form-control" id="no_identitas" name="no_identitas">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($user_data['no_hp'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($user_data['alamat'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan / Keperluan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="dokumen" class="form-label">Upload Dokumen Pendukung (opsional)</label>
                        <input type="file" class="form-control" id="dokumen" name="dokumen" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format PDF, JPG, JPEG, PNG. Maksimal 2MB.</small>
                    </div>
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-send me-2"></i>Ajukan Layanan
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</body>
</html>
