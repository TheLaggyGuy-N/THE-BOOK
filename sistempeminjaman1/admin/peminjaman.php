<?php

session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$data = mysqli_query($conn,"SELECT * FROM peminjaman");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman</title>
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
    <h1>Data Peminjaman</h1>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
        </tr>

        <?php
        $no = 1;
        while($row = mysqli_fetch_assoc($data)){
        ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_user'] ?></td>
            <td><?= $row['nama_alat'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= $row['tanggal_pinjam'] ?></td>
            <td><?= $row['tanggal_kembali'] ?></td>
            <td><?= $row['status'] ?></td>
        </tr>

        <?php } ?>
    </table>
</div>

</body>
</html>