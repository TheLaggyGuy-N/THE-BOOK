<?php
    // buat property untuk class laptop
    class laptop{
    public $pemilik = "Andi";

    // buat method untuk class laptop
    public function hidupkan_laptop(){
        return "Hidupkan Laptop $this->pemilik"."<br>";
    }
}

    //buat objek dari class laptop (instansiasi)
    $laptop_baru = new laptop();
    echo $laptop_baru->hidupkan_laptop();

    //ubah isi property $pemilik pada objek
    $laptop_baru->pemilik="Arie";
    echo $laptop_baru->hidupkan_laptop();

    //buat objek baru dari class laptop dan panggil hidupkan_laptop()
    $laptop_lama = new laptop();
    echo $laptop_lama->hidupkan_laptop();