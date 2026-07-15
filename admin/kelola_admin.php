<?php
include "security.php";
include "../koneksi.php";

$error = "";
$sukses = "";

// Tambah admin baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'tambah') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $konfirmasi = trim($_POST['konfirmasi'] ?? '');

    if (empty($username) || empty($password) || empty($konfirmasi)) {
        $error = "Semua field wajib diisi.";
    } elseif ($password !== $konfirmasi) {
        $error = "Konfirmasi password tidak cocok.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        // Cek username sudah dipakai atau belum
        $cekStmt = mysqli_prepare($conn, "SELECT id_user FROM tb_user WHERE username = ?");
        mysqli_stmt_bind_param($cekStmt, "s", $username);
        mysqli_stmt_execute($cekStmt);
        mysqli_stmt_store_result($cekStmt);

        if (mysqli_stmt_num_rows($cekStmt) > 0) {
            $error = "Username sudah dipakai, pilih username lain.";
        } else {
            $password_md5 = md5($password);
            $insertStmt = mysqli_prepare($conn, "INSERT INTO tb_user (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($insertStmt, "ss", $username, $password_md5);

            if (mysqli_stmt_execute($insertStmt)) {
                $sukses = "Admin baru '$username' berhasil ditambahkan.";
            } else {
                $error = "Gagal menambahkan admin.";
            }
            mysqli_stmt_close($insertStmt);
        }
        mysqli_stmt_close($cekStmt);
    }
}

// Hapus admin
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id_hapus = (int) $_GET['hapus'];

    // Cegah admin menghapus akun dirinya sendiri saat masih login
    if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $id_hapus) {
        $error = "Kamu tidak bisa menghapus akunmu sendiri saat sedang login.";
    } else {
        $delStmt = mysqli_prepare($conn, "DELETE FROM tb_user WHERE id_user = ?");
        mysqli_stmt_bind_param($delStmt, "i", $id_hapus);
        if (mysqli_stmt_execute($delStmt)) {
            $sukses = "Admin berhasil dihapus.";
        } else {
            $error = "Gagal menghapus admin.";
        }
        mysqli_stmt_close($delStmt);
    }
}

// Ambil daftar admin
$daftarAdmin = mysqli_query($conn, "SELECT id_user, username FROM tb_user ORDER BY id_user ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Admin</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <?php include "sidebar.php"; ?>
        <div class="main-content">
            <h1>Kelola Admin</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if (!empty($sukses)): ?>
                <div class="alert alert-sukses"><?= htmlspecialchars($sukses); ?></div>
            <?php endif; ?>

            <h2>Tambah Admin Baru</h2>
            <form method="POST" class="form-admin">
                <input type="hidden" name="aksi" value="tambah">

                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required minlength="6">

                <label for="konfirmasi">Konfirmasi Password</label>
                <input type="password" name="konfirmasi" id="konfirmasi" required minlength="6">

                <div class="form-actions">
                    <button type="submit" class="btn-simpan">Tambah Admin</button>
                </div>
            </form>

            <h2>Daftar Admin</h2>
            <table class="tabel-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($daftarAdmin)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_user']); ?></td>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td>
                                <a href="kelola_admin.php?hapus=<?= $row['id_user']; ?>"
                                   onclick="return confirm('Yakin mau hapus admin ini?');"
                                   class="btn-hapus">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>