<!DOCTYPE html>
<html>
<head>
    <title>Login e-Ekspedisi</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
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
    <a href="index.php?aksi=gantiPassword">Lupa Password?</a>
</div>
</body>
</html>
