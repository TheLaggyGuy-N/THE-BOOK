<?php
    require_once "config/database.php";

    class Berkas {
        private $db;
        public function __construct(){
            $database = new database();
            $this->db = $database->conn;
        }

        public function tampilUser(){
            return $_SESSION['user'] ?? [];
        }

        public function cekLogin($username, $password){
            if (!$this->db) {
                return false;
            }
            $query = mysqli_query($this->db, "SELECT * FROM user WHERE username='$username' AND password='$password' LIMIT 1");
            if ($query && mysqli_num_rows($query) > 0) {
                return mysqli_fetch_assoc($query);
            }
            return false;
        }

        public function profilData($id){
            if (!$this->db) {
                return [];
            }
            $query = mysqli_query($this->db, "SELECT * FROM user WHERE id_user='$id' LIMIT 1");
            if ($query && mysqli_num_rows($query) > 0) {
                return mysqli_fetch_assoc($query);
            }
            return [];
        }

        public function updateProfile($id, $nama, $username, $password, $bagian, $no_tlp, $email, $role){
            if (!$this->db) {
                return true;
            }
            $query = mysqli_query($this->db, "UPDATE user SET nama='$nama', username='$username', password='$password', bagian='$bagian', no_tlp='$no_tlp', email='$email', role='$role' WHERE id_user='$id'");
            return $query;
        }

        public function tampilData(){
            if (!$this->db) {
                return [];
            }
            $query = mysqli_query($this->db, "SELECT * FROM berkas ORDER BY id_berkas DESC");
            $data = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            return $data;
        }

        public function tambahData($nama, $tanggal, $tujuan, $keterangan){
            if (!$this->db) {
                return true;
            }
            $query = mysqli_query($this->db, "INSERT INTO berkas (n_dokumen, tgl_kirim, tujuan, keterangan, status) VALUES ('$nama', '$tanggal', '$tujuan', '$keterangan', 'Dikirim')");
            return $query;
        }

        public function editData($id){
            if (!$this->db) {
                return [];
            }
            $query = mysqli_query($this->db, "SELECT * FROM berkas WHERE id_berkas='$id' LIMIT 1");
            if ($query && mysqli_num_rows($query) > 0) {
                return mysqli_fetch_assoc($query);
            }
            return [];
        }

        public function prosesEdit($id, $nama, $tanggal, $tujuan, $keterangan){
            if (!$this->db) {
                return true;
            }
            $query = mysqli_query($this->db, "UPDATE berkas SET n_dokumen='$nama', tgl_kirim='$tanggal', tujuan='$tujuan', keterangan='$keterangan' WHERE id_berkas='$id'");
            return $query;
        }
        public function hapusData($id){
            if (!$this->db) {
                return true;
            }
            $query = mysqli_query($this->db, "DELETE FROM berkas WHERE id_berkas='$id'");
            return $query;
        }

        public function terimaData($id){
            if (!$this->db) {
                return true;
            }
            $query = mysqli_query($this->db, "UPDATE berkas SET status='Diterima' WHERE id_berkas='$id'");
            return $query;
        }
    }
?>