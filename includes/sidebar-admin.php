<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar-pn sidebar-admin">
    <div class="sidebar-brand">
        <i class="bi bi-shield-lock me-2"></i>Admin Panel
    </div>
    <ul class="sidebar-menu">
        <li><a href="/admin/dashboard.php" class="<?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="/admin/layanan.php" class="<?php echo $current_page === 'layanan.php' ? 'active' : ''; ?>"><i class="bi bi-gear"></i> Kelola Layanan</a></li>
        <li><a href="/admin/pengajuan.php" class="<?php echo $current_page === 'pengajuan.php' ? 'active' : ''; ?>"><i class="bi bi-file-earmark-text"></i> Kelola Pengajuan</a></li>
        <li><a href="/admin/jadwal-sidang.php" class="<?php echo $current_page === 'jadwal-sidang.php' ? 'active' : ''; ?>"><i class="bi bi-calendar-event"></i> Kelola Jadwal Sidang</a></li>
        <li><a href="/admin/pengumuman.php" class="<?php echo $current_page === 'pengumuman.php' ? 'active' : ''; ?>"><i class="bi bi-megaphone"></i> Kelola Pengumuman</a></li>
        <li><a href="/admin/user.php" class="<?php echo $current_page === 'user.php' ? 'active' : ''; ?>"><i class="bi bi-people"></i> Kelola User</a></li>
        <li class="sidebar-divider"></li>
        <li><a href="/auth/logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</aside>
