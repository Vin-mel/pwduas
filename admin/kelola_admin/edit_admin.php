<?php
include "../security.php";
include "../../koneksi.php";

$error = "";
$data = null;

// Ambil data admin yang mau diedit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT id_user, username FROM tb_user WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$data) {
        header("Location: kelola_admin.php?status=gagal");
        exit;
    }
} else {
    header("Location: kelola_admin.php?status=invalid");
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = (int) $_POST['id_user'];
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $konfirmasi = trim($_POST['konfirmasi'] ?? '');

    if (empty($username)) {
        $error = "Username wajib diisi.";
        $data = ['id_user' => $id_user, 'username' => $username];
    } elseif (!empty($password) && strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
        $data = ['id_user' => $id_user, 'username' => $username];
    } elseif (!empty($password) && $password !== $konfirmasi) {
        $error = "Konfirmasi password tidak cocok.";
        $data = ['id_user' => $id_user, 'username' => $username];
    } else {
        // Cek username sudah dipakai user lain atau belum
        $cekStmt = mysqli_prepare($conn, "SELECT id_user FROM tb_user WHERE username = ? AND id_user != ?");
        mysqli_stmt_bind_param($cekStmt, "si", $username, $id_user);
        mysqli_stmt_execute($cekStmt);
        mysqli_stmt_store_result($cekStmt);

        if (mysqli_stmt_num_rows($cekStmt) > 0) {
            $error = "Username sudah dipakai admin lain, pilih username lain.";
            $data = ['id_user' => $id_user, 'username' => $username];
        } else {
            if (!empty($password)) {
                // Ganti username DAN password
                $password_md5 = md5($password);
                $stmt = mysqli_prepare($conn, "UPDATE tb_user SET username = ?, password = ? WHERE id_user = ?");
                mysqli_stmt_bind_param($stmt, "ssi", $username, $password_md5, $id_user);
            } else {
                // Cuma ganti username, password tetap
                $stmt = mysqli_prepare($conn, "UPDATE tb_user SET username = ? WHERE id_user = ?");
                mysqli_stmt_bind_param($stmt, "si", $username, $id_user);
            }

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);

                // Kalau admin ganti username akun sendiri, update juga sesi biar sidebar tetap benar
                if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $id_user) {
                    $_SESSION['username'] = $username;
                }

                header("Location: kelola_admin.php?status=ubah_sukses");
                exit;
            } else {
                $error = "Gagal menyimpan perubahan.";
                $data = ['id_user' => $id_user, 'username' => $username];
            }
        }
        mysqli_stmt_close($cekStmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <?php include "../sidebar.php"; ?>
        <div class="main-content">
            <h1>Edit Admin</h1>
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="edit_admin.php?id=<?= $data['id_user']; ?>" method="POST" class="form-admin">
                <input type="hidden" name="id_user" value="<?= htmlspecialchars($data['id_user']); ?>">

                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($data['username']); ?>" required>

                <label for="password">Password Baru (opsional, kosongkan jika tidak diganti)</label>
                <input type="password" name="password" id="password" minlength="6">

                <label for="konfirmasi">Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi" id="konfirmasi" minlength="6">

                <div class="form-actions">
                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                    <a href="kelola_admin.php" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 