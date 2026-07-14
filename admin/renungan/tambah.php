<?php
include "../security.php";
include "../../koneksi.php";

$id_user = $_SESSION['id_user'];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_renungan = trim($_POST['judul_renungan'] ?? '');
    $isi_ayat = trim($_POST['isi_ayat'] ?? '');
    $isi_ayat_singkat = trim($_POST['isi_ayat_singkat'] ?? '');
    $isi_lengkap = trim($_POST['isi_lengkap'] ?? '');
    $referensi_ayat = trim($_POST['referensi_ayat'] ?? '');
    $tanggal_publish = trim($_POST['tanggal_publish'] ?? '');
    $link_sumber = trim($_POST['link_sumber'] ?? '');

    if (empty($judul_renungan) || empty($isi_ayat) || empty($isi_ayat_singkat) || empty($isi_lengkap) || empty($referensi_ayat) || empty($tanggal_publish)) {
        $error = "Judul, Isi Ayat, Isi Ayat Singkat, Isi Renungan Lengkap, Referensi Ayat, dan Tanggal Publish wajib diisi.";
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
                $stmt = mysqli_prepare($conn, "INSERT INTO tb_renungan (judul_renungan, isi_ayat, isi_ayat_singkat, isi_lengkap, referensi_ayat, gambar_renungan, tanggal_publish, id_user, link_sumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sssssssis", $judul_renungan, $isi_ayat, $isi_ayat_singkat, $isi_lengkap, $referensi_ayat, $nama_file, $tanggal_publish, $id_user, $link_sumber);
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
                <label for="judul_renungan">Judul Renungan</label>
                <input type="text" name="judul_renungan" id="judul_renungan" placeholder="Misal: Allah Terus Bekerja" required>

                <label for="referensi_ayat">Referensi Ayat</label>
                <input type="text" name="referensi_ayat" id="referensi_ayat" placeholder="Misal: Yohanes 3:16" required>

                <label for="isi_ayat_singkat">Isi Ayat Singkat (untuk tampilan publik di beranda)</label>
                <textarea name="isi_ayat_singkat" id="isi_ayat_singkat" rows="3" placeholder="Cuplikan pendek ayat, akan tampil di halaman utama..." required></textarea>

                <label for="isi_ayat">Isi Ayat Lengkap (untuk halaman detail, boleh sepanjang apapun)</label>
                <textarea name="isi_ayat" id="isi_ayat" rows="6" placeholder="Tuliskan isi ayat lengkap renungan..." required></textarea>

                <label for="isi_lengkap">Isi Renungan Lengkap</label>
                <textarea name="isi_lengkap" id="isi_lengkap" rows="10" placeholder="Tuliskan Renungan Lengkap di sini...." required></textarea>

                <label for="gambar">Gambar Renungan</label>
                <input type="file" name="gambar" accept="image/*" required>

                <label for="tanggal_publish">Tanggal Publish</label>
                <input type="date" name="tanggal_publish" id="tanggal_publish" required>

                <label for="link_sumber">Link Sumber Artikel (opsional, kalau ada referensi tambahan)</label>
                <input type="url" name="link_sumber" id="link_sumber" placeholder="https://...">

                <div class="form-actions">
                    <button type="submit" class="btn-simpan">Simpan</button>
                    <a href="index.php" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>