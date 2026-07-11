<?php
include "../security.php";
include "../../koneksi.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM tb_doa WHERE id_doa = '$id'");

    header("location: index.php");
    exit;
}
?>