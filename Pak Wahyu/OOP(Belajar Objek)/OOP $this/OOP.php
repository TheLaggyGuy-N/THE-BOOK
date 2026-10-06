<?php
    // buuat class laptop
    class laptop{

        // buat properti untuk class laptop
        public $pemilik;
        public $merk;
        public $ukuran_layar;

        // buat method untuk class laptop
        public function hidupkan_laptop(){
            return "Hidupkan laptop";
        }

        public function Matikan_laptop(){
            return "Matikan laptop";
        }
    }

        // buat objek dari class laptop (instansiasi)
        $laptop_anto = new laptop();
        $laptop_andi = new laptop();

        $laptop_anto->pemilik="anto";
        $laptop_andi->pemilik="andi";



