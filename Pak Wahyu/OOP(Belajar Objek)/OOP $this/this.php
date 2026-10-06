<?php
    // buuat class laptop
    class laptop{

        // buat properti untuk class laptop
        public $pemilik="Andi ";
        public $merk;

        // buat method untuk class laptop
        public function hidupkan_laptop(){
            return "Hidupkan laptop $pemilik";
        }

    }
        // buat objek dari class laptop (instansiasi)
        $laptop_baru = new laptop();

        echo $laptop_baru->hidupkan_laptop(); //
        "Hidupkan laptop"
//?>
