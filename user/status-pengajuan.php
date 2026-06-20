<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

$id_user = $_SESSION['id_user'];
$status_options = ['Menunggu Verifikasi', 'Diproses', 'Selesai', 'Ditolak'];
$status_filter = $_GET['status'] ?? '';
if (!in_array($status_filter, $status_options, true)) {
    $status_filter = '';
}

if ($status_filter !== '') {
    $stmt = mysqli_prepare($koneksi, "SELECT pl.*, l.nama_layanan
        FROM pengajuan_layanan pl
        JOIN layanan l ON pl.id_layanan = l.id_layanan
        WHERE pl.id_user = ? AND pl.status_pengajuan = ?
        ORDER BY pl.tanggal_pengajuan DESC");
    mysqli_stmt_bind_param($stmt, "is", $id_user, $status_filter);
} else {
    $stmt = mysqli_prepare($koneksi, "SELECT pl.*, l.nama_layanan
        FROM pengajuan_layanan pl
        JOIN layanan l ON pl.id_layanan = l.id_layanan
        WHERE pl.id_user = ?
        ORDER BY pl.tanggal_pengajuan DESC");
    mysqli_stmt_bind_param($stmt, "i", $id_user);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data_pengajuan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_pengajuan[] = $row;
}
mysqli_stmt_close($stmt);

// Ambil dokumen pendukung untuk setiap pengajuan
$dokumen_map = [];
if (!empty($data_pengajuan)) {
    $ids = array_column($data_pengajuan, 'id_pengajuan');
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));
    $stmt = mysqli_prepare($koneksi, "SELECT id_pengajuan, nama_dokumen, file_dokumen FROM dokumen_pengajuan WHERE id_pengajuan IN ($placeholders)");
    mysqli_stmt_bind_param($stmt, $types, ...$ids);
    mysqli_stmt_execute($stmt);
    $docResult = mysqli_stmt_get_result($stmt);
    while ($doc = mysqli_fetch_assoc($docResult)) {
        $dokumen_map[$doc['id_pengajuan']] = $doc;
    }
    mysqli_stmt_close($stmt);
}

$page_title = "Status Pengajuan";
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

        <h2 class="page-title">Status Pengajuan</h2>
        <p class="text-muted mb-4">Daftar pengajuan layanan yang telah Anda kirimkan.</p>

        <div class="form-card mb-4">
            <form action="" method="get" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua</option>
                        <?php foreach ($status_options as $opt) : ?>
                            <option value="<?php echo htmlspecialchars($opt); ?>" <?php echo $status_filter === $opt ? 'selected' : ''; ?>><?php echo htmlspecialchars($opt); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-gold w-100">Terapkan</button>
                </div>
            </form>
        </div>

        <div class="card card-pn shadow-sm">
            <div class="card-body">
                <?php if (empty($data_pengajuan)) : ?>
                    <div class="alert alert-warning mb-0">Belum ada pengajuan layanan.</div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-pn table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pengajuan</th>
                                    <th>Layanan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Catatan Admin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($data_pengajuan as $p) :
                                    $modal_id = 'modalDetail' . $p['id_pengajuan'];
                                    $dokumen = $dokumen_map[$p['id_pengajuan']] ?? null;
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($p['kode_pengajuan']); ?></td>
                                        <td><?php echo htmlspecialchars($p['nama_layanan']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($p['tanggal_pengajuan']))); ?></td>
                                        <td><span class="badge status-badge <?php echo badgeStatusProses($p['status_pengajuan']); ?>"><?php echo htmlspecialchars($p['status_pengajuan']); ?></span></td>
                                        <td><?php echo htmlspecialchars($p['catatan_admin'] ?: '-'); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-gold" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>">Detail</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail Pengajuan -->
                                    <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-navy text-white">
                                                    <h5 class="modal-title text-white">Detail Pengajuan</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-borderless mb-0">
                                                        <tr><th width="40%">Kode Pengajuan</th><td><?php echo htmlspecialchars($p['kode_pengajuan']); ?></td></tr>
                                                        <tr><th>Nama Layanan</th><td><?php echo htmlspecialchars($p['nama_layanan']); ?></td></tr>
                                                        <tr><th>Nama Pemohon</th><td><?php echo htmlspecialchars($p['nama_pemohon']); ?></td></tr>
                                                        <tr><th>Nomor Identitas</th><td><?php echo htmlspecialchars($p['no_identitas'] ?: '-'); ?></td></tr>
                                                        <tr><th>Nomor HP</th><td><?php echo htmlspecialchars($p['no_hp']); ?></td></tr>
                                                        <tr><th>Alamat</th><td><?php echo htmlspecialchars($p['alamat']); ?></td></tr>
                                                        <tr><th>Keterangan</th><td><?php echo nl2br(htmlspecialchars($p['keterangan'])); ?></td></tr>
                                                        <tr><th>Status</th><td><span class="badge status-badge <?php echo badgeStatusProses($p['status_pengajuan']); ?>"><?php echo htmlspecialchars($p['status_pengajuan']); ?></span></td></tr>
                                                        <tr><th>Catatan Admin</th><td><?php echo htmlspecialchars($p['catatan_admin'] ?: '-'); ?></td></tr>
                                                        <tr><th>Tanggal Pengajuan</th><td><?php echo htmlspecialchars(date('d-m-Y H:i', strtotime($p['tanggal_pengajuan']))); ?></td></tr>
                                                        <tr>
                                                            <th>Dokumen</th>
                                                            <td>
                                                                <?php if ($dokumen) : ?>
                                                                    <a href="<?php echo BASE_URL; ?>/uploads/dokumen/<?php echo htmlspecialchars($dokumen['file_dokumen']); ?>" target="_blank">
                                                                        <?php echo htmlspecialchars($dokumen['nama_dokumen']); ?>
                                                                    </a>
                                                                <?php else : ?>
                                                                    -
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
