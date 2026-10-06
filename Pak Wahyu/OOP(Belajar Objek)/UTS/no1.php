<?php
    class Motor {
        public $nama;

        public function jalan(){
            return "Menjalankan Motornya";
        }
    }
    $aksimotor = new Motor();
    $aksimotor->nama = "Niko ";

    echo $aksimotor->nama;
    echo $aksimotor->jalan();