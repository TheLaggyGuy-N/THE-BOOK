<?php
    class DatabaseConnection {
        private $connectionName;
        private $status;

        public function __construct($dbname){
            $this->connectionName = $dbname;
            $this->status = "Aktif";
            echo "Membangun koneksi ke database $this->connectionName & Status = $this->status<br>";
        }

        public function query($sql){
            echo "Menjalankan query: $sql pada database $this->connectionName<br>";
        }

        public function __destruct(){
            $this->status = "Disconected";
            echo "Memutuskan koneksi ke database $this->connectionName & Status = $this->status<br>";
        }
    }

    $dbbaru = new DatabaseConnection("Sekolah");
    $dbbaru->query("SELECT * FROM siswa");