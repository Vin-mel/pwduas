<?php
include "../security.php";
include "../../koneksi.php";

$error = "";
$data = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_jadwal WHERE id_jadwal = ?");
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_jadwal = (int) $_POST['id_jadwal'];
    $hari = trim($_POST['hari'] ?? '');
    $nama_kegiatan = trim($_POST['nama_kegiatan'] ?? '');
    $jam_mulai = trim($_POST['jam_mulai'] ?? '');
    
    if (empty($hari) || empty($nama_kegiatan) || empty($jam_mulai)) {
        $error = "Semua field wajib diisi.";
        $data = [
            'id_jadwal' => $id_jadwal,
            'hari' => $hari,
            'nama_kegiatan' =>$nama_kegiatan,
            'jam_mulai' => $jam_mulai
        ];
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE tb_jadwal SET hari = ?, nama_kegiatan = ?, jam_mulai =? WHERE id_jadwal = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $hari, $nama_kegiatan, $jam_mulai, $id_jadwal);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php?status=ubah_sukses");
            exit;
        } else {
            $error = "Gagal menyimpan perubahan, coba lagi.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubah Jadwal</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <?php include "../sidebar.php"; ?>
        <div class="main-content">
            <h1>Ubah Jadwal</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                <?php endif; ?>

            <form action="ubah.php?id=<?= $data['id_jadwal']; ?>" method="POST" class="form-admin">
                <input type="hidden" name="id_jadwal"  value="<?= htmlspecialchars($data['id_jadwal']); ?>">

                <label for="hari">Hari</label>
                <select name="hari" id="hari" required>
                    <option  value="">-- Pilih Hari --</option>
                    <?php
                    $daftar_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    foreach ($daftar_hari as $h) {
                        $selected = ($data['hari'] === $h) ? 'selected' : '';
                        echo "<option value=\"$h\" $selected>$h</option>";
                    }
                    ?>
                    </select>

                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="<?= htmlspecialchars($data['nama_kegiatan']); ?>" required>

                    <label for="jam_mulai">Jam_Mulai</label>
                    <input  type="time" name="jam_mulai" id="jam_mulai" value="<?= htmlspecialchars(substr($data['jam_mulai'], 0, 5)); ?>" required>

                    <div class="form-action">
                        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                        <a href="index.php" class="btn-batal">Batal</a>
            </div>
            </form>

            </div>
            </div>
            </body>
            </html>