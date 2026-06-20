<?php
require_once dirname(__DIR__) . '/config/auth.php';
requireRole('user', '/auth/login-user.php');
require_once dirname(__DIR__) . '/config/koneksi.php';

$id_user = $_SESSION['id_user'];

$stmt = mysqli_prepare($koneksi, "SELECT nama, email, no_hp, alamat FROM users WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$user_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

$page_title = "Profil Saya";
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

        <h2 class="page-title">Profil Saya</h2>
        <p class="text-muted mb-4">Lihat dan perbarui data profil Anda.</p>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="form-card">
                    <h5 class="mb-3">Data Profil</h5>
                    <form action="<?php echo BASE_URL; ?>/proses/proses-profil.php" method="post">
                        <input type="hidden" name="form_type" value="profil">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user_data['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($user_data['no_hp'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($user_data['alamat'] ?? ''); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-save me-2"></i>Simpan Profil
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-card">
                    <h5 class="mb-3">Ubah Password</h5>
                    <form action="<?php echo BASE_URL; ?>/proses/proses-profil.php" method="post">
                        <input type="hidden" name="form_type" value="password">
                        <div class="mb-3">
                            <label for="password_lama" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" id="password_lama" name="password_lama">
                        </div>
                        <div class="mb-3">
                            <label for="password_baru" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password_baru" name="password_baru" minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="konfirmasi_password_baru" name="konfirmasi_password_baru" minlength="6">
                        </div>
                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-shield-lock me-2"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</body>
</html>
