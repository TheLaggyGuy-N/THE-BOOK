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
}

?>