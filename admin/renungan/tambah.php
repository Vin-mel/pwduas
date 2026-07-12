<?php
include "../security.php";
include "../../koneksi.php";

$id_user = $_SESSION['id_user'];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isi_ayat = trim($_POST['isi_ayat'] ?? '');
    $referensi_ayat = trim($_POST['referensi_ayat'] ?? '');
    $tanggal_publish = trim($_POST['tanggal_publish'] ?? '');
    $link_sumber = trim($_POST['link_sumber'] ?? '');

    if (empty($isi_ayat) || empty($referensi_ayat) || empty($tanggal_publish) || empty($link_sumber)) {
        $error = "Semua field wajib diisi.";
    } elseif (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != 0) {
        $error = "Pilih gambar renungan terlebih dahulu.";
    } else {
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
            $nama_file = uniqid('renungan_', true) . '.' . $ekstensi;
            $folder_upload = "../img/";
            if (!is_dir($folder_upload)) {
                mkdir($folder_upload, 0755, true);
            }
            $folder_tujuan = $folder_upload . $nama_file;

            if (move_uploaded_file($tmp_name, $folder_tujuan)) {
                $stmt = mysqli_prepare($conn, "INSERT INTO tb_renungan (isi_ayat, referensi_ayat, gambar_renungan, tanggal_publish, id_user, link_sumber) VALUES (?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "ssssis", $isi_ayat, $referensi_ayat, $nama_file, $tanggal_publish, $id_user, $link_sumber);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                header("Location: index.php?status=tambah_sukses");
                exit;
            } else {
                $error = "Gagal upload gambar.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Renungan</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <?php include "../sidebar.php"; ?>
        <div class="main-content">
            <h1>Tambah Renungan</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="tambah.php" method="POST" enctype="multipart/form-data" class="form-admin">
                <label for="isi_ayat">Isi Ayat</label>
                <textarea name="isi_ayat" id="isi_ayat" rows="4" placeholder="Tuliskan isi ayat renungan..." required></textarea>

                <label for="referensi_ayat">Referensi Ayat</label>
                <input type="text" name="referensi_ayat" id="referensi_ayat" placeholder="Misal: Yohanes 3:16" required>

                <label for="gambar">Gambar Renungan</label>
                <input type="file" name="gambar" accept="image/*" required>

                <label for="tanggal_publish">Tanggal Publish</label>
                <input type="date" name="tanggal_publish" id="tanggal_publish" required>

                <label for="link_sumber">Link Sumber Artikel</label>
                <input type="url" name="link_sumber" id="link_sumber" placeholder="https://..." required>

                <div class="form-actions">
                    <button type="submit" class="btn-simpan">Simpan</button>
                    <a href="index.php" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>