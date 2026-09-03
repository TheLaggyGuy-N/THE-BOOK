<?php

require_once "model/User.php";

class RegisterController {

    public function register() {
        require_once "views/register.php";
    }

    public function prosesRegister() {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $bagian = $_POST['bagian'];
        $no_tlp = $_POST['no_tlp'];
        $email = $_POST['email'];

        $model = new User();
        $hasil = $model->register($nama, $username, $password, $bagian, $no_tlp, $email);

        if ($hasil) {
            header("Location: index.php?aksi=login");
            exit;
        } else {
            echo "Username atau email sudah digunakan";
        }
    }
}

?>