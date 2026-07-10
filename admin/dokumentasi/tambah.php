<?php
include "../security.php";
include "../../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

        $nama_file = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $ukuran = $_FILES['gambar']['size'];

        $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        $maks_ukuran = 3 * 1024 * 1024;

        if (!in_array($ekstensi, $ekstensi_diizinkan)) {
            $error = "Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.";
        } elseif ($ukuran > $maks_ukuran) {
            $error = "Ukuran file terlalu besar (maks 3MB).";
        } elseif (getimagesize($tmp_name) === false) {
            $error = "File yang diupload bukan gambar valid.";
        } else {

            $nama_file = uniqid('img_', true) . '.' . $ekstensi;

        $folder_upload = "../img/";
        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0755, true);
        }
        $folder_tujuan = $folder_upload . $nama_file;

        if (move_uploaded_file($tmp_name, $folder_tujuan)) {
            $stmt = mysqli_prepare($conn, "INSERT INTO tb_dokumentasi (nama_file_gambar, id_user) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "si", $nama_file, $id_user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal upload gambar.";
        }
                }
            } else {
                $error = "Pilih file gambar terlebih dahulu.";
            }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Dokumentasi</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <?php include "../sidebar.php"; ?>
        <div class="main-content">
            <h1>Tambah Dokumentasi</h1>

            <?php if (!empty($error)) { ?>
                <p class="error-message"><?= htmlspecialchars($error); ?></p>
            <?php } ?>

            <form action="tambah.php" method="POST" enctype="multipart/form-data" class="form-admin">
                <label>Pilih Gambar:</label><br>
                <input type="file" name="gambar" accept="image/*" required><br><br>

                <div class="form-actions">
                <button type="submit" class="btn-upload">Upload</button>
                <a href="index.php" class="btn-batal">Batal</a>
</div>
            </form>
        </div>
    </div>
</body>
</html>