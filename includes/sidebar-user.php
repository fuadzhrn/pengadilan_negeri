<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar-pn">
    <div class="sidebar-brand">
        <i class="bi bi-bank2 me-2"></i>Portal Masyarakat
    </div>
    <ul class="sidebar-menu">
        <li><a href="<?php echo BASE_URL; ?>/user/dashboard.php" class="<?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="<?php echo BASE_URL; ?>/user/ajukan-layanan.php" class="<?php echo $current_page === 'ajukan-layanan.php' ? 'active' : ''; ?>"><i class="bi bi-file-earmark-plus"></i> Ajukan Layanan</a></li>
        <li><a href="<?php echo BASE_URL; ?>/user/status-pengajuan.php" class="<?php echo $current_page === 'status-pengajuan.php' ? 'active' : ''; ?>"><i class="bi bi-list-check"></i> Status Pengajuan</a></li>
        <li><a href="<?php echo BASE_URL; ?>/user/jadwal-sidang.php" class="<?php echo $current_page === 'jadwal-sidang.php' ? 'active' : ''; ?>"><i class="bi bi-calendar-event"></i> Jadwal Sidang</a></li>
        <li><a href="<?php echo BASE_URL; ?>/user/pengaduan.php" class="<?php echo $current_page === 'pengaduan.php' ? 'active' : ''; ?>"><i class="bi bi-megaphone"></i> Pengaduan</a></li>
        <li><a href="<?php echo BASE_URL; ?>/user/profil.php" class="<?php echo $current_page === 'profil.php' ? 'active' : ''; ?>"><i class="bi bi-person-circle"></i> Profil Saya</a></li>
        <li class="sidebar-divider"></li>
        <li><a href="<?php echo BASE_URL; ?>/auth/logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</aside>
