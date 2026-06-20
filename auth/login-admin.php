<?php
$page_title = "Login Admin";
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/navbar.php';
?>

<main class="form-pn-wrapper" style="background-image: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card form-pn-card admin-card p-4">
                    <div class="card-body">
                        <h4 class="form-pn-title text-center mb-1">
                            <i class="bi bi-shield-lock me-2"></i>Login Admin
                        </h4>
                        <p class="text-center text-muted mb-4">Khusus Petugas Pengadilan Negeri</p>

                        <?php if (isset($_SESSION['success'])) : ?>
                            <div class="alert alert-success alert-auto-hide"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="alert alert-danger alert-auto-hide"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <form action="<?php echo BASE_URL; ?>/proses/proses-login-admin.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn bg-navy text-white w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login Admin
                            </button>
                        </form>

                        <p class="text-center mt-3 mb-0">
                            <a href="<?php echo BASE_URL; ?>/public/index.php"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
