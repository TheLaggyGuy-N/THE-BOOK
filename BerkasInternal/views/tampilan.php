<!DOCTYPE html>
<html>
<head>
    <title>Berkas Internal - e-Ekspedisi</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
    <div class="navbar">
        <a href="index.php?aksi=home">Home</a>
        <a class="active" aria-current="page" href="index.php?aksi=berkas">List Berkas Internal</a>
        <a href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <span style="float:right;">
            <a href="index.php?aksi=profile">Profil</a> |
            <a href="index.php?aksi=logout">Logout</a>
        </span>
    </div>
    <div class="container">
        <div class="box">
            <h2>Daftar Berkas Internal</h2>
            <a class="btn" href="index.php?aksi=tambah">
                + Tambah Berkas
            </a>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Tanggal Kirim</th>
                    <th>Pengirim</th>
                    <th>Tujuan</th>
                    <th>Tanggal Terima</th>
                    <th>Keterangan</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
                <?php $no = 1; ?>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <?php echo $row['n_dokumen']; ?>
                        </td>
                        <td>
                            <?php echo $row['tgl_kirim']; ?>
                        </td>
                        <td>
                            <?php echo $row['nama_pengirim']; ?>
                        </td>
                        <td>
                            <?php
                            if ($row['tujuan_semua'] == 1) {
                                echo "Semua Pengguna";
                            } else {
                                echo $row['nama_penerima'];
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($row['tgl_terima'] == NULL) {
                                echo "Belum diterima";
                            } else {
                                echo $row['tgl_terima'];
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $row['keterangan']; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['file_berkas'])) { ?>
                                <a href="uploads/<?php echo $row['file_berkas']; ?>"
                                    target="_blank">
                                    Lihat Berkas
                                </a>
                            <?php } else { ?>
                                Tidak ada file
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['id_pengirim'] == $_SESSION['id_user']) { ?>
                                <a href="index.php?aksi=edit&id=<?php echo $row['id_berkas']; ?>">
                                    Edit
                                </a>
                                |
                                <a href="index.php?aksi=hapus&id=<?php echo $row['id_berkas']; ?>"
                                    onclick="return confirm('Yakin ingin menghapus berkas ini?')">
                                    Hapus
                                </a>
                            <?php } ?>
                            <?php
                            if (
                                $row['id_pengirim'] != $_SESSION['id_user'] &&
                                $row['tgl_terima'] == NULL
                            ) {
                            ?>
                                <a href="index.php?aksi=terima&id=<?php echo $row['id_berkas']; ?>">
                                    Terima
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
