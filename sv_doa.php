<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $isi_doa = trim($_POST['isi_doa'] ?? '');

    if (empty($nama_lengkap) || empty($isi_doa)) {
        $_SESSION['doa_status'] = 'kosong';
        header("Location: index.php");
        exit;
    }

    $tanggal_kirim = date('Y-m-d H:i:s');

    $stmt = mysqli_prepare($conn, "INSERT INTO tb_doa (nama_lengkap, isi_doa, tanggal_kirim) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $nama_lengkap, $isi_doa, $tanggal_kirim);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['doa_status'] = 'berhasil';
    } else {
        $_SESSION['doa_status'] = 'gagal';
    }

    mysqli_stmt_close($stmt);
    header("Location: index.php");
    exit;
}
?>