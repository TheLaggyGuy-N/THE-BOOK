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
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
        $statistik = [];
        $berkasTerbaru = [];
        if ($isAdmin) {
            $userModel = new User();
            $berkasModel = new Berkas();
            $statistik = $berkasModel->statistikDashboard();
            $statistik['total_pengguna'] = $userModel->jumlahPengguna();
            $berkasTerbaru = $berkasModel->berkasTerbaru();
        }
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
        require_once "views/profile.php";
    }
}
?>
