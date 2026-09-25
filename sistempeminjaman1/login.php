<?php

session_start();
include "config/koneksi.php";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM akun
    WHERE username='$username' AND password='$password'"));

    if($data){

        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        if($data['role'] == 'admin'){
            header("Location: admin/dashboard.php");
        }else{
            header("Location: user/dashboard.php");
        }

        exit;

    }else{
        $pesan = "Username atau password salah";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login">

    <h2>Peminjaman Lab</h2>

    <?php if(isset($pesan)){ ?>
        <p class="error"><?= $pesan ?></p>
        
    <?php } ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">Login</button>

    </form>
    <p>Belum punya akun?</p>
    <a href="daftar.php">Buat Akun</a>
</div>
</body>
</html>