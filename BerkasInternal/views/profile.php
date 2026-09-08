<!DOCTYPE html>
<html>
<head>
    <title>Profil Karyawan - e-Ekspedisi</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
    <div class="navbar">
        <a href="index.php?aksi=home">Home</a>
        <a href="index.php?aksi=berkas">Berkas Internal</a>
        <a href="index.php?aksi=penerima">Berkas Untuk Saya</a>
        <span>
            <a href="index.php?aksi=profile">Profil</a> |
            <a href="index.php?aksi=logout">Logout</a>
        </span>
    </div>

    <div class="container">
        <div class="box profile-card">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($data['nama'], 0, 1)); ?>
            </div>
            <div class="profile-intro">
                <h2><?php echo htmlspecialchars($data['nama']); ?></h2>
                <p class="profile-role">
                    <?php echo htmlspecialchars(ucfirst($data['role'])); ?>
                </p>
                <p>Informasi akun dan data kepegawaian Anda.</p>

                <div class="profile-details">
                    <div class="profile-detail">
                        <strong>Username</strong>
                        <span><?php echo htmlspecialchars($data['username']); ?></span>
                    </div>
                    <div class="profile-detail">
                        <strong>Bagian</strong>
                        <span><?php echo htmlspecialchars($data['bagian']); ?></span>
                    </div>
                    <div class="profile-detail">
                        <strong>Email</strong>
                        <span><?php echo htmlspecialchars($data['email']); ?></span>
                    </div>
                    <div class="profile-detail">
                        <strong>No. Telepon</strong>
                        <span><?php echo htmlspecialchars($data['no_tlp']); ?></span>
                    </div>
                    <div class="profile-detail password-detail">
                        <strong>Password</strong>
                        <div class="password-row">
                            <span id="passwordValue" data-password="<?php echo htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8'); ?>">••••••••</span>
                            <button type="button" class="password-toggle" onclick="togglePassword()">Tampilkan</button>
                        </div>
                    </div>
                </div>

                <p>
                    <a class="btn" href="index.php?aksi=gantiPassword">Ganti Password</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordValue = document.getElementById('passwordValue');
            const passwordToggle = document.querySelector('.password-toggle');
            const isHidden = passwordValue.textContent === '••••••••';

            passwordValue.textContent = isHidden
                ? passwordValue.dataset.password
                : '••••••••';
            passwordToggle.textContent = isHidden ? 'Sembunyikan' : 'Tampilkan';
        }
    </script>
</body>
</html>
