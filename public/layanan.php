<?php
$page_title = "Layanan";
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/navbar.php';
require dirname(__DIR__) . '/config/koneksi.php';

$data_layanan = [];
$query = mysqli_query($koneksi, "SELECT * FROM layanan WHERE status = 'aktif' ORDER BY id_layanan ASC");
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $data_layanan[] = $row;
    }
}
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Layanan Pengadilan</h1>
            <p>Daftar layanan yang dapat diakses oleh masyarakat.</p>
        </div>
    </section>

    <section class="section-pn">
        <div class="container">
            <?php if (empty($data_layanan)) : ?>
                <div class="alert alert-warning text-center">
                    Data layanan belum tersedia.
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($data_layanan as $layanan) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-pn h-100">
                                <div class="card-header"><?php echo htmlspecialchars($layanan['nama_layanan']); ?></div>
                                <div class="card-body d-flex flex-column">
                                    <p class="card-text"><?php echo htmlspecialchars($layanan['deskripsi']); ?></p>
                                    <ul class="list-unstyled small text-muted mb-3">
                                        <li class="mb-1">
                                            <i class="bi bi-card-checklist me-2"></i>
                                            <strong>Persyaratan:</strong>
                                            <?php echo htmlspecialchars($layanan['persyaratan'] ?: '-'); ?>
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-cash-coin me-2"></i>
                                            <strong>Biaya:</strong>
                                            <?php echo htmlspecialchars($layanan['biaya'] ?: 'Gratis'); ?>
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-hourglass-split me-2"></i>
                                            <strong>Estimasi Waktu:</strong>
                                            <?php echo htmlspecialchars($layanan['estimasi_waktu'] ?: '-'); ?>
                                        </li>
                                    </ul>
                                    <a href="<?php echo BASE_URL; ?>/auth/login-user.php" class="btn btn-gold mt-auto">
                                        <i class="bi bi-send me-2"></i>Ajukan Layanan
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="alert alert-info text-center mt-4 mb-0">
                <i class="bi bi-info-circle me-2"></i>Untuk mengajukan layanan, masyarakat harus login terlebih dahulu.
            </div>
        </div>
    </section>
</main>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
