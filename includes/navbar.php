<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/auth.php';

$current_page = basename($_SERVER['PHP_SELF']);
function navActive(string $page, string $current) {
    return $page === $current ? 'active' : '';
}
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-pn sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/public/index.php">
            <i class="bi bi-bank2 me-2"></i>Pengadilan Negeri
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPN" aria-controls="navbarPN" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPN">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo navActive('index.php', $current_page); ?>" href="/public/index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo navActive('profil.php', $current_page); ?>" href="/public/profil.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo navActive('layanan.php', $current_page); ?>" href="/public/layanan.php">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo navActive('jadwal-sidang.php', $current_page); ?>" href="/public/jadwal-sidang.php">Jadwal Sidang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo navActive('pengumuman.php', $current_page); ?>" href="/public/pengumuman.php">Pengumuman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo navActive('kontak.php', $current_page); ?>" href="/public/kontak.php">Kontak</a>
                </li>

                <?php if (!isLoggedIn()) : ?>
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle btn-login-nav" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>Login
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
                            <li><a class="dropdown-item" href="/auth/login-user.php"><i class="bi bi-person me-2"></i>Login Masyarakat</a></li>
                            <li><a class="dropdown-item" href="/auth/login-admin.php"><i class="bi bi-shield-lock me-2"></i>Login Admin</a></li>
                        </ul>
                    </li>
                <?php elseif (getUserRole() === 'admin') : ?>
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle btn-login-nav" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-shield-lock me-1"></i><?php echo htmlspecialchars($_SESSION['nama']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/admin/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                            <li><a class="dropdown-item" href="/auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle btn-login-nav" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($_SESSION['nama']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/user/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="/auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
