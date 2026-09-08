<!DOCTYPE html>
<html>
<head>
    <title>Kotak Pesan</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
    <div class="navbar">
        <a href="index.php?aksi=home">Home</a>
        <a href="index.php?aksi=berkas">Berkas Internal</a>
        <a href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <a href="index.php?aksi=kotakPesan">Kotak Pesan</a>
        <span>
            <a href="index.php?aksi=profile">Profil</a>
            <a href="index.php?aksi=logout">Logout</a>
        </span>
    </div>
    <div class="container">
        <div class="box">
            <h2>Kotak Pesan</h2>
            <table>
                <tr>
                    <th>Status</th>
                    <th>Berkas</th>
                    <th>Dari</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
                <?php if (empty($pesan)) { ?>
                    <tr>
                        <td colspan="6" class="empty">Belum ada pesan.</td>
                    </tr>
                <?php } ?>
                <?php foreach ($pesan as $row) { ?>
                    <tr>
                        <td><?php echo $row['sudah_dibaca'] ? 'Sudah dibaca' : 'Belum dibaca'; ?></td>
                        <td><?php echo htmlspecialchars($row['n_dokumen']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_pengirim']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['pesan'])); ?></td>
                        <td><?php echo htmlspecialchars($row['dibuat_pada']); ?></td>
                        <td>
                            <?php if (!$row['sudah_dibaca']) { ?>
                                <a href="index.php?aksi=bacaPesan&id=<?php echo $row['id_pesan']; ?>">Tandai dibaca</a>
                            <?php } else { ?>
                                Sudah dibaca
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
