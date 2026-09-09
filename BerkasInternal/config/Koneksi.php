<?php
date_default_timezone_set('Asia/Jakarta');

class Koneksi {
    public function getKoneksi() {
        $koneksi = new mysqli("localhost", "root", "", "e-berkas");
        if ($koneksi->connect_error) {
            die("Koneksi gagal: " . $koneksi->connect_error);
        }
        $koneksi->query("SET time_zone = '+07:00'");
        return $koneksi;
    }
}
?>
