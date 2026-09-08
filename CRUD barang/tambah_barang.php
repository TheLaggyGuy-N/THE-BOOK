<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tambah Barang</h1>
    <form action="proses_tambah.php" method="POST">
        <label>Masukkan Nama Barang</label>
        <input type="text" name="barang">
        <br>
        <label>Masukkan berat Barang</label>
        <input type="number" name="bb">
        <br>
        <label>Masukkan Tangal Kadaluarsa</label>
        <input type="date" name="exp">
        <br>
        <label>Masukkan Harga Barang</label>
        <input type="number" name="harga">
        <br>
        <label">Masukkan Stok</label>
        <input type="number" name="stok">
        <br>
        <button type="submit">Tambah</button>
    </form>
</body>
</html>