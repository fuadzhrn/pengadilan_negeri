<?php
$page_title = "Kontak";
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/navbar.php';
require dirname(__DIR__) . '/config/koneksi.php';

$kontak = null;
$query = mysqli_query($koneksi, "SELECT * FROM kontak LIMIT 1");
if ($query && mysqli_num_rows($query) > 0) {
    $kontak = mysqli_fetch_assoc($query);
}
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Kontak Kami</h1>
            <p>Hubungi Pengadilan Negeri untuk informasi layanan dan administrasi.</p>
        </div>
    </section>

    <section class="section-pn">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card card-pn p-4 h-100">
                        <h5 class="mb-3"><?php echo $kontak ? htmlspecialchars($kontak['nama_instansi']) : 'Informasi Kontak'; ?></h5>
                        <?php if ($kontak) : ?>
                            <p><i class="bi bi-geo-alt-fill me-2 text-gold"></i><?php echo htmlspecialchars($kontak['alamat']); ?></p>
                            <p><i class="bi bi-telephone-fill me-2 text-gold"></i><?php echo htmlspecialchars($kontak['telepon']); ?></p>
                            <p><i class="bi bi-envelope-fill me-2 text-gold"></i><?php echo htmlspecialchars($kontak['email']); ?></p>
                            <p class="mb-0"><i class="bi bi-clock-fill me-2 text-gold"></i><?php echo htmlspecialchars($kontak['jam_pelayanan']); ?></p>
                        <?php else : ?>
                            <p class="mb-0 text-muted">Data kontak belum tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card card-pn p-4">
                        <h5 class="mb-3">Kirim Pesan</h5>
                        <form action="#" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="subjek" class="form-label">Subjek</label>
                                    <input type="text" class="form-control" id="subjek" name="subjek" required>
                                </div>
                                <div class="col-12">
                                    <label for="pesan" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-gold">
                                        <i class="bi bi-send me-2"></i>Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="maps-placeholder mt-4">
                        <div>
                            <i class="bi bi-geo-alt"></i>
                            Peta lokasi Pengadilan Negeri
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
