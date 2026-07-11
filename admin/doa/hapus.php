<?php
include "../security.php";
include "../../koneksi.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM tb_doa WHERE id_doa = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        header("location: index.php?status=sukses");
        exit;
    } else {
        mysqli_stmt_close($stmt);
        header("location: index.php?status=gagal");
        exit;
    }
} else {
    header("location: index.php?status=invalid");
    exit;
}
?>