<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$error = "";
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    $query  = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id_user']  = $row['id_user'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama']     = $row['nama'];
        $_SESSION['level']    = $row['level'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - LaundryKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .card-login { width: 400px; border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="card card-login p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">LaundryKu</h3>
        <p class="text-muted">Silakan Login Untuk Masuk Ke Sistem</p>
    </div>
    <?php if($error): ?>
        <div class="alert alert-danger p-2 text-center" style="font-size:14px;"><?= $error; ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 py-2">Masuk</button>
    </form>
</div>
</body>
</html>