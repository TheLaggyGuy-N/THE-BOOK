<!DOCTYPE html>
<html>
<head>
    <title>Beranda</title>
</head>
<body>
    <h2>Beranda</h2>

    <p>
        <a href="index.php?page=beranda">Beranda</a> |
        <a href="index.php?page=berkasInternal">Berkas Internal</a> |
        <a href="index.php?page=listBerkas">List Berkas</a> |
        <a href="index.php?page=profile">Profil</a> |
        <a href="index.php?page=logout">Logout</a>
    </p>

    <h3>Profil Akun</h3>
    <p>Nama : <?php echo $user['nama']; ?></p>
    <p>Username : <?php echo $user['username']; ?></p>
    <p>Email : <?php echo $user['email']; ?></p>
    <p>Bagian : <?php echo $user['bagian']; ?></p>
    <p>No Telepon : <?php echo $user['no_tlp']; ?></p>
    <p>Role : <?php echo $user['role']; ?></p>

    <h3>Ringkasan</h3>
    <p>Total berkas : <?php echo $total; ?></p>
    <p>Diterima : <?php echo $diterima; ?></p>
    <p>Menunggu : <?php echo $menunggu; ?></p>
</body>
</html>
