<?php
include "../security.php";
include "../../koneksi.php";

$error = "";
$data = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_renungan WHERE id_renungan = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$data) {
        header("Location: index.php?status=gagal");
        exit;
    }
} else {
    header("Location: index.php?status=invalid");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_renungan = (int) $_POST['id_renungan'];
    $isi_ayat = trim($_POST['isi_ayat'] ?? '');
    $isi_lengkap = trim($_POST['isi_lengkap'] ?? '');
    $referensi_ayat = trim($_POST['referensi_ayat'] ?? '');
    $tanggal_publish = trim($_POST['tanggal_publish'] ?? '');
    $link_sumber = trim($_POST['link_sumber'] ?? '');
    $gambar_lama = $data['gambar_renungan'];

    if (empty($isi_ayat) || empty($isi_lengkap) || empty($referensi_ayat) || empty($tanggal_publish)) {
        $error = "Isi Ayat, Isi Renungan Lengkap, Referensi Ayat, dan Tanggal Publish wajib diisi.";
        $data = [
            'id_renungan' => $id_renungan,
            'isi_ayat' => $isi_ayat,
            'isi_lengkap' => $isi_lengkap,
            'referensi_ayat' => $referensi_ayat,
            'tanggal_publish' => $tanggal_publish,
            'link_sumber' => $link_sumber,
            'gambar_renungan' => $gambar_lama
        ];
    } else {
        $nama_file = $gambar_lama;

        // Kalau ada gambar baru diupload, ganti gambar lama
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ekstensi = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
            $maks_ukuran = 3 * 1024 * 1024;

            if (!in_array($ekstensi, $ekstensi_diizinkan)) {
                $error = "Format file tidak didukung.";
            } elseif ($_FILES['gambar']['size'] > $maks_ukuran) {
                $error = "Ukuran file terlalu besar (maks 3MB).";
            } elseif (getimagesize($_FILES['gambar']['tmp_name']) === false) {
                $error = "File yang diupload bukan gambar valid.";
            } else {
                $nama_file_baru = uniqid('renungan_', true) . '.' . $ekstensi;
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], "../img/" . $nama_file_baru)) {
                    // Hapus gambar lama
                    if (file_exists("../img/" . $gambar_lama)) {
                        unlink("../img/" . $gambar_lama);
                    }
                    $nama_file = $nama_file_baru;
                } else {
                    $error = "Gagal upload gambar baru.";
                }
            }
        }

        if (empty($error)) {
            $stmt = mysqli_prepare($conn, "UPDATE tb_renungan SET isi_ayat = ?, isi_lengkap = ?, referensi_ayat = ?, gambar_renungan = ?, tanggal_publish = ?, link_sumber = ? WHERE id_renungan = ?");
            mysqli_stmt_bind_param($stmt, "ssssssi", $isi_ayat, $isi_lengkap, $referensi_ayat, $nama_file, $tanggal_publish, $link_sumber, $id_renungan);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: index.php?status=ubah_sukses");
                exit;
            } else {
                $error = "Gagal menyimpan perubahan.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Renungan</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <?php include "../sidebar.php"; ?>
        <div class="main-content">
            <h1>Ubah Renungan</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="ubah.php?id=<?= $data['id_renungan']; ?>" method="POST" enctype="multipart/form-data" class="form-admin">
                <input type="hidden" name="id_renungan" value="<?= htmlspecialchars($data['id_renungan'] ?? ''); ?>">

                <label for="isi_ayat">Isi Ayat</label>
                <textarea name="isi_ayat" id="isi_ayat" rows="4" required><?= htmlspecialchars($data['isi_ayat'] ?? ''); ?></textarea>

                <label for="referensi_ayat">Referensi Ayat</label>
                <input type="text" name="referensi_ayat" id="referensi_ayat" value="<?= htmlspecialchars($data['referensi_ayat'] ?? ''); ?>" required>

                <label for="isi_lengkap">Isi Lengkap</label>
                <textarea name="isi_lengkap" id="isi_lengkap" rows="10" required><?= htmlspecialchars($data['isi_lengkap'] ?? ''); ?></textarea>

                <label>Gambar Saat Ini</label>
                <img src="../img/<?= htmlspecialchars($data['gambar_renungan'] ?? ''); ?>" width="120" style="display:block; margin-bottom:10px; border-radius:8px;">

                <label for="gambar">Ganti Gambar (opsional)</label>
                <input type="file" name="gambar" accept="image/*">

                <label for="tanggal_publish">Tanggal Publish</label>
                <input type="date" name="tanggal_publish" id="tanggal_publish" value="<?= htmlspecialchars(substr($data['tanggal_publish'] ?? '', 0, 10)); ?>" required>

                <label for="link_sumber">Link Sumber Artikel (opsional)</label>
                <input type="url" name="link_sumber" id="link_sumber" value="<?= htmlspecialchars($data['link_sumber'] ?? ''); ?>">

                <div class="form-actions">
                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                    <a href="index.php" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>