<?php 
include "../security.php";
include "../../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <title>Manajemen Pendeta</title>
  <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
  <div class="admin-layout">
    <?php include "../sidebar.php";?>
    <div class="main-content">
      <h1>Manajemen Pendeta</h1>

          <a href="tambah.php" class=" btn-tambah">+ Tambah Pendeta</a>

          <?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'sukses'): ?>
        <div class="alert alert-success">Data pendeta berhasil dihapus.</div>
    <?php elseif ($_GET['status'] === 'gagal'): ?>
        <div class="alert alert-danger">Data tidak ditemukan.</div>
    <?php elseif ($_GET['status'] === 'invalid'): ?>
        <div class="alert alert-warning">ID tidak valid.</div>
       <?php elseif ($_GET['status'] === 'tambah_sukses'): ?>
        <div class="alert alert-success">Data pendeta berhasil ditambahkan.</div>
      <?php elseif ($_GET['status'] === 'ubah_sukses'): ?>
        <div class="alert alert-success">Data pendeta berhasil diubah.</div>
    <?php endif; ?>
<?php endif; ?>

      <div style="overflow-x: auto;">
      <table class="table-dokumentasi" cellpadding="8" cellspacing="0">
        <tr>
          <th>ID</th>
          <th>Foto</th>
          <th>Nama</th>
          <th>Biodata</th>
          <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($conn,"SELECT * FROM tb_pendeta ORDER BY nama_pendeta DESC");

        if (mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_pendeta']); ?></td>
                    <td><img src="../img/<?= htmlspecialchars($row['foto_pendeta']); ?>" width="80"></td>
                    <td><?= htmlspecialchars($row['nama_pendeta']); ?></td>
                    <td><?= htmlspecialchars($row['biodata']); ?></td>
                    <td>
                      <a href="ubah.php?id=<?= $row['id_pendeta']; ?>" class="btn-edit">Edit</a>
                    <a href="hapus.php?id=<?= $row['id_pendeta']; ?>" class="btn-hapus"
                    onclick="return confirm('Yakin mau hapus informasi pendeta?')">
                    Hapus
                    </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5" style="text-align:center;">Belum ada Pendeta.</td>
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