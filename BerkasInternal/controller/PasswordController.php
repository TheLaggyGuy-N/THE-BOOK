<?php
require_once "model/User.php";
class PasswordController {
    public function ganti() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        require_once "views/ganti_password.php";
    }

    public function prosesGanti() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $mode = $_POST['mode'] ?? 'personal';
        $idUser = (int) ($_POST['id_user'] ?? 0);
        $passwordBaru = $_POST['password_baru'] ?? '';
        $konfirmasi = $_POST['konfirmasi_password'] ?? '';
        if ($passwordBaru !== $konfirmasi) {
            echo "Konfirmasi password baru tidak sama";
            exit;
        }
        if (strlen($passwordBaru) < 6) {
            echo "Password baru minimal 6 karakter";
            exit;
        }
        $model = new User();
        if ($mode === 'personal') {
            if (!$model->verifikasiDataPersonal(
                $_SESSION['id_user'],
                $_POST['hobi'] ?? '',
                $_POST['makanan_favorit'] ?? '',
                $_POST['hewan_favorit'] ?? ''
            )) {
                echo "Data personal tidak cocok. <a href='index.php?aksi=gantiPassword'>Kembali</a>";
                exit;
            }
            if ($model->ubahPassword($_SESSION['id_user'], $passwordBaru)) {
                $_SESSION['pesan'] = 'Password berhasil diubah.';
            } else {
                $_SESSION['pesan'] = 'Password gagal diubah.';
            }
            header("Location: index.php?aksi=profile");
            exit;
        }
        if (!$this->isAdmin()) {
            header("Location: index.php?aksi=login");
            exit;
        }
        if (!$model->ambilUser($idUser)) {
            echo "Pengguna tidak ditemukan. <a href='index.php?aksi=home'>Kembali</a>";
            exit;
        }
        if ($model->ubahPassword($idUser, $passwordBaru)) {
            $_SESSION['alert_admin'] = 'Password berhasil diubah.';
        } else {
            $_SESSION['alert_admin'] = 'Password gagal diubah.';
        }
        header("Location: index.php?aksi=home");
        exit;
    }
    private function isAdmin() {
        return isset($_SESSION['id_user'], $_SESSION['role'])
            && $_SESSION['role'] === 'admin';
    }
}
?>
