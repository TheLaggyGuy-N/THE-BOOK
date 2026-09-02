<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berkas</title>
</head>
<body>
    <h2>Tambah Berkas</h2>

    <p>
        <a href="index.php?page=beranda">Beranda</a> |
        <a href="index.php?page=berkasInternal">Berkas Internal</a> |
        <a href="index.php?page=listBerkas">List Berkas</a> |
        <a href="index.php?page=logout">Logout</a>
    </p>

    <form action="index.php?page=prosesTambah" method="POST">
        <p>
            Nama Dokumen : <br>
            <input type="text" name="n_dokumen">
        </p>

        <p>
            Tanggal Kirim : <br>
            <input type="date" name="tgl_kirim">
        </p>

        <p>
            Tujuan : <br>
            <input type="text" name="tujuan">
        </p>

        <p>
            Keterangan : <br>
            <textarea name="keterangan" rows="4" cols="40"></textarea>
        </p>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
