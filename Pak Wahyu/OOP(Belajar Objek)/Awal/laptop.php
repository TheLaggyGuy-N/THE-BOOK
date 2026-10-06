<?php
    //  buat class laptop
    class laptop {
        // buat method untuk class laptop 

        public function hidupkan_laptop($pemilik, $merk) {
        return "Hidupkan Laptop $merk punya $pemilik";
        }
    }
    // buat objek dari clas laptop(instansiasi)
    $laptop_andi = new laptop();

    echo $laptop_andi->hidupkan_laptop("Andi", "Lenovo");
    // hasil: "Hidupkan Laptop Lenovo Punya Andi"