<?php
$page_title = "Login Masyarakat";
require $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php';
?>

<main class="form-pn-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card form-pn-card p-4">
                    <div class="card-body">
                        <h4 class="form-pn-title text-center mb-4">
                            <i class="bi bi-person-circle me-2"></i>Login Masyarakat
                        </h4>

                        <?php if (isset($_SESSION['success'])) : ?>
                            <div class="alert alert-success alert-auto-hide"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="alert alert-danger alert-auto-hide"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <form action="/proses/proses-login-user.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-gold w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>
                        </form>

                        <p class="text-center mt-3 mb-1">
                            Belum punya akun? <a href="/auth/register.php">Daftar sekarang</a>
                        </p>
                        <p class="text-center mb-0">
                            <a href="/public/index.php"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
