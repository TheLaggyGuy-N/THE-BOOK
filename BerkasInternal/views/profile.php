<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
</head>
<body>
    <h2>Profil User</h2>

    <p>
        <a href="index.php?page=beranda">Beranda</a> |
        <a href="index.php?page=berkasInternal">Berkas Internal</a> |
        <a href="index.php?page=listBerkas">List Berkas</a> |
        <a href="index.php?page=profile">Profil</a> |
        <a href="index.php?page=logout">Logout</a>
    </p>

    <form action="index.php?page=prosesProfile" method="POST">
        <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">

        <p>
            Nama : <br>
            <input type="text" name="nama" value="<?php echo $data['nama']; ?>">
        </p>
        <p>
            Username : <br>
            <input type="text" name="username" value="<?php echo $data['username']; ?>">
        </p>
        <p>
            Password : <br>
            <input type="text" name="password" value="<?php echo $data['password']; ?>">
        </p>
        <p>
            Bagian : <br>
            <input type="text" name="bagian" value="<?php echo $data['bagian']; ?>">
        </p>
        <p>
            No Telepon : <br>
            <input type="text" name="no_tlp" value="<?php echo $data['no_tlp']; ?>">
        </p>
        <p>
            Email : <br>
            <input type="email" name="email" value="<?php echo $data['email']; ?>">
        </p>
        <p>
            Role : <br>
            <select name="role">
                <option value="admin" <?php if ($data['role'] == 'admin') echo 'selected'; ?>>admin</option>
                <option value="pegawai" <?php if ($data['role'] == 'pegawai') echo 'selected'; ?>>pegawai</option>
            </select>
        </p>
        <button type="submit">Update Profil</button>
    </form>
</body>
</html>
