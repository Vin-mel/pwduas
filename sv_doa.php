<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $nama_lengkap = mysqli_real_escape_string($conn, trim($_POST['nama_lengkap']));
  $isi_doa = mysqli_real_escape_string($conn, trim($_POST['isi_doa']));
    if(empty($nama_lengkap) || empty($isi_doa)){
      header("Location:index.php?status=kosong");
      exit;
    }

    $query = "INSERT INTO tb_doa (nama_lengkap,isi_doa) VALUES ('$nama_lengkap','$isi_doa')";

    if (mysqli_query($conn,$query)){
      header("Location: index.php?status=Sukses");
      exit;
    }else{
      header("Location: index.php?status=Gagal");
      exit;
    }
  }
?>

<?php if (isset($_GET['status'])):?>
  <?php if ($_GET ['status']==='Sukses'):?>
    <p style="color:green;">Permohonan doa berhasil dikirim</p>
    <?php elseif ($_GET['status']==='Kosong'):?>
    <p style="color:red;">Permohonan tidak boleh kosong.</p>
    <?php elseif ($_GET['status']==='Gagal'):?>
      <p style="color:red;">Gagal mengirim, Silahkan coba lagi.</p>
      <?php endif; ?>
      <?php endif;?>