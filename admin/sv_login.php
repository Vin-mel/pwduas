<?php 
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../login.php");
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($username) || empty($password)) {
    header("Location: login.php?error=1");
    exit;
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$password_md5 = md5($password);

$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username' AND password='$password_md5'");
$cek = mysqli_num_rows($query);

if($cek > 0) {
    $data = mysqli_fetch_assoc($query);

    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];

    header("Location: dashboard.php");
    exit;
} else {
        header("Location: login.php?error=1");
}