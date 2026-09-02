<!DOCTYPE html>
<html>
<head>
    <title>List Berkas</title>
</head>
<body>
    <h2>List Berkas</h2>

    <p>
        <a href="index.php?page=beranda">Beranda</a> |
        <a href="index.php?page=berkasInternal">Berkas Internal</a> |
        <a href="index.php?page=listBerkas">List Berkas</a> |
        <a href="index.php?page=profile">Profil</a> |
        <a href="index.php?page=logout">Logout</a>
    </p>

    <p><a href="index.php?page=tambah">Tambah Berkas</a></p>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Dokumen</th>
            <th>Tanggal</th>
            <th>Tujuan</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $row['n_dokumen']; ?></td>
                <td><?php echo $row['tgl_kirim']; ?></td>
                <td><?php echo $row['tujuan']; ?></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] != 'Diterima') { ?>
                        <a href="index.php?page=terima&id=<?php echo $row['id_berkas']; ?>">Terima</a> |
                    <?php } else { ?>
                        Diterima |
                    <?php } ?>

                    <a href="index.php?page=edit&id=<?php echo $row['id_berkas']; ?>">Edit</a> |
                    <a href="index.php?page=hapus&id=<?php echo $row['id_berkas']; ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php $no++; ?>
        <?php } ?>
    </table>
</body>
</html>
