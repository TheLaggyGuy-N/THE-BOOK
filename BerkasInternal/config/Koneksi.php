<?php

class Koneksi {
    public function getKoneksi() {
        $koneksi = new mysqli("localhost", "root", "", "e_berkas");

        if ($koneksi->connect_error) {
            die("Koneksi gagal: " . $koneksi->connect_error);
        }
        return $koneksi;
    }
}
?>