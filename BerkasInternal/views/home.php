<!DOCTYPE html>
<html>

<head>
    <title>Home - e-Ekspedisi</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>

<body>
    <?php if (!empty($alertLogin)) { ?>
        <script>
            alert(<?php echo json_encode($alertLogin); ?>);
        </script>
    <?php } ?>
    <?php if (!empty($alertPersonal)) { ?>
        <script>
            alert(<?php echo json_encode($alertPersonal); ?>);
        </script>
    <?php } ?>
    <div class="navbar">
        <a class="active" aria-current="page" href="index.php?aksi=home">Home</a>
        <a href="index.php?aksi=berkas">List Berkas Internal</a>
        <a href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <a href="index.php?aksi=kotakPesan">Kotak Pesan</a>
        <span style="float:right;">
            <a href="index.php?aksi=profile">Profil</a> |
            <a href="index.php?aksi=logout">Logout</a>
        </span>
    </div>
    <div class="container">
        <?php if (!empty($alertAdmin)) { ?>
            <div class="admin-alert"><?php echo htmlspecialchars($alertAdmin); ?></div>
        <?php } ?>
        <div class="box">
            <h2>Selamat Datang di e-Ekspedisi</h2>
            <p>
                Halo, <b><?php echo $_SESSION['nama']; ?></b>
            </p>
            <p>
                Selamat Datang di
                <b>Berkas Internal</b>.
            </p>
        </div>
        <?php if ($isAdmin) { ?>

            <div class="statistik">
                <div class="box">
                    <h3>Total Pengguna</h3>
                    <p class="angka"><?php echo $statistik['total_pengguna']; ?></p>
                    <p>Jumlah akun yang terdaftar.</p>
                </div>
                <div class="box">
                    <h3>Total Berkas</h3>
                    <p class="angka"><?php echo $statistik['total_berkas']; ?></p>
                    <p>Semua berkas yang ada di sistem.</p>
                </div>
                <div class="box">
                    <h3>Berkas Masuk</h3>
                    <p class="angka"><?php echo $statistik['berkas_masuk']; ?></p>
                    <p>Jumlah berkas yang diterima.</p>
                </div>
                <div class="box">
                    <h3>Berkas Keluar</h3>
                    <p class="angka"><?php echo $statistik['berkas_keluar']; ?></p>
                    <p>Jumlah berkas yang dikirim.</p>
                </div>
            </div>
            <div class="box" style="margin-top: 20px;">
                <h2>Berkas Terbaru</h2>
                <table>
                    <tr>
                        <th>Nama Dokumen</th>
                        <th>Pengirim</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <?php if (empty($berkasTerbaru)) { ?>
                        <tr>
                            <td colspan="6">Belum ada berkas.</td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($berkasTerbaru as $row) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['n_dokumen']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_pengirim']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_tujuan']); ?></td>
                                <td><?php echo htmlspecialchars($row['tgl_kirim']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <a href="index.php?aksi=edit&id=<?php echo (int) $row['id_berkas']; ?>">Edit</a>
                                    <a href="index.php?aksi=hapus&id=<?php echo (int) $row['id_berkas']; ?>"
                                        onclick="return confirm('Yakin ingin menghapus berkas ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
            <div class="admin-tools">
                <div class="box">
                    <h2>Buat Akun</h2>
                    <form action="index.php?aksi=prosesRegister" method="POST">
                        <label>Nama</label>
                        <input type="text" name="nama" required>
                        <label>Username</label>
                        <input type="text" name="username" required>
                        <label>Password</label>
                        <input type="password" name="password" minlength="6" required>
                        <label>Bagian</label>
                        <input type="text" name="bagian" required>
                        <button type="submit">Buat Akun</button>
                    </form>
                </div>
                <div class="box">
                    <h2>Ubah Password</h2>
                    <p>Admin dapat mengubah password akun tanpa mengubah data lainnya.</p>
                    <form action="index.php?aksi=prosesGantiPassword" method="POST">
                        <input type="hidden" name="mode" value="admin">
                        <label>Pengguna</label>
                        <select name="id_user" id="id_user" class="select-center">
                            <option value="" class="text-center">--- Pilih Pengguna ---</option>
                            <?php foreach ($daftarPengguna as $pengguna) { ?>
                                <option value="<?php echo (int) $pengguna['id_user']; ?>">
                                    <?php echo htmlspecialchars($pengguna['nama'] . ' (' . $pengguna['bagian'] . ')'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label>Password Baru</label>
                        <input type="password" name="password_baru" minlength="6" required>
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password" minlength="6" required>
                        <button type="submit">Simpan Password</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>