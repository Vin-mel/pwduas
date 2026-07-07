<?php
include "../security.php";
include "../koneksi.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $cek = mysqli_query($conn, "SELECT nama_file_gambar FROM tb_dokumentasi WHERE id_foto = '$id'");
    $data = mysqli_fetch_assoc($cek);

if ($data) {
    $file_path = "../img/" . $data['nama_file_gambar'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    mysqli_query($conn, "DELETE FROM tb_dokumentasi WHERE id_foto = '$id'");
}
header("location: index.php");
exit;
}
?>