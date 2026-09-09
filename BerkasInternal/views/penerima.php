<!DOCTYPE html>
<html>
<head>
    <title>Berkas Untuk Saya</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
    <div class="navbar">
        <a href="index.php?aksi=home">Home</a>
        <a href="index.php?aksi=berkas">List Berkas Internal</a>
        <a class="active" aria-current="page" href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <a href="index.php?aksi=kotakPesan">Kotak Pesan</a>
        <span style="float:right;">
            <a href="index.php?aksi=profile">Profil</a> |
            <a href="index.php?aksi=logout">Logout</a>
        </span>
    </div>
    <div class="container">
        <div class="box">
            <h2>Berkas Untuk Saya</h2>
            <form class="search-form" action="index.php" method="GET">
                <input type="hidden" name="aksi" value="penerima">
                <input type="search" name="q" value="<?php echo htmlspecialchars($pencarian); ?>"
                    placeholder="Cari dokumen, pengirim, tanggal, atau keterangan">
                <button type="submit">Cari</button>
                <?php if ($pencarian !== '') { ?>
                    <a class="btn batal" href="index.php?aksi=penerima">Reset</a>
                <?php } ?>
            </form>
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
                            <?php if ($row['jumlah_ditolak'] == $row['jumlah_file']) { ?>
                                Ditolak
                            <?php } elseif ($row['jumlah_diterima'] < $row['jumlah_file']) { ?>
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
                                    <?php if (empty($row['daftar_file'])) { ?>
                                        <p class="empty">Belum ada file.</p>
                                    <?php } else { ?>
                                        <ul class="file-list">
                                            <?php foreach (preg_split('/\r?\n|\|\|\|/', $row['daftar_file']) as $file) { ?>
                                                <?php if ($file === '') { continue; } ?>
                                                <li>
                                                    <a href="uploads/<?php echo urlencode($file); ?>" target="_blank">
                                                        <?php echo htmlspecialchars($file); ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
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

                                    <?php if ($row['jumlah_ditolak'] == $row['jumlah_file']) { ?>
                                        <span class="accepted-label">Berkas ditolak</span>
                                    <?php } elseif ($row['jumlah_diterima'] < $row['jumlah_file']) { ?>
                                        <form class="not-accepted-form" action="index.php" method="GET">
                                            <input type="hidden" name="aksi" value="terimaKelompok">
                                            <input type="hidden" name="pengirim" value="<?php echo (int) $row['id_pengirim']; ?>">
                                            <input type="hidden" name="tgl" value="<?php echo htmlspecialchars($row['tgl_kirim'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="dokumen" value="<?php echo htmlspecialchars($row['n_dokumen'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars($row['keterangan'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" class="btn">Terima Berkas</button>
                                        </form>
                                    <?php } else { ?>
                                        <span class="accepted-label">Semua berkas sudah diterima</span>
                                    <?php } ?>
                                    <?php if ($row['jumlah_ditolak'] == 0 && $row['jumlah_diterima'] < $row['jumlah_file']) { ?>
                                        <form class="not-accepted-form" action="index.php?aksi=tolakKelompok" method="POST">
                                            <input type="hidden" name="pengirim" value="<?php echo (int) $row['id_pengirim']; ?>">
                                            <input type="hidden" name="tgl" value="<?php echo htmlspecialchars($row['tgl_kirim'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="dokumen" value="<?php echo htmlspecialchars($row['n_dokumen'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars($row['keterangan'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <button type="submit" class="btn">Tolak Berkas</button>
                                        </form>
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