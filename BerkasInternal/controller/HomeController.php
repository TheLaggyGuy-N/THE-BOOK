<?php

class HomeController {

    public function index() {
        session_start();

        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
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