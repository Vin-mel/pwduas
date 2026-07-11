<?php
include "../security.php";
include "../../koneksi.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT nama_file_gambar FROM tb_dokumentasi WHERE id_foto = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($data) {
        $file_path = "../img/" . $data['nama_file_gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $stmt2 = mysqli_prepare($conn, "DELETE FROM tb_dokumentasi WHERE id_foto = ?");
        mysqli_stmt_bind_param($stmt2, "i", $id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        header("location: index.php?status=sukses");
        exit;
    } else {
        header("location: index.php?status=gagal");
        exit;
    }
} else {
    header("location: index.php?status=invalid");
    exit;
}
?>