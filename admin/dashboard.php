<?php 
include "security.php";

$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - GKKB</title>
  <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
  <div class="dashboard-page">
    <div class="dashboard-container">
      <div class="dashboard-header">
        <h2>Dashboard admin</h2>
        <p>Selamat datang, <strong><?php echo htmlspecialchars($username);?></strong></p>
      </div>
      <div class="menu-group">
        <a href= "dokumentasi/index.php" class="menu-link">Manajemen Dokumentasi </a>
        <a href= "jadwal/index.php" class="menu-link">Manajemen Jadwal </a>
        <a href= "renungan/index.php" class="menu-link">Manajemen Renungan </a>
        <a href= "pendeta/index.php" class="menu-link">Manajemen Pendeta </a>
        <a href= "doa/index.php" class="menu-link">Manajemen Doa </a>
      </div>
        <a href= "logout.php" class="btn-logout">Log out </a>
    </div>
  </div>

</body>
</html>
