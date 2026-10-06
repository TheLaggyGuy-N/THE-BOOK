<?php
    class laptop{
        // buat public property(public sama dengan tidak memakai public)
        public $pemilik;

        // buat public method
        public function hidupkan_laptop(){
            return " Mengidupkan Laptop";
        }
    }
    // membuat objek dari class laptop
    $laptop_anto =  new laptop();

    // set property
    $laptop_anto->pemilik = "Anto";

    // Tampilkan property
    echo $laptop_anto->pemilik;  
    
    // Tampilkan property
    echo $laptop_anto->hidupkan_laptop();  
?>