<?php
$id_brg = $_GET['id_barang'];
// echo $id_brg;

include "Koneksi.php";
mysqli_query($koneksi, "DELETE FROM table_barang WHERE id_barang='$id_brg'");

header("location:tampil.php");