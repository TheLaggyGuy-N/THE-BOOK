<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login</title>
</head>
<body>
    <form action="form.php" method="POST" >
        <h1>Form Login</h1>
        <label for="nama">Masukkan Nama :</label>
        <input type="text"  name="nama" placeholder="Masukkan Nama"><br/>
        <label for="Tlp">Masukkan Tlp :</label>
        <input type="number" name="tlp" placeholder="Masukkan Tlp"><br/>
        <label for="Tgl">Masukkan Tgl Lahir :</label>
        <input type="date" name="tgl" placeholder="Masukkan Tgl"><br/>
        <label for="pw">Masukkan password :</label>
        <input type="text" name="pw" placeholder="Masukkan password"><br/>
        <label for="nama">Masukkan Email :</label>
        <input type="email" name="email" placeholder="Masukkan email"><br/>
        <input type="submit">
    </form>
</body>
</html>

<?php
    $nama = $_POST['nama'];
    $password = $_POST['pw'];
    $telepon = $_POST['tlp'];
    $tanggal = $_POST['tgl'];
    $email = $_POST['email'];
    

    echo $nama;
    echo "<br/>";
    echo $password;
    echo "<br/>";
    echo $telepon;
    echo "<br/>";
    echo $tanggal;
    echo "<br/>";
    echo $email;
    
   
?>