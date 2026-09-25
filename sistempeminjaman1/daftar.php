<?php

include "config/koneksi.php";

if(isset($_POST['daftar'])){

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn,"INSERT INTO akun
    (nama,username,password,role)
    VALUES
    ('$nama','$username','$password','user')");

    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Akun</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login">

    <h2>Buat Akun</h2>

    <form method="POST">

        <input type="text" name="nama" placeholder="Nama" required>

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button name="daftar">Daftar</button>

    </form>

    <p>
        <a href="login.php">Kembali ke Login</a>
    </p>

</div>

</body>
</html>