<!DOCTYPE html>
<html>
<head>
    <title>Buat Akun - e-Ekspedisi</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
<div class="register">
    <h2>Buat Akun</h2>
    <form action="index.php?aksi=prosesRegister" method="POST">
        <label>Nama</label>
        <input type="text" name="nama" required>
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <label>Bagian</label>
        <input type="text" name="bagian" required>
        <label>No. Telepon</label>
        <input type="text" name="no_tlp" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <button type="submit">Buat Akun</button>
    </form>
    <br>
    <a href="index.php?aksi=login">Kembali ke Login</a>
</div>
</body>
</html>
