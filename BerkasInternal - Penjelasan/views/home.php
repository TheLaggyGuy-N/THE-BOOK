<!DOCTYPE html>
<html>
<head>
    <title>Home - e-Ekspedisi</title>

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
            padding: 25px;
            border-radius: 10px;
        }

        .statistik {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .statistik .box {
            padding: 20px;
        }

        .statistik h3 {
            margin: 0 0 10px;
            font-size: 16px;
        }

        .angka {
            margin: 0;
            font-size: 30px;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
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

        @media (max-width: 800px) {
            .statistik {
                grid-template-columns: repeat(2, 1fr);
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>

<div class="navbar">
    <a href="index.php?aksi=home">Home</a>
    <a href="index.php?aksi=berkas">Berkas Internal</a>
    <a href="#">Berkas Klaim</a>
    <a href="#">Usul SK</a>
    <a href="#">Jadwal Kegiatan</a>

    <span style="float:right;">
        <?php echo $_SESSION['nama']; ?> |
        <a href="index.php?aksi=gantiPassword">Ganti Password</a> |
        <a href="index.php?aksi=logout">Logout</a>
    </span>
</div>

<div class="container">

    <div class="box">
        <h2>Selamat Datang di e-Ekspedisi</h2>

        <p>
            Halo, <b><?php echo $_SESSION['nama']; ?></b>
        </p>

        <p>
            Bagian sistem yang sedang kita buat adalah
            <b>Berkas Internal</b>.
        </p>
    </div>

    <?php if ($isAdmin) { ?>

        <div class="statistik">
            <div class="box">
                <h3>Total Pengguna 👤</h3>
                <p class="angka"><?php echo $statistik['total_pengguna']; ?></p>
                <p>Jumlah akun yang terdaftar.</p>
            </div>

            <div class="box">
                <h3>Total Berkas 📄</h3>
                <p class="angka"><?php echo $statistik['total_berkas']; ?></p>
                <p>Semua berkas yang ada di sistem.</p>
            </div>

            <div class="box">
                <h3>Berkas Masuk 📥</h3>
                <p class="angka"><?php echo $statistik['berkas_masuk']; ?></p>
                <p>Jumlah berkas yang diterima.</p>
            </div>

            <div class="box">
                <h3>Berkas Keluar 📤</h3>
                <p class="angka"><?php echo $statistik['berkas_keluar']; ?></p>
                <p>Jumlah berkas yang dikirim.</p>
            </div>
        </div>

        <div class="box" style="margin-top: 20px;">
            <h2>Berkas Terbaru 📋</h2>

            <table>
                <tr>
                    <th>Nama Dokumen</th>
                    <th>Pengirim</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>

                <?php if (empty($berkasTerbaru)) { ?>
                    <tr>
                        <td colspan="5">Belum ada berkas.</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($berkasTerbaru as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['n_dokumen']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pengirim']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_tujuan']); ?></td>
                            <td><?php echo htmlspecialchars($row['tgl_kirim']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </div>

    <?php } ?>

</div>

</body>
</html>