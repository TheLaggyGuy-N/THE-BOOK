<?php
    class motor {
        private $nama;

        public function jalan($nama){
            echo "$nama Menjalankan Motornya";
            return $this->nama;
        }
    }

    class kendaraan {
        private $nama;

        public function jalan($nama){
            echo "$nama Menjalankan kendaraannya";
            return $this->nama;
        }
    }

    $aksi_motor = new motor();
    $aksi_kendaraan= new kendaraan();

    echo $aksi_motor->jalan("Anto ");
    echo "<br>";
    echo $aksi_kendaraan->jalan("Budi ");

