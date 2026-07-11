<?php
include "../security.php";
include "../../koneksi.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM tb_jadwal WHERE id_jadwal = '$id'");

    header("location: index.php");
    exit;
}
?>