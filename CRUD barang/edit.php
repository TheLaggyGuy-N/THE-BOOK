<?php
$id_brg = $_GET['id_barang'];

include "Koneksi.php";
$data = mysqli_query($koneksi, "SELECT * FROM table_barang WHERE id_barang='$id_brg'");

foreach($data as $i) {
    echo $i['nama_brg'];
    echo $i['berat_brg'];
    echo $i['expired'];
    echo $i['harga'];
    echo $i['stok'];
}

$query = mysqli_fetch()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<body>
    <h1>EDIT DATA</h1>

    <form action="proses_edit.php" method="POST">
        <label for="">Id Barang</label>
        <input type="number" name="id_bar" value="<?=$i['id_barang'];?>" readonly><br>

        <label for="">Nama Barang</label>
        <input type="text" name="na_bar" value="<?=$i['nama_brg'];?>"><br>

        <label for="">Berat Barang</label>
        <input type="number" name="bb" value="<?=$i['berat_brg'];?>"><br>

        <label for="">Tanggal Kadaluarsa Barang</label>
        <input type="date" name="exp" value="<?=$i['expired'];?>"><br>

        <label for="">Harga Barang</label>
        <input type="number" name="harga" value="<?=$i['harga'];?>"><br>

        <label for="">Stok Barang</label>
        <input type="number" name="stok" value="<?=$i['berat_brg'];?>"><br>

        <button type="submit">EDIT</button>
    </form>
</body>
</html>
