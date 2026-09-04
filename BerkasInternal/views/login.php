<!DOCTYPE html>
<html>
<head>
    <title>Login e-Ekspedisi</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
        }

        .login {
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #198754;
            color: white;
            border: none;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login">
    <h2>Login e-Ekspedisi</h2>

    <form action="index.php?aksi=prosesLogin" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <br>
    <a href="index.php?aksi=register">Buat Akun</a><br>
    <a href="index.php?aksi=gantiPassword">Lupa Password?</a>
</div>

</body>
</html>