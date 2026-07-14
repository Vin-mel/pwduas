<?php
$halaman_sekarang = basename($_SERVER['PHP_SELF']);
$prefix = ($halaman_sekarang === 'index.php') ? '' : 'index.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GKKB PURNAMA</title>
    <!-- fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playwrite+NZ+Basic:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- feather icon-->
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="css/gkkb.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="<?= $prefix ?>#home" class="navbar-logo">GKKB<span>Purnama</span></a>
        <div class="navbar-nav">
            <a href="<?= $prefix ?>#home">Home</a>
            <a href="<?= $prefix ?>#renungan">Renungan</a>
            <a href="<?= $prefix ?>#about">Sejarah</a>
            <a href="<?= $prefix ?>#visimisi">Visi & Misi</a>
            <a href="<?= $prefix ?>#dokumentasi">Dokumentasi</a>
            <a href="<?= $prefix ?>#jadwal">Jadwal Ibadah</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="menu"><i data-feather="menu"></i></a>
        </div>
    </nav>