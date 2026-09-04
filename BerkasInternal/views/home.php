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

</div>

</body>
</html>