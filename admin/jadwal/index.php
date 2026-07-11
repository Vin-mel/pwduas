<?php 
include "../security.php";
include "../../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <title>Manajemen Jadwal</title>
  <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
  <div class="admin-layout">
    <?php include "../sidebar.php";?>
    <div class="main-content">
      <h1>Manajemen Jadwal</h1>
      <div style="overflow-x: auto;">
      <table class="table-dokumentasi" cellpadding="8" cellspacing="0">
        <tr>
          <th>ID</th>
          <th>Hari</th>
          <th>Nama Kegiatan</th>
          <th>Jam Mulai</th>
          <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($conn,"SELECT * FROM tb_jadwal ORDER BY hari DESC");

        if (mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= $row['id_jadwal']; ?></td>
                    <td><?= htmlspecialchars($row['hari']); ?></td>
                    <td><?= htmlspecialchars($row['nama_kegiatan']); ?></td>
                    <td><?= htmlspecialchars($row['jam_mulai']); ?></td>
                    <td>
                    <a href="hapus.php?id=<?= $row['id_jadwal']; ?>" class="btn-hapus"
                    onclick="return confirm('Yakin mau hapus jadwal ini?')">
                    Hapus
                    </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5" style="text-align:center;">Belum ada jadwal.</td>
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