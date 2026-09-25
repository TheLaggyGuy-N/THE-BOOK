<?php

session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

if(isset($_POST['tambah'])){
    $nama = $_POST['nama_alat'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($conn,"INSERT INTO alat (nama_alat,jumlah)
    VALUES ('$nama','$jumlah')");

    header("Location: alat.php");
    exit;
}

if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $nama = $_POST['nama_alat'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($conn,"UPDATE alat SET
    nama_alat='$nama', jumlah='$jumlah'
    WHERE id='$id'");

    header("Location: alat.php");
    exit;
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    mysqli_query($conn,"DELETE FROM alat WHERE id='$id'");

    header("Location: alat.php");
    exit;
}

$data = mysqli_query($conn,"SELECT * FROM alat");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Alat</title>
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
    <h1>Data Alat</h1>

    <div class="box">
        <h3>Tambah Alat</h3>

        <form method="POST">
            <input type="text" name="nama_alat" placeholder="Nama alat" required>
            <input type="number" name="jumlah" placeholder="Jumlah" required>
            <button name="tambah">Tambah</button>
        </form>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Alat</th>
            <th>Jumlah</th>
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
            <td>
                <a href="alat.php?edit=<?= $row['id'] ?>">Edit</a> |
                <a href="alat.php?hapus=<?= $row['id'] ?>"
                onclick="return confirm('Hapus alat?')">Hapus</a>
            </td>
        </tr>

        <?php } ?>
    </table>

    <?php
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $edit = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM alat WHERE id='$id'"));
    ?>

    <div class="box">
        <h3>Edit Alat</h3>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $edit['id'] ?>">

            <input type="text" name="nama_alat"
            value="<?= $edit['nama_alat'] ?>" required>

            <input type="number" name="jumlah"
            value="<?= $edit['jumlah'] ?>" required>

            <button name="edit">Simpan</button>
        </form>
    </div>

    <?php } ?>

</div>

</body>
</html>