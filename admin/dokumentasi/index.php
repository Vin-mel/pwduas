<?php 
include "../security.php";
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
    <?php include "../sidebar.php";?>

    <div class="main-content">
    <h1>Manajemen Dokumentasi</h1>
    <?php include "../../koneksi.php"; ?>
    <div style="overflow-x: auto;">
    <table class="table-dokumentasi" border="1"  cellpadding="8" cellspacing="0">
      <tr>
        <th>ID</th>
          <th>Gambar</th>
            <th>Nama</th>
              <th>Aksi</th>
</tr>
<?php
$query = mysqli_query($conn,"SELECT * FROM tb_dokumentasi");
while($row = mysqli_fetch_assoc($query)) {
  ?>
  <tr>
    <td><?= $row['id_foto'];?></td>
    <td><img src="../img/<?= $row['nama_file_gambar']; ?>" width="80"></td>
    <td><?= $row['nama_file_gambar']; ?></td>
    <td>
    <a href="hapus.php?id=<?= $row['id_foto']; ?>"
    onclick="return confirm('yakin mau hapus dokuemntasi ini?')">
    Hapus
    </a>
    </td>
    </tr>
    <?php } ?>
    </table>
</div>
</div>
</body>
</html>
