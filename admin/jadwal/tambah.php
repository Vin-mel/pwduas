<?php
include "../security.php";
include "../../koneksi.php";

$id_user = $_SESSION['id_user'];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hari = trim($_POST['hari'] ?? '');
    $nama_kegiatan = trim($_POST['nama_kegiatan'] ?? '');
    $jam_mulai = trim($_POST['jam_mulai'] ?? '');

    if (empty($hari) || empty($nama_kegiatan) || empty($jam_mulai)) {
        $error = "Semua field wajib diisi.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO tb_jadwal (hari, nama_kegiatan, jam_mulai, id_user) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssi", $hari, $nama_kegiatan, $jam_mulai, $id_user);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php?status=tambah_sukses");
            exit;
        } else {
            $error = "Gagal menyimpan data, coba lagi.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Jadwal</title>
  <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
  <div class="admin-layout">
    <?php include "../sidebar.php"; ?>
    <div class="main-content">
      <h1>Tambah Jadwal</h1>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form action="tambah.php" method="POST" class="form-admin">
        <label for="hari">Hari</label>
        <select name="hari" id="hari" required>
          <option value="">-- Pilih Hari --</option>
          <option value="Senin">Senin</option>
          <option value="Selasa">Selasa</option>
          <option value="Rabu">Rabu</option>
          <option value="Kamis">Kamis</option>
          <option value="Jumat">Jumat</option>
          <option value="Sabtu">Sabtu</option>
          <option value="Minggu">Minggu</option>
        </select>

        <label for="nama_kegiatan">Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" id="nama_kegiatan" placeholder="Misal: Ibadah Minggu" required>

        <label for="jam_mulai">Jam Mulai</label>
        <input type="time" name="jam_mulai" id="jam_mulai" required>

        <div class="form-actions">
          <button type="submit" class="btn-simpan">Simpan</button>
          <a href="index.php" class="btn-batal">Batal</a>
        </div>
      </form>

    </div>
  </div>
</body>
</html>