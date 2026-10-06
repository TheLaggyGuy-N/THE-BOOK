<?php
class komputer {

    public function lihat_spec(){
        return "Spec Komputer: Acer, Processor Inter core i7, Ram 4GB";
    }
}
class laptop extends komputer{
public function lihat_spec(){
    return "Spec Laptop: Asus, Processor Intel core i5, Ram 2GB";
}

public function lihat_spec_komputer(){
    return parent::lihat_spec();
}

}

$gadget_baru = new laptop();
echo $gadget_baru->lihat_spec();
echo "<br>";
echo $gadget_baru->lihat_spec_komputer();