<!DOCTYPE html>
<html>
<head>
    <title>Berkas Untuk Saya</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f5f5f5;
        }
        .navbar {
            background: #198754;
            padding: 15px;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }
        .container {
            padding: 30px;
        }
        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #198754;
            color: white;
        }
        .file-list {
            margin: 0;
            padding-left: 18px;
        }
        .file-list li {
            margin-bottom: 6px;
        }
        .empty {
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php?aksi=home">Home</a>
        <a href="index.php?aksi=berkas">Berkas Internal</a>
        <a href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <span style="float:right;">
            <?php echo $_SESSION['nama']; ?> |
            <a href="index.php?aksi=logout">Logout</a>
        </span>
    </div>
    <div class="container">
        <div class="box">
            <h2>Berkas Untuk Saya</h2>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Tanggal Kirim</th>
                    <th>Pengirim</th>
                    <th>Keterangan</th>
                    <th>Daftar Berkas</th>
                    <th>Status</th>
                </tr>
                <?php $no = 1; ?>
                <?php if (empty($data)) { ?>
                    <tr>
                        <td colspan="7" class="empty">Belum ada berkas untuk Anda.</td>
                    </tr>
                <?php } ?>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['n_dokumen']; ?></td>
                        <td><?php echo $row['tgl_kirim']; ?></td>
                        <td><?php echo $row['nama_pengirim']; ?></td>
                        <td><?php echo $row['keterangan']; ?></td>
                        <td>
                            <ul class="file-list">
                                <?php foreach (explode('|||', $row['daftar_file']) as $file) { ?>
                                    <li>
                                        <a href="uploads/<?php echo $file; ?>" target="_blank">
                                            <?php echo $file; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </td>
                        <td>
                            <?php if ($row['jumlah_diterima'] < $row['jumlah_file']) { ?>
                                <a href="index.php?aksi=terimaKelompok&pengirim=<?php echo $row['id_pengirim']; ?>&tgl=<?php echo urlencode($row['tgl_kirim']); ?>&dokumen=<?php echo urlencode($row['n_dokumen']); ?>&keterangan=<?php echo urlencode($row['keterangan']); ?>">
                                    Terima
                                </a>
                            <?php } else { ?>
                                Semua berkas diterima
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>