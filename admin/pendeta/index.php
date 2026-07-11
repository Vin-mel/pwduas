<?php 
include "../security.php";
include "../../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <title>Manajemen Doa</title>
  <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
  <div class="admin-layout">
    <?php include "../sidebar.php";?>
    <div class="main-content">
      <h1>Manajemen Pendeta</h1>
          <a href="tambah.php" class=" btn-tambah">+ Tambah Pendeta</a>
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
                    <td><?= $row['id_pendeta']; ?></td>
                    <td><?= htmlspecialchars($row['foto_pendeta']); ?></td>
                    <td><?= htmlspecialchars($row['nama_pendeta']); ?></td>
                    <td><?= htmlspecialchars($row['biodata']); ?></td>
                    <td>
                    <a href="hapus.php?id=<?= $row['id_doa']; ?>" class="btn-hapus"
                    onclick="return confirm('Yakin mau hapus permohonan doa ini?')">
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