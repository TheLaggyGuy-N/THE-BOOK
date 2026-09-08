<?php
include "Koneksi.php";

$data = mysqli_query($koneksi,"SELECT * FROM table_karyawan");
foreach($data as $i){
    echo $i['nama_kar'];
    echo $i['tgl_lahir'];
    echo $i['jk'];
    echo $i['alamat'];
    echo $i['tlp'];
    echo $i['email'];
    echo $i['jabatan'];
    echo "<br>";
}
