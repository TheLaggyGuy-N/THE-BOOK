<?php
require_once "model/User.php";
require_once "model/Berkas.php";
class LoginController {
    public function login() {
        require_once "views/login.php";
    }
    public function prosesLogin() {
        session_start();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $model = new User();
        $user = $model->login($username);
        if ($user) {
            if ($password === $user['password']) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                $berkasModel = new Berkas();
                $jumlahBelumDiterima = $berkasModel->jumlahBerkasBelumDiterima(
                    $user['id_user']
                );
                if ($jumlahBelumDiterima > 0) {
                    $_SESSION['alert_login'] = 'Anda memiliki ' .
                        $jumlahBelumDiterima .
                        ' berkas yang belum diterima. Silakan periksa Berkas Untuk Saya.';
                }
                header("Location: index.php?aksi=home");
                exit;
            } else {
                echo "Password salah";
            }
        } else {
            echo "Username tidak ditemukan";
        }
    }
}
?>
