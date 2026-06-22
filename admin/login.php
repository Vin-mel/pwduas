<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Login Admin - GKKB</title>
        <link rel="stylesheet" href="../css/login.css">
</head>
<body class="login-page">

<div class="login-container">
    <div class="login-header">
        <h2>Login Admin</h2>
        <p>GKKB Purnama</p>
</div>

<?php if (isset($_GET['error'])): ?>
    <div class="login-error">
        Username atau password salah, atau belum diisi.
</div>
<?php endif; ?>

<form action="sv_login.php" method="POST">
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" required>
</div>

<div class="input-group">
    <label>Password</label>
    <input type="password" name="password" required>
</div>

<button type="submit" class="btn-login">Login</button>
        </form>
    </div>

</body>
</html>