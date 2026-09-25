<?php

session_start();
include "../config/koneksi.php";

if($_SESSION['role'] != 'user'){
    header("Location: ../login.php");
    exit;
}

if(isset($_GET['kembali'])){

    $id = $_GET['kembali'];

    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM peminjaman WHERE id='$id'"));

    mysqli_query($conn,"UPDATE peminjaman SET status='Dikembalikan' WHERE id='$id'");

    mysqli_query($conn,"UPDATE alat SET jumlah=jumlah+{$data['jumlah']} WHERE nama_alat='{$data['nama_alat']}'");

    header("Location: pengembalian.php");
    exit;
}

$data = mysqli_query($conn,"SELECT * FROM peminjaman
WHERE nama_user='$_SESSION[nama]' AND status='Dipinjam'");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengembalian</title>
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
    <h1>Pengembalian</h1>

    <table>
        <tr>
            <th>No</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tanggal Kembali</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while($row = mysqli_fetch_assoc($data)){
        ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_alat'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= $row['tanggal_kembali'] ?></td>
            <td>
                <a href="pengembalian.php?kembali=<?= $row['id'] ?>">
                    Kembalikan
                </a>
            </td>
        </tr>

        <?php } ?>
    </table>
</div>

</body>
</html>