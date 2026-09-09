<!DOCTYPE html>
<html>

<head>
    <title>Daftar Berkas Internal</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>

<body>
    <div class="navbar">
        <a href="index.php?aksi=home">Home</a>
        <a class="active" aria-current="page" href="index.php?aksi=berkas">List Berkas Internal</a>
        <a href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <a href="index.php?aksi=kotakPesan">Kotak Pesan</a>
        <span>
            <a href="index.php?aksi=profile">Profil</a>
            <a href="index.php?aksi=logout">Logout</a>
        </span>
    </div>
    <div class="container">
        <div class="box">
            <h2>Daftar Berkas Internal</h2>
            <form class="search-form" action="index.php" method="GET">
                <input type="hidden" name="aksi" value="berkas">
                <input type="search" name="q" value="<?php echo htmlspecialchars($pencarian); ?>"
                    placeholder="Cari dokumen, pengguna, tanggal, atau status">
                <button type="submit">Cari</button>
                <?php if ($pencarian !== '') { ?>
                    <a class="btn batal" href="index.php?aksi=berkas">Reset</a>
                <?php } ?>
            </form>
            <a class="btn" href="index.php?aksi=tambah">+ Tambah Berkas</a>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Tanggal Kirim</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php $no = 1; ?>
                <?php if (empty($data)) { ?>
                    <tr>
                        <td colspan="6" class="empty">Belum ada berkas.</td>
                    </tr>
                <?php } ?>
                <?php foreach ($data as $row) { ?>
                    <tr class="recipient-row">
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['n_dokumen']); ?></td>
                        <td><?php echo htmlspecialchars($row['tgl_kirim']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($row['nama_penerima'] ?? '-'); ?>
                        </td>
                        <td>
                            <?php if ($row['status'] === 'Ditolak') { ?>
                                Ditolak
                            <?php } elseif ($row['belum_dapat_diterima']) { ?>
                                Belum dapat diterima
                            <?php } elseif ($row['tgl_terima'] === null) { ?>
                                Belum diterima
                            <?php } else { ?>
                                Diterima
                            <?php } ?>
                        </td>
                        <td>
                            <button type="button" class="detail-toggle"
                                aria-expanded="false"
                                onclick="toggleDetail(<?php echo $row['id_berkas']; ?>, this)">
                                Lihat Detail
                            </button>
                            <?php if ($row['id_pengirim'] == $_SESSION['id_user']) { ?>
                                <button type="button" class="detail-toggle"
                                    onclick="location.href='index.php?aksi=edit&id=<?= $row['id_berkas']; ?>'">
                                    Edit
                                </button>
                                <button type="button" class="detail-toggle"
                                    onclick="if(confirm('Yakin ingin menghapus berkas ini?')) location.href='index.php?aksi=hapus&id=<?= $row['id_berkas']; ?>'">
                                    Hapus
                                </button>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr id="detail-<?php echo $row['id_berkas']; ?>" class="detail-row">
                        <td colspan="6">
                            <div class="recipient-detail">
                                <div class="detail-section">
                                    <strong>Keterangan Pengirim</strong>
                                    <p><?php echo nl2br(htmlspecialchars($row['keterangan'])); ?></p>
                                </div>
                                <div class="detail-section">
                                    <strong>Daftar Berkas</strong>
                                    <?php if (empty($row['daftar_file'])) { ?>
                                        <p class="empty">Tidak ada file.</p>
                                    <?php } else { ?>
                                        <ul class="file-list">
                                            <?php foreach ($row['daftar_file'] as $file) { ?>
                                                <li>
                                                    <a href="uploads/<?php echo rawurlencode($file); ?>" target="_blank">
                                                        <?php echo htmlspecialchars($file); ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                                <div class="detail-section">
                                    <strong>Komentar Penerima</strong>
                                    <?php if (empty($row['komentar'])) { ?>
                                        <p class="empty">Belum ada komentar.</p>
                                    <?php } else { ?>
                                        <div class="comment-list">
                                            <?php foreach ($row['komentar'] as $komentar) { ?>
                                                <div class="comment-item">
                                                    <strong><?php echo htmlspecialchars($komentar['nama']); ?></strong>
                                                    <span><?php echo nl2br(htmlspecialchars($komentar['komentar'])); ?></span>
                                                    <small><?php echo htmlspecialchars($komentar['dibuat_pada']); ?></small>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <form class="comment-form" action="index.php?aksi=prosesKomentar" method="POST">
                                        <input type="hidden" name="id_berkas" value="<?php echo $row['id_berkas']; ?>">
                                        <input type="hidden" name="kembali" value="berkas">
                                        <textarea name="komentar" rows="2" placeholder="Tulis balasan komentar..." required></textarea>
                                        <button type="submit">Kirim Komentar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if (!empty($pesan)) { ?>
        <script>
            alert(<?php echo json_encode($pesan); ?>);
        </script>
    <?php } ?>
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