<!DOCTYPE html>
<html>
<head>
    <title>Edit Berkas</title>
</head>
<body>
    <h2>Edit Berkas</h2>

    <p>
        <a href="index.php?page=beranda">Beranda</a> |
        <a href="index.php?page=berkasInternal">Berkas Internal</a> |
        <a href="index.php?page=listBerkas">List Berkas</a> |
        <a href="index.php?page=logout">Logout</a>
    </p>

    <form action="index.php?page=prosesEdit" method="POST">
        <input type="hidden" name="id_berkas" value="<?php echo $data['id_berkas']; ?>">

        <p>
            Nama Dokumen : <br>
            <input type="text" name="n_dokumen" value="<?php echo $data['n_dokumen']; ?>">
        </p>

        <p>
            Tanggal Kirim : <br>
            <input type="date" name="tgl_kirim" value="<?php echo $data['tgl_kirim']; ?>">
        </p>

        <p>
            Tujuan : <br>
            <input type="text" name="tujuan" value="<?php echo $data['tujuan']; ?>">
        </p>

        <p>
            Keterangan : <br>
            <textarea name="keterangan" rows="4" cols="40"><?php echo $data['keterangan']; ?></textarea>
        </p>

        <button type="submit">Update</button>
    </form>
</body>
</html>
