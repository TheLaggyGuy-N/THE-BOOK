<?php

require_once "config/Koneksi.php";

class User {
    private $conn;

    public function __construct() {
        $db = new Koneksi();
        $this->conn = $db->getKoneksi();
    }

    public function login($username) {
        $sql = "SELECT * FROM `user` WHERE username = '$username'";
        $hasil = $this->conn->query($sql);

        return $hasil->fetch_assoc();
    }

    public function register($nama, $username, $password, $bagian, $no_tlp, $email) {
        $sql = "INSERT INTO `user`
        (nama, username, password, bagian, no_tlp, email, role)
        VALUES
        ('$nama', '$username', '$password', '$bagian', '$no_tlp', '$email', 'pegawai')";

        return $this->conn->query($sql);
    }
}

?>