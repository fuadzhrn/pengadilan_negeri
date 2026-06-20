<?php
$page_title = "Jadwal Sidang";
require $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php';
require $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$data_jadwal = [];
$query = mysqli_query($koneksi, "SELECT * FROM jadwal_sidang ORDER BY tanggal_sidang ASC, jam_sidang ASC");
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $data_jadwal[] = $row;
    }
}

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
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Jadwal Sidang</h1>
            <p>Informasi jadwal sidang yang tersedia di Pengadilan Negeri.</p>
        </div>
    </section>

    <section class="section-pn">
        <div class="container">
            <?php if (empty($data_jadwal)) : ?>
                <div class="alert alert-warning text-center mb-0">
                    Belum ada jadwal sidang.
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-pn table-bordered table-hover bg-white align-middle">
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
                                    <td><span class="badge <?php echo badgeStatusSidang($jadwal['status_sidang']); ?>"><?php echo htmlspecialchars($jadwal['status_sidang']); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="text-muted small mb-0 mt-2">
                    <i class="bi bi-info-circle me-1"></i>Jadwal sidang dapat berubah sewaktu-waktu sesuai kebijakan pengadilan.
                </p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
