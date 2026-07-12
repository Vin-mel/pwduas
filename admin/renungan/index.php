<?php 
include "../security.php";
include "../../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <title>Manajemen Renungan</title>
  <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
  <div class="admin-layout">
    <?php include "../sidebar.php";?>
    <div class="main-content">
      <h1>Manajemen Renungan</h1>

      <a href="tambah.php" class="btn-tambah">+ Tambah Renungan</a>

      <?php if(isset($_GET['status'])): ?>
        <?php if($_GET['status'] === 'sukses'): ?>
          <div class="alert alert-success">Renungan Berhasil dihapus.</div>
        <?php elseif($_GET['status'] === 'gagal'): ?>
          <div class="alert alert-danger">Data tidak ditemukan.</div>
        <?php elseif ($_GET['status'] === 'invalid'): ?>
          <div class="alert alert-warning">ID tidak valid.</div>
        <?php elseif ($_GET['status'] === 'tambah_sukses'): ?>
          <div class="alert alert-success">Renungan berhasil ditambahkan.</div>
        <?php elseif ($_GET['status'] === 'ubah_sukses'): ?>
          <div class="alert alert-success">Renungan berhasil diubah.</div>
          <?php endif; ?>
          <?php endif; ?>

          <div style="overlow-x: auto;">
            <table class="table-dokumentasi" cellpadding="8" cellspacing="0">
              <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Referensi Ayat</th>
                <th> Tanggal Publish</th>
                <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM tb_renungan ORDER BY tanggal_publish DESC");

        if(mysqli_num_rows($query) > 0) {
          while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
              <td><?=htmlspecialchars($row['id_renungan']); ?></td>
              <td><img src="../img/<?= htmlspecialchars($row['gambar_renungan']); ?>" width="80"></td>
              <td><?= htmlspecialchars($row['referensi_ayat']); ?></td>
              <td><?= htmlspecialchars($row['tanggal_publish']); ?></td>
              <td>
                <a href="ubah.php?id=<?= $row['id_renungan']; ?>" class="btn-edit">Edit</a>
                <a href="hapus.php?id=<?= $row['id_renungan']; ?>" class="btn-hapus"
                onclick="return confirm('Yakin mau hapus renungan ini?')">
                Hapus
        </a>
        </td>
        </tr>
        <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="5" style="text-align:center;">Belum ada renungan.</td>
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
