<?php
    function perkalian($angka1, $angka2) {
        $a = $angka1;
        $b = $angka2;
        $hasil = $a * $b;
        return $hasil;
    }

    $hasil = perkalian (4, 7);
    echo "Hasil perkalian 4 x 7 adalah <b>$hasil</b>";
    echo "<br>";
    echo "<hr>";
    echo "Hasil Perkalian 7 x 7 adalah ". perkalian(7, 7);
?>