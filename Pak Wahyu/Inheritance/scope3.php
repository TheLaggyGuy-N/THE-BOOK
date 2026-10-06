<?php
class vospid {

    public function jurusan(){
        return "PPLG";
    }
}
class kelaz extends vospid{
public function jurusan(){
    return "RPL";
}

public function lihat_jurusan_vospid(){
    return parent::jurusan();
}
}

$kelas = new kelaz();

echo $kelas->lihat_jurusan_vospid();
echo "<br>";
echo $kelas->jurusan();