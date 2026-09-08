<?php
$brg=$_POST['barang'];
$bb=$_POST['bb'];
$exp=$_POST['exp'];
$harga=$_POST['harga'];
$stok=$_POST['stok'];

// var_dump($brg,$bb,$exp,$harga,$stok);
include "koneksi.php";
mysqli_query($koneksi, "INSERT INTO table_barang VALUES(NULL, '$brg', '$bb', '$exp', '$harga','$stok')");
// berpindah secara otomatis ketika sudah melaksanakan query
header("location:tampil.php");
?>