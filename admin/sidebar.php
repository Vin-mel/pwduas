<?php
$path = $_SERVER['PHP_SELF'];
$folder = basename(dirname($path));
if ($folder === 'admin') {
    $current_page = basename($path);
} else {
    $current_page = $folder;
}
?>


 <div class="sidebar">
        <h2>Dashboard admin</h2>
        <p>Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['username']);?></strong></p>
    <div class="menu-group">
    <a href="/admin/dokumentasi/index.php" class="menu-link <?php echo ($current_page == 'dokumentasi') ? 'active' : ''; ?>">Manajemen Dokumentasi</a>
    <a href="/admin/jadwal/index.php" class="menu-link <?php echo ($current_page == 'jadwal') ? 'active' : ''; ?>">Manajemen Jadwal</a>
    <a href="/admin/renungan/index.php" class="menu-link <?php echo ($current_page == 'renungan') ? 'active' : ''; ?>">Manajemen Renungan</a>
    <a href="/admin/pendeta/index.php" class="menu-link <?php echo ($current_page == 'pendeta') ? 'active' : ''; ?>">Manajemen Pendeta</a>
    <a href="/admin/doa/index.php" class="menu-link <?php echo ($current_page == 'doa') ? 'active' : ''; ?>">Manajemen Doa</a>
    <a href="/admin/kelola_admin/kelola_admin.php" class="menu-link <?php echo ($current_page == 'kelola_admin.php') ? 'active' : ''; ?>">Kelola Admin</a>  
    <a href="/admin/logout.php" class="btn-logout">Log out</a>
    </div>
</div>