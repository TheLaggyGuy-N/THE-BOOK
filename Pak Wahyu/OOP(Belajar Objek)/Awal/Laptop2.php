<?php
// buat class laptop

class laptop{
    // buat property untuk class laptop

    private $pemilik = "Anto";
    private $merk = "Acer";

    // buat method untuk class laptop
 
    public function hidupkan_laptop($pemilik, $merk) {
        return "Hidupkan Laptop $merk punya $pemilik.<br>";
    }  

    public function hidupkan_laptop_anto() {
        return "Hidupkan Laptop $this->merk punya $this->pemilik.";
    }
}
    //buat objek dari clas laptop (instansiasi)
    $laptop_andi = new laptop();

    echo $laptop_andi->hidupkan_laptop("Andi", "Lenovo");
    // hasil: "Hidupkan Laptop Lenovo punya Andi";
    echo $laptop_andi->hidupkan_laptop_anto();