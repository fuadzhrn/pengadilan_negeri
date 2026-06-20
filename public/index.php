<?php
$page_title = "Beranda";
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/navbar.php';
require dirname(__DIR__) . '/config/koneksi.php';

$pengumuman_terbaru = [];
$query = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE status = 'publish' ORDER BY tanggal_publish DESC LIMIT 3");
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $pengumuman_terbaru[] = $row;
    }
}
?>

<main>
    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])) : ?>
        <div class="container pt-3">
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success alert-auto-hide"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger alert-auto-hide"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- 1. Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1>Sistem Informasi Layanan Pengadilan Negeri</h1>
            <p>Memberikan kemudahan akses informasi layanan, jadwal sidang, pengaduan, dan pengumuman secara online.</p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="<?php echo BASE_URL; ?>/public/layanan.php" class="btn btn-gold">
                    <i class="bi bi-clipboard-check me-2"></i>Lihat Layanan
                </a>
                <a href="<?php echo BASE_URL; ?>/public/jadwal-sidang.php" class="btn btn-pn-outline">
                    <i class="bi bi-calendar-event me-2"></i>Jadwal Sidang
                </a>
            </div>
        </div>
    </section>

    <!-- 2. Section Sambutan -->
    <section class="section-pn">
        <div class="container">
            <div class="section-title">
                <h2>Selamat Datang di Website Layanan Pengadilan Negeri</h2>
                <div class="divider"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9 text-center">
                    <p class="mb-0">
                        Website ini dibuat untuk memudahkan masyarakat dalam memperoleh informasi layanan,
                        jadwal sidang, pengumuman, dan akses administrasi Pengadilan Negeri secara online.
                        Melalui sistem ini, masyarakat dapat mengajukan layanan, memantau status pengajuan,
                        menyampaikan pengaduan, serta mengikuti informasi resmi tanpa harus datang langsung
                        ke kantor pengadilan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Section Layanan Utama -->
    <section class="section-pn" style="background-color: var(--gray-light);">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Utama</h2>
                <div class="divider"></div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-folder2-open service-icon"></i>
                        <h5>Informasi Perkara</h5>
                        <p>Akses informasi perkembangan perkara yang sedang berjalan di Pengadilan Negeri.</p>
                        <a href="<?php echo BASE_URL; ?>/public/layanan.php" class="btn btn-sm btn-gold mt-2">Selengkapnya</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-file-earmark-text service-icon"></i>
                        <h5>Permohonan Surat Keterangan</h5>
                        <p>Ajukan permohonan surat keterangan secara online dengan proses yang mudah.</p>
                        <a href="<?php echo BASE_URL; ?>/public/layanan.php" class="btn btn-sm btn-gold mt-2">Selengkapnya</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-megaphone service-icon"></i>
                        <h5>Pengaduan Masyarakat</h5>
                        <p>Sampaikan pengaduan terkait pelayanan pengadilan secara cepat dan transparan.</p>
                        <a href="<?php echo BASE_URL; ?>/public/layanan.php" class="btn btn-sm btn-gold mt-2">Selengkapnya</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <i class="bi bi-calendar2-week service-icon"></i>
                        <h5>Jadwal Sidang</h5>
                        <p>Pantau jadwal sidang perkara secara real-time dan akurat setiap saat.</p>
                        <a href="<?php echo BASE_URL; ?>/public/jadwal-sidang.php" class="btn btn-sm btn-gold mt-2">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Section Informasi Cepat -->
    <section class="section-pn">
        <div class="container">
            <div class="section-title">
                <h2>Informasi Cepat</h2>
                <div class="divider"></div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-quick-card">
                        <i class="bi bi-laptop"></i>
                        <h6>Layanan Online</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-quick-card">
                        <i class="bi bi-calendar-check"></i>
                        <h6>Jadwal Sidang</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-quick-card">
                        <i class="bi bi-megaphone-fill"></i>
                        <h6>Pengumuman Resmi</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Section Pengumuman Terbaru -->
    <section class="section-pn" style="background-color: var(--gray-light);">
        <div class="container">
            <div class="section-title">
                <h2>Pengumuman Terbaru</h2>
                <div class="divider"></div>
            </div>

            <?php if (empty($pengumuman_terbaru)) : ?>
                <div class="alert alert-warning text-center mb-0">
                    Belum ada pengumuman terbaru.
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($pengumuman_terbaru as $pengumuman) : ?>
                        <div class="col-md-4">
                            <div class="card card-pn h-100">
                                <div class="card-body">
                                    <h6 class="text-gold mb-2">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?php echo htmlspecialchars(date('d-m-Y', strtotime($pengumuman['tanggal_publish']))); ?>
                                    </h6>
                                    <h5><?php echo htmlspecialchars($pengumuman['judul']); ?></h5>
                                    <p class="mb-0"><?php echo htmlspecialchars(mb_strimwidth($pengumuman['isi'], 0, 120, '...')); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo BASE_URL; ?>/public/pengumuman.php" class="btn btn-gold">Lihat Semua Pengumuman</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- 6. Section Call To Action -->
    <section class="cta-section">
        <div class="container">
            <h3>Butuh layanan pengadilan secara online?</h3>
            <a href="<?php echo BASE_URL; ?>/auth/login-user.php" class="btn btn-gold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Ajukan Layanan
            </a>
        </div>
    </section>
</main>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
