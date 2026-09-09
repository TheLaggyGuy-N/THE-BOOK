<?php
require_once "model/User.php";
class RegisterController {
    public function prosesRegister() {
        session_start();
        if (!$this->isAdmin()) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $bagian = $_POST['bagian'];
        $model = new User();
        $hasil = $model->register($nama, $username, $password, $bagian);
        if ($hasil) {
            $_SESSION['alert_admin'] = 'Akun berhasil dibuat.';
        } else {
            $_SESSION['alert_admin'] = 'Akun gagal dibuat. Username mungkin sudah digunakan.';
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
