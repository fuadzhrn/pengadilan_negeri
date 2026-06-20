<?php
$page_title = "Register Masyarakat";
require $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php';
?>

<main class="form-pn-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card form-pn-card p-4">
                    <div class="card-body">
                        <h4 class="form-pn-title text-center mb-4">
                            <i class="bi bi-person-plus me-2"></i>Daftar Akun Masyarakat
                        </h4>

                        <?php if (isset($_SESSION['success'])) : ?>
                            <div class="alert alert-success alert-auto-hide"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="alert alert-danger alert-auto-hide"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <form action="/proses/proses-register.php" method="post">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" minlength="6" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-gold w-100">
                                <i class="bi bi-check-circle me-2"></i>Daftar
                            </button>
                        </form>

                        <p class="text-center mt-3 mb-0">
                            Sudah punya akun? <a href="/auth/login-user.php">Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
