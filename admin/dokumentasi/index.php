<?php 
include "../security.php";
include "../../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <title>Manajemen Dokumentasi</title>
  <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
  <div class="admin-layout">
    <?php include "../sidebar.php"; ?>

    <div class="main-content">
      <h1>Manajemen Dokumentasi</h1>

      <a href="tambah.php" class="btn-tambah">+ Tambah Dokumentasi</a>

      <?php if (isset($_GET['status'])): ?>
          <?php if ($_GET['status'] === 'sukses'): ?>
              <div class="alert alert-success">Dokumentasi berhasil dihapus.</div>
          <?php elseif ($_GET['status'] === 'gagal'): ?>
              <div class="alert alert-danger">Data tidak ditemukan.</div>
          <?php elseif ($_GET['status'] === 'invalid'): ?>
              <div class="alert alert-warning">ID tidak valid.</div>
          <?php elseif ($_GET['status'] === 'tambah_sukses'): ?>
            <div class="alert alert-success">Dokumentasi berhasil ditambahkan.</div>
          <?php endif; ?>
      <?php endif; ?>

      <div style="overflow-x: auto;">
      <table class="table-dokumentasi" cellpadding="8" cellspacing="0">
        <tr>
          <th>ID</th>
          <th>Gambar</th>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM tb_dokumentasi");
        while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?= htmlspecialchars($row['id_foto']); ?></td>
                <td><img src="../img/<?= htmlspecialchars($row['nama_file_gambar']); ?>" width="80"></td>
                <td><?= htmlspecialchars($row['nama_file_gambar']); ?></td>
                <td>
                    <a href="hapus.php?id=<?= $row['id_foto']; ?>" class="btn-hapus"
                       onclick="return confirm('Yakin mau hapus dokumentasi ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
      </table>
      </div>
    </div>
  </div>
</body>
</html>