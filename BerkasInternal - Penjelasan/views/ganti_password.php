<!DOCTYPE html>
<html>
<head>
    <title>Ganti Password</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; }
        .box { width: 400px; margin: 60px auto; background: white; padding: 25px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 7px 0 15px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #198754; color: white; border: none; }
        a { text-decoration: none; }
    </style>
</head>
<body>
<div class="box">
    <h2><?php echo $mode === 'lupa' ? 'Lupa Password' : 'Ganti Password'; ?></h2>

    <form action="index.php?aksi=prosesGantiPassword" method="POST">
        <input type="hidden" name="mode" value="<?php echo $mode; ?>">

        <?php if ($mode === 'lupa') { ?>
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Email</label>
            <input type="email" name="email" required>
        <?php } else { ?>
            <label>Password Lama</label>
            <input type="password" name="password_lama" required>
        <?php } ?>

        <label>Password Baru</label>
        <input type="password" name="password_baru" minlength="6" required>

        <label>Konfirmasi Password Baru</label>
        <input type="password" name="konfirmasi_password" minlength="6" required>

        <?php if ($verifikasi) { ?>
            <label>Verifikasi: <?php echo $_SESSION['password_angka_1']; ?> + <?php echo $_SESSION['password_angka_2']; ?> = ?</label>
            <input type="number" name="jawaban_verifikasi" required>
        <?php } ?>

        <button type="submit">Simpan Password</button>
    </form>

    <br>
    <a href="index.php?aksi=home">Kembali</a>
</div>
</body>
</html>
