<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
</head>
<body>
    <h2>Sign In</h2>

    <?php if (isset($error) && $error != "") { ?>
        <p style="color: red"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form action="index.php?page=prosesSignIn" method="POST">
        <p>
            Nama : <br>
            <input type="text" name="nama" required>
        </p>

        <p>
            Username : <br>
            <input type="text" name="username" required>
        </p>

        <p>
            Password : <br>
            <input type="password" name="password" required>
        </p>

        <p>
            No. Telepon : <br>
            <input type="text" name="no_tlp" required>
        </p>

        <p>
            Email (opsional) : <br>
            <input type="email" name="email">
        </p>

        <p>
            Bagian di Kantor : <br>
            <input type="text" name="bagian" required>
        </p>

        <button type="submit">Daftar</button>
    </form>

    <p><a href="index.php?page=login">Kembali ke Login</a></p>
</body>
</html>
