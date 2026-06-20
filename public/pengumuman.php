<?php
$page_title = "Pengumuman";
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/navbar.php';
require dirname(__DIR__) . '/config/koneksi.php';

$data_pengumuman = [];
$query = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE status = 'publish' ORDER BY tanggal_publish DESC");
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $data_pengumuman[] = $row;
    }
}
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Pengumuman</h1>
            <p>Informasi dan pengumuman resmi Pengadilan Negeri.</p>
        </div>
    </section>

    <section class="section-pn">
        <div class="container">
            <?php if (empty($data_pengumuman)) : ?>
                <div class="alert alert-warning text-center mb-0">
                    Belum ada pengumuman.
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($data_pengumuman as $pengumuman) :
                        $modal_id = 'modalPengumuman' . $pengumuman['id_pengumuman'];
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-pn h-100">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="text-gold mb-2">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?php echo htmlspecialchars(date('d-m-Y', strtotime($pengumuman['tanggal_publish']))); ?>
                                    </h6>
                                    <h5><?php echo htmlspecialchars($pengumuman['judul']); ?></h5>
                                    <p class="mb-3"><?php echo htmlspecialchars(mb_strimwidth($pengumuman['isi'], 0, 120, '...')); ?></p>
                                    <button type="button" class="btn btn-gold btn-sm mt-auto" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>">
                                        Baca Selengkapnya
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail Pengumuman -->
                        <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="<?php echo $modal_id; ?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-navy text-white">
                                        <h5 class="modal-title text-white" id="<?php echo $modal_id; ?>Label"><?php echo htmlspecialchars($pengumuman['judul']); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-muted small">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            <?php echo htmlspecialchars(date('d-m-Y', strtotime($pengumuman['tanggal_publish']))); ?>
                                        </p>
                                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($pengumuman['isi'])); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
