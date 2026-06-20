<?php
$page_title = "Profil";
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/navbar.php';
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Profil Pengadilan Negeri</h1>
            <p>Mengenal lebih dekat tugas, fungsi, dan layanan Pengadilan Negeri.</p>
        </div>
    </section>

    <!-- Tentang Pengadilan -->
    <section class="section-pn">
        <div class="container">
            <div class="section-title">
                <h2>Tentang Pengadilan</h2>
                <div class="divider"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <p>
                        Pengadilan Negeri merupakan lembaga peradilan tingkat pertama dalam lingkungan
                        peradilan umum yang berkedudukan di kabupaten/kota. Pengadilan Negeri bertugas
                        dan berwenang memeriksa, mengadili, dan memutus perkara pidana maupun perdata
                        bagi rakyat pencari keadilan pada umumnya di tingkat pertama, sesuai dengan
                        ketentuan peraturan perundang-undangan yang berlaku.
                    </p>
                    <p class="mb-0">
                        Sebagai bagian dari Mahkamah Agung Republik Indonesia, Pengadilan Negeri senantiasa
                        berkomitmen untuk memberikan pelayanan hukum yang profesional, transparan, dan
                        akuntabel kepada seluruh masyarakat pencari keadilan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="section-pn" style="background-color: var(--gray-light);">
        <div class="container">
            <div class="section-title">
                <h2>Visi dan Misi</h2>
                <div class="divider"></div>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-pn h-100">
                        <div class="card-header"><i class="bi bi-eye me-2"></i>Visi</div>
                        <div class="card-body">
                            <p class="mb-0">
                                Terwujudnya Pengadilan Negeri yang agung, bersih, transparan, dan memberikan
                                pelayanan hukum yang berkeadilan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-pn h-100">
                        <div class="card-header"><i class="bi bi-bullseye me-2"></i>Misi</div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Memberikan pelayanan hukum yang cepat, sederhana, dan transparan.</li>
                                <li>Meningkatkan kualitas pelayanan publik.</li>
                                <li>Menjaga integritas dan profesionalitas aparatur pengadilan.</li>
                                <li>Memanfaatkan teknologi informasi dalam pelayanan masyarakat.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tugas dan Fungsi -->
    <section class="section-pn">
        <div class="container">
            <div class="section-title">
                <h2>Tugas dan Fungsi</h2>
                <div class="divider"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <p class="text-center mb-4">
                        Pengadilan Negeri memiliki tugas utama dalam menerima, memeriksa, mengadili, dan
                        menyelesaikan setiap perkara yang diajukan kepadanya secara adil dan sesuai
                        hukum yang berlaku.
                    </p>
                    <div class="list-group">
                        <div class="list-group-item d-flex align-items-start gap-3">
                            <i class="bi bi-inbox fs-4 text-gold"></i>
                            <div>
                                <strong>Menerima</strong> setiap perkara pidana dan perdata yang diajukan oleh masyarakat pencari keadilan.
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-start gap-3">
                            <i class="bi bi-search fs-4 text-gold"></i>
                            <div>
                                <strong>Memeriksa</strong> bukti, keterangan saksi, dan fakta hukum yang relevan dengan perkara.
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-start gap-3">
                            <i class="bi bi-hammer fs-4 text-gold"></i>
                            <div>
                                <strong>Mengadili</strong> perkara melalui proses persidangan yang terbuka dan adil.
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-start gap-3">
                            <i class="bi bi-check2-circle fs-4 text-gold"></i>
                            <div>
                                <strong>Menyelesaikan</strong> perkara dengan putusan yang berkekuatan hukum dan berkeadilan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
