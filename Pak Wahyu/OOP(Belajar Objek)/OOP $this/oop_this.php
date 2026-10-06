<?php
    // buuat class laptop
    class laptop{

        // buat properti untuk class laptop
        public $pemilik="Andi ";

        // buat method untuk class laptop
        public function hidupkan_laptop(){
            return "Hidupkan laptop ";
        }

        public function Matikan_laptop(){
            return "Matikan laptop ";
        }
    }
        // buat objek dari class laptop (instansiasi)
        $laptop_baru = new laptop();
        $laptop_lama = new laptop();

        echo  $laptop_baru->pemilik;
        echo  $laptop_lama->pemilik;

         echo  $laptop_baru->hidupkan_laptop(); //
         echo  $laptop_lama->hidupkan_laptop();
//?>

    
        