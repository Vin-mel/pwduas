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
      <h1>Manajemen Doa</h1>

      <div style="overflow-x: auto;">
      <table class="table-dokumentasi" cellpadding="8" cellspacing="0">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Isi Doa</th>
          <th>Tanggal Kirim</th>
          <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($conn,"SELECT * FROM tb_doa ORDER BY tanggal_kirim DESC");

        if (mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= $row['id_doa']; ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                    <td><?= htmlspecialchars($row['isi_doa']); ?></td>
                    <td><?= $row['tanggal_kirim']; ?></td>
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
                <td colspan="5" style="text-align:center;">Belum ada permohonan doa.</td>
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