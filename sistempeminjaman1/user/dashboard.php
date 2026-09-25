<?php

session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'user'){
    header("Location: ../login.php");
    exit;
}

$data = mysqli_query($conn,"SELECT * FROM alat");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="menu">
    <h2>Peminjaman Lab</h2>
    <a href="dashboard.php">Beranda</a>
    <a href="pinjam.php">Peminjaman</a>
    <a href="pengembalian.php">Pengembalian</a>
    <a href="riwayat.php">Riwayat</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="isi">
    <h1>Halo, <?= $_SESSION['nama'] ?></h1>
    <h3>Daftar Alat</h3>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Alat</th>
            <th>Jumlah</th>
        </tr>

        <?php
        $no = 1;
        while($row = mysqli_fetch_assoc($data)){
        ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_alat'] ?></td>
            <td><?= $row['jumlah'] ?></td>
        </tr>

        <?php } ?>
    </table>
</div>

</body>
</html>