<?php
    $nama=$_POST['nama'];
    $tugas=$_POST['tugas'];
    $UAS=$_POST['UAS'];
    $UTS=$_POST['UTS'];  

    $NA = ($tugas + $UAS + $UTS) / 3;

    if($NA >= 80){
        $indek = "A";
    } elseif($NA >= 70){
        $indek = "B";
    } elseif($NA >= 60){
        $indek = "C";
    } elseif($NA >= 50){
        $indek = "D";
    } elseif($NA < 50){
        $indek = "E";
    }

    echo "<h1>Menampilkan Indek Nilai</h1><br/>";
    echo "Nama Siswa: $nama <br/>";
    echo "Tugas: $tugas <br/>";
    echo "UAS: $UAS <br/>";
    echo "UTS: $UTS <br/><hr>";
    echo "NA: $NA <br/>";
    echo "Indeks Nilai: $indek <br/><hr/>";
   
?>