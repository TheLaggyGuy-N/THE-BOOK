<?php
require_once "model/User.php";
require_once "model/Berkas.php";
class HomeController {
    public function index() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $alertLogin = $_SESSION['alert_login'] ?? '';
        unset($_SESSION['alert_login']);
        $userModel = new User();
        $dataPersonalLengkap = $userModel->dataPersonalLengkap($_SESSION['id_user']);
        $alertPersonal = !$dataPersonalLengkap
            ? 'Pilih minimal satu data personal di Profil untuk dapat mengirim berkas.'
            : '';
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
        $statistik = [];
        $berkasTerbaru = [];
        $daftarPengguna = [];
        if ($isAdmin) {
            $berkasModel = new Berkas();
            $statistik = $berkasModel->statistikDashboard();
            $statistik['total_pengguna'] = $userModel->jumlahPengguna();
            $daftarPengguna = $userModel->daftarPengguna();
            $berkasTerbaru = $berkasModel->berkasTerbaru();
        }
        $alertAdmin = $_SESSION['alert_admin'] ?? '';
        unset($_SESSION['alert_admin']);
        require_once "views/home.php";
    }
    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?aksi=login");
        exit;
    }

    public function profile() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $model = new User();
        $data = $model->ambilUser($_SESSION['id_user']);
        $pesan = $_SESSION['pesan'] ?? '';
        unset($_SESSION['pesan']);
        require_once "views/profile.php";
    }

    public function prosesDataPersonal() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $hobi = trim($_POST['hobi'] ?? '');
        $makananFavorit = trim($_POST['makanan_favorit'] ?? '');
        $hewanFavorit = trim($_POST['hewan_favorit'] ?? '');
        if ($hobi === '' && $makananFavorit === '' && $hewanFavorit === '') {
            $_SESSION['pesan'] = 'Isi minimal satu data personal.';
        } else {
            $model = new User();
            $_SESSION['pesan'] = $model->ubahDataPersonal(
                $_SESSION['id_user'],
                $hobi,
                $makananFavorit,
                $hewanFavorit
            )
                ? 'Data personal berhasil disimpan.'
                : 'Data personal gagal disimpan.';
        }
        header("Location: index.php?aksi=profile");
        exit;
    }
}
?>
