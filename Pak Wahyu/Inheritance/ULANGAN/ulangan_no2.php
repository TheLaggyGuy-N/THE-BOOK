<?php
    class Kendaraan{
        public $nama;
        public $merk;

        public function jalankanMesin(){
            echo "Mesin $this->nama merk $this->merk telah dinyalakan!<br>";
        }
    }

    class Motor extends Kendaraan{
            public $jenisRantai;

            public function lakukanAtraksi(){
                echo "Motor ini melakukan atraksi wheelie!<br>";
            }
        }

    $motorsaya = new Motor();
    $motorsaya->nama = "SupraX 125cc";
    $motorsaya->merk = "Honda";
    $motorsaya->jalankanMesin();
    $motorsaya->lakukanAtraksi();