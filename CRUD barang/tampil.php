<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tampil</title>
</head>
<body>
    <marquee direction="right" scrollamount="15">
        <img src="../gambar/po.png" width="2000px" height="100px"/> <img src="../gambar/po.png" width="2000px" height="100px"/>
    </marquee>
    <hr>
    <h1>Data Barang Toko Nicko</h1>
<table border="1px">
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Berat Barang</th>
        <th>Expired</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
<?php
    include "Koneksi.php";
    $no=1;
    $data = mysqli_query($koneksi,"SELECT * FROM table_barang");
    foreach($data as $i){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?=$i['nama_brg']; ?></td>
    <td><?=$i['berat_brg'];?> g</td>
    <td><?=$i['expired']; ?></td>
    <td>Rp. <?=$i['harga']; ?></td>
    <td><?=$i['stok']; ?></td>
    <td>
        <a href="hapus.php?id_barang=  <?=$i['id_barang']; ?>  ">Hapus.</a>
        <a href="edit.php?id_barang=   <?=$i['id_barang']; ?>  ">Edit.</a>
    </td>
</tr>
<?php } ?>
    </table>
    <a href="tambah_barang.php">Tambah Barang</a>
    <hr>
</body>
</html>