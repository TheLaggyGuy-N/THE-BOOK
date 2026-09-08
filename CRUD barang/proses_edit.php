<?php
$idbar = $_POST['id_bar'];
$nabar = $_POST['na_bar'];
$bb = $_POST['bb'];
$exp = $_POST['exp'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

include 'Koneksi.php';

mysqli_query($koneksi, "UPDATE table_barang SET nama_brg='$nabar', berat_brg='$bb', 
expired='$exp', harga='$harga', stok='$stok' 
WHERE id_barang='$idbar'");

header("location:tampil.php");