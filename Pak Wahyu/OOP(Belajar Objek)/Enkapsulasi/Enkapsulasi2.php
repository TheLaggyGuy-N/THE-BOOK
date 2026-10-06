<?php
    class laptop{
        // buat protected property
        protected $pemilik = "Anto";

        public function beri_akses(){
            return $this->pemilik;
        }

        // buat protected method
        protected function hidupkan_laptop(){
            return " Mengidupkan Laptop";
        }
        
        public function paksa_hidup(){
            return $this->hidupkan_laptop();
        }
    }
    // membuat objek dari class laptop
    $laptop_anto =  new laptop();

    // Jalankan objek dari class laptop
    echo $laptop_anto->beri_akses();  
    
    // jalankan method paksa hidup
    echo $laptop_anto->paksa_hidup();  
?>