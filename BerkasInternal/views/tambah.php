<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berkas</title>
</head>
<body>
    <?php $users = $users ?? []; ?>
    <h2>Tambah Berkas</h2>

    <p>
        <a href="index.php?page=beranda">Beranda</a> |
        <a href="index.php?page=berkasInternal">Berkas Internal</a> |
        <a href="index.php?page=listBerkas">List Berkas</a> |
        <a href="index.php?page=logout">Logout</a>
    </p>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </p>
    <?php endif; ?>

    <form action="index.php?page=prosesTambah" method="POST">
        <p>
            Nama Dokumen : <br>
            <input type="text" name="n_dokumen" required>
        </p>

        <p>
            Tanggal Kirim : <br>
            <input type="date" name="tgl_kirim" required>
        </p>

        <p>
            Tujuan : <br>
            <select name="tujuan" required>
                <option value="">-- Pilih Tujuan --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['nama']); ?>">
                        <?php echo htmlspecialchars($user['nama'] . ' (' . $user['username'] . ') - ' . $user['bagian']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            Keterangan : <br>
            <textarea name="keterangan" rows="4" cols="40"></textarea>
        </p>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
