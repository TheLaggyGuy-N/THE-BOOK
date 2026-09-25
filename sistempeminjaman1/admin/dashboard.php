<?php
session_start();
include "../config/koneksi.php";
if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="menu">
    <h2>Peminjaman Lab</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="alat.php">Data Alat</a>
    <a href="peminjaman.php">Peminjaman</a>
    <a href="../logout.php">Logout</a>
</div>
<div class="isi">
    <h1>Dashboard Admin</h1>
    <div class="box">
        <h2>Selamat Datang</h2>
        <p>Halo, <?= $_SESSION['nama'] ?></p>
    </div>
</div>
</body>
</html>