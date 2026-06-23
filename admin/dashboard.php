<?php 
include "security.php";

$username = $_SESSION["username"];

echo "welcome, ".$username."<br>";
?>
<a href= "dokumentasi/index.php">Manajemen Dokumentasi </a> <br>
<a href= "jadwal/index.php">Manajemen Jadwal </a> <br>
<a href= "renungan/index.php">Manajemen Renungan </a> <br>
<a href= "pendeta/index.php">Manajemen Pendeta </a> <br>
<a href= "doa/index.php">Manajemen Doa </a> <br>
<a href= "logout.php">Log out </a> <br>
