<?php
SESSION_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $nama_lengkap = mysqli_real_escape_string($conn, trim($_POST['nama_lengkap']));
  $isi_doa = mysqli_real_escape_string($conn, trim($_POST['isi_doa']));
    if(empty($nama_lengkap) || empty($isi_doa)){
      $_SESSION['doa_status']='kosong';
      header("Location:index.php");
      exit;
    }

    $query = "INSERT INTO tb_doa (nama_lengkap,isi_doa) VALUES ('$nama_lengkap','$isi_doa')";

    if (mysqli_query($conn,$query)){
        $_SESSION['doa_status']='Berhasil dikirim';

    }else{
        $_SESSION['doa_status']='Gagal dikirim';
    }
    header("Location: index.php");
    exit;
  }
?>