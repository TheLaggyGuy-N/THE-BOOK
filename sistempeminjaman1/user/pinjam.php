<?php

session_start();
include "../config/koneksi.php";

if($_SESSION['role'] != 'user'){
    header("Location: ../login.php");
    exit;
}

if(isset($_POST['pinjam'])){

    $id = $_POST['id_alat'];
    $jumlah = $_POST['jumlah'];
    $pinjam = $_POST['tanggal_pinjam'];
    $kembali = $_POST['tanggal_kembali'];
    $nama = $_SESSION['nama'];

    $alat = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM alat WHERE id='$id'"));

    if($jumlah <= $alat['jumlah']){

        mysqli_query($conn,"INSERT INTO peminjaman
        VALUES(NULL,'$nama','$alat[nama_alat]','$jumlah','$pinjam','$kembali','Dipinjam')");

        mysqli_query($conn,"UPDATE alat SET jumlah=jumlah-$jumlah WHERE id='$id'");

        header("Location: riwayat.php");
        exit;

    }else{
        echo "<script>alert('Jumlah alat tidak cukup');</script>";
    }
}

$data = mysqli_query($conn,"SELECT * FROM alat");

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
    <a href="dashboard.php">Beranda</a>
    <a href="pinjam.php">Peminjaman</a>
    <a href="pengembalian.php">Pengembalian</a>
    <a href="riwayat.php">Riwayat</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="isi">
    <h1>Peminjaman Alat</h1>

    <div class="box">
        <form method="POST">

            <label>Alat</label>
            <select name="id_alat">
                <?php while($alat=mysqli_fetch_assoc($data)){ ?>
                    <option value="<?= $alat['id'] ?>">
                        <?= $alat['nama_alat'] ?> - <?= $alat['jumlah'] ?>
                    </option>
                <?php } ?>
            </select>

            <label>Jumlah</label>
            <input type="number" name="jumlah" min="1" required>

        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" required>

            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" required>


            <button name="pinjam">Pinjam</button>

        </form>
    </div>
</div>

</body>
</html>