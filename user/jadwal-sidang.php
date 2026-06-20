<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';

function badgeStatusSidang($status) {
    switch ($status) {
        case 'Selesai':
            return 'bg-success';
        case 'Ditunda':
            return 'bg-warning text-dark';
        default:
            return 'bg-primary';
    }
}

$status_options = ['Terjadwal', 'Selesai', 'Ditunda'];
$tanggal_filter = trim($_GET['tanggal'] ?? '');
$status_filter = $_GET['status'] ?? '';
if (!in_array($status_filter, $status_options, true)) {
    $status_filter = '';
}

$query = "SELECT * FROM jadwal_sidang";
$conditions = [];
$types = '';
$params = [];

if ($tanggal_filter !== '') {
    $conditions[] = 'tanggal_sidang = ?';
    $types .= 's';
    $params[] = $tanggal_filter;
}
if ($status_filter !== '') {
    $conditions[] = 'status_sidang = ?';
    $types .= 's';
    $params[] = $status_filter;
}
if (!empty($conditions)) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}
$query .= ' ORDER BY tanggal_sidang ASC, jam_sidang ASC';

$stmt = mysqli_prepare($koneksi, $query);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data_jadwal = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_jadwal[] = $row;
}
mysqli_stmt_close($stmt);

$page_title = "Jadwal Sidang";
require dirname(__DIR__) . '/includes/header.php';
?>

<div class="dashboard-wrapper">
    <?php require dirname(__DIR__) . '/includes/sidebar-user.php'; ?>

    <div class="dashboard-content">
        <h2 class="page-title">Jadwal Sidang</h2>
        <p class="text-muted mb-4">Informasi jadwal sidang yang tersedia di Pengadilan Negeri.</p>

        <div class="form-card mb-4">
            <form action="" method="get" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="tanggal" class="form-label">Tanggal Sidang</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($tanggal_filter); ?>">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status Sidang</label>
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
                <div class="col-md-2">
                    <a href="<?php echo BASE_URL; ?>/user/jadwal-sidang.php" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>

        <div class="card card-pn shadow-sm">
            <div class="card-body">
                <?php if (empty($data_jadwal)) : ?>
                    <div class="alert alert-warning mb-0">Belum ada jadwal sidang.</div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-pn table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Perkara</th>
                                    <th>Pihak Terkait</th>
                                    <th>Agenda</th>
                                    <th>Ruang Sidang</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($data_jadwal as $jadwal) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($jadwal['nomor_perkara']); ?></td>
                                        <td><?php echo htmlspecialchars($jadwal['pihak_terkait']); ?></td>
                                        <td><?php echo htmlspecialchars($jadwal['agenda_sidang']); ?></td>
                                        <td><?php echo htmlspecialchars($jadwal['ruang_sidang']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($jadwal['tanggal_sidang']))); ?></td>
                                        <td><?php echo htmlspecialchars(substr($jadwal['jam_sidang'], 0, 5)); ?></td>
                                        <td><span class="badge status-badge <?php echo badgeStatusSidang($jadwal['status_sidang']); ?>"><?php echo htmlspecialchars($jadwal['status_sidang']); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <p class="text-muted small mb-0 mt-3">
                    <i class="bi bi-info-circle me-1"></i>Jadwal sidang dapat berubah sewaktu-waktu sesuai kebijakan pengadilan.
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</body>
</html>
