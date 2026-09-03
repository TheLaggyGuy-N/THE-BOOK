<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login Berkas Internal</h2>
    <?php if (isset($_SESSION['success'])) { ?>
        <p style="color: green"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php } ?>
    <?php if (isset($error) && $error != "") { ?>
        <p style="color: red"><?php echo $error; ?></p>
    <?php } ?>

    <form action="index.php?page=prosesLogin" method="POST">
        <p>
            Username : <br>
            <input type="text" name="username">
        </p>

        <p>
            Password : <br>
            <input type="password" name="password">
        </p>

        <button type="submit">Login</button>
    </form>
        <p><a href="index.php?page=signIn">Sign In</a></p>

    <p>Demo login: username = admin, password = 123</p>
</body>
</html>
