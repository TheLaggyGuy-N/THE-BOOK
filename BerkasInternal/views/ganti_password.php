<!DOCTYPE html>
<html>
<head>
    <title>Ganti Password</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
<div class="box">
    <h2>Ganti Password Sendiri</h2>
    <p>Jawab salah satu data personal Anda untuk memverifikasi perubahan password.</p>
    <form action="index.php?aksi=prosesGantiPassword" method="POST">
        <input type="hidden" name="mode" value="personal">
        <label>Hobi</label>
        <input type="text" name="hobi">
        <label>Makanan Favorit</label>
        <input type="text" name="makanan_favorit">
        <label>Hewan Favorit</label>
        <input type="text" name="hewan_favorit">
        <label>Password Baru</label>
        <input type="password" name="password_baru" minlength="6" required>
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="konfirmasi_password" minlength="6" required>
        <button type="submit">Simpan Password</button>
    </form>
    <br>
    <a href="index.php?aksi=profile">Kembali ke Profil</a>
</div>
</body>
</html>
