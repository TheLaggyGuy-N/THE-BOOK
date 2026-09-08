<!DOCTYPE html>
<html>
<head>
    <title>Berkas Untuk Saya</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
    <div class="navbar">
        <a href="index.php?aksi=home">Home</a>
        <a href="index.php?aksi=berkas">Berkas Internal</a>
        <a href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <span style="float:right;">
            <a href="index.php?aksi=profile">Profil</a> |
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
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
                <?php $no = 1; ?>
                <?php if (empty($data)) { ?>
                    <tr>
                        <td colspan="6" class="empty">Belum ada berkas untuk Anda.</td>
                    </tr>
                <?php } ?>
                <?php foreach ($data as $row) { ?>
                    <tr class="recipient-row" onclick="toggleDetail(<?php echo $row['id_berkas']; ?>, this.querySelector('.detail-toggle'))">
                        <td><?php echo $no++; ?></td>
                        <td>
                            <?php echo htmlspecialchars($row['n_dokumen']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['tgl_kirim']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_pengirim']); ?></td>
                        <td>
                            <?php if ($row['jumlah_diterima'] < $row['jumlah_file']) { ?>
                                Belum diterima
                            <?php } else { ?>
                                Sudah diterima
                            <?php } ?>
                        </td>
                        <td>
                            <button type="button" class="detail-toggle"
                                aria-expanded="false"
                                onclick="event.stopPropagation(); toggleDetail(<?php echo $row['id_berkas']; ?>, this)">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                    <tr id="detail-<?php echo $row['id_berkas']; ?>" class="detail-row">
                        <td colspan="6">
                            <div class="recipient-detail">
                                <div class="detail-section">
                                    <strong>Keterangan Pengirim</strong>
                                    <p><?php echo htmlspecialchars($row['keterangan']); ?></p>
                                </div>
                                <div class="detail-section">
                                    <strong>Daftar Berkas</strong>
                                    <ul class="file-list">
                                        <?php foreach (explode('|||', $row['daftar_file']) as $file) { ?>
                                            <li>
                                                <a href="uploads/<?php echo urlencode($file); ?>" target="_blank">
                                                    <?php echo htmlspecialchars($file); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="detail-section">
                                    <strong>Komentar</strong>
                                    <?php if (empty($row['komentar'])) { ?>
                                        <p class="empty">Belum ada komentar.</p>
                                    <?php } else { ?>
                                        <div class="comment-list">
                                            <?php foreach ($row['komentar'] as $komentar) { ?>
                                                <div class="comment-item">
                                                    <strong><?php echo htmlspecialchars($komentar['nama']); ?></strong>
                                                    <span><?php echo htmlspecialchars($komentar['komentar']); ?></span>
                                                    <small><?php echo htmlspecialchars($komentar['dibuat_pada']); ?></small>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <form class="comment-form" action="index.php?aksi=prosesKomentar" method="POST">
                                        <input type="hidden" name="id_berkas" value="<?php echo $row['id_berkas']; ?>">
                                        <textarea name="komentar" rows="2" placeholder="Tulis komentar..." required></textarea>
                                        <button type="submit">Kirim Komentar</button>
                                    </form>
                                </div>
                                <div class="detail-actions">
                                    <?php if ($row['jumlah_diterima'] < $row['jumlah_file']) { ?>
                                        <a class="btn" href="index.php?aksi=terimaKelompok&pengirim=<?php echo $row['id_pengirim']; ?>&tgl=<?php echo urlencode($row['tgl_kirim']); ?>&dokumen=<?php echo urlencode($row['n_dokumen']); ?>&keterangan=<?php echo urlencode($row['keterangan']); ?>">
                                            Terima Berkas
                                        </a>
                                    <?php } else { ?>
                                        <span class="accepted-label">Semua berkas sudah diterima</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <script>
        function toggleDetail(id, button) {
            const detail = document.getElementById('detail-' + id);
            const isOpen = detail.classList.toggle('is-open');
            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            button.textContent = isOpen ? 'Tutup Detail' : 'Lihat Detail';
        }
    </script>
</body>
</html>