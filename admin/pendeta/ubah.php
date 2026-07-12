<?php
include "../security.php";
include "../../koneksi.php";

$error = "";
$data = null;

// Ambil data yang mau diedit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_pendeta WHERE id_pendeta = ?");
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

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pendeta = (int) $_POST['id_pendeta'];
    $nama_pendeta = trim($_POST['nama_pendeta'] ?? '');
    $biodata = trim($_POST['biodata'] ?? '');
    $foto_lama = $data['foto_pendeta'];

    if ($nama_pendeta === '' || $biodata === '') {
        $error = "Nama dan Biodata wajib diisi.";
        $data = [
            'id_pendeta' => $id_pendeta,
            'nama_pendeta' => $nama_pendeta,
            'biodata' => $biodata,
            'foto_pendeta' => $foto_lama
        ];
    } else {
        $nama_file = $foto_lama;

        // Kalau ada foto baru diupload, ganti foto lama
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ekstensi = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
            $maks_ukuran = 3 * 1024 * 1024;

            if (!in_array($ekstensi, $ekstensi_diizinkan)) {
                $error = "Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.";
            } elseif ($_FILES['gambar']['size'] > $maks_ukuran) {
                $error = "Ukuran file terlalu besar (maks 3MB).";
            } elseif (getimagesize($_FILES['gambar']['tmp_name']) === false) {
                $error = "File yang diupload bukan gambar valid.";
            } else {
                $nama_file_baru = uniqid('img_', true) . '.' . $ekstensi;
                $folder_upload = "../img/";
                if (!is_dir($folder_upload)) {
                    mkdir($folder_upload, 0755, true);
                }

                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $folder_upload . $nama_file_baru)) {
                    // Hapus foto lama biar gak numpuk sampah file
                    if (file_exists($folder_upload . $foto_lama)) {
                        unlink($folder_upload . $foto_lama);
                    }
                    $nama_file = $nama_file_baru;
                } else {
                    $error = "Gagal upload foto baru.";
                }
            }
        }

        if (empty($error)) {
            $stmt = mysqli_prepare($conn, "UPDATE tb_pendeta SET nama_pendeta = ?, biodata = ?, foto_pendeta = ? WHERE id_pendeta = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $nama_pendeta, $biodata, $nama_file, $id_pendeta);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: index.php?status=ubah_sukses");
                exit;
            } else {
                $error = "Gagal menyimpan perubahan, coba lagi.";
            }
            mysqli_stmt_close($stmt);
        }

        // Kalau ada error, pastikan data yang ditampilkan ulang tetap lengkap
        $data = [
            'id_pendeta' => $id_pendeta,
            'nama_pendeta' => $nama_pendeta,
            'biodata' => $biodata,
            'foto_pendeta' => $nama_file
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Pendeta</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <?php include "../sidebar.php"; ?>
        <div class="main-content">
            <h1>Ubah Pendeta</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="ubah.php?id=<?= $data['id_pendeta']; ?>" method="POST" enctype="multipart/form-data" class="form-admin">
                <input type="hidden" name="id_pendeta" value="<?= htmlspecialchars($data['id_pendeta']); ?>">

                <label>Foto Saat Ini</label>
                <img src="../img/<?= htmlspecialchars($data['foto_pendeta']); ?>" width="120" style="display:block; margin-bottom:10px; border-radius:8px;">

                <label for="gambar">Ganti Foto (opsional)</label>
                <input type="file" name="gambar" id="gambar" accept="image/*">

                <label for="nama_pendeta">Nama Pendeta</label>
                <input type="text" name="nama_pendeta" id="nama_pendeta" value="<?= htmlspecialchars($data['nama_pendeta']); ?>" required>

                <label for="biodata">Biodata</label>
                <textarea name="biodata" id="biodata" rows="6" required><?= htmlspecialchars($data['biodata']); ?></textarea>

                <div class="form-actions">
                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                    <a href="index.php" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>