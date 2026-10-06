<?php
    $a = 8;
    $b = 10;

    function hitung(){
        global $a;
        global $b;
        global $d;

        $c = 8;
        $d = $a * $b - $c;
    }  

    hitung();
    echo $d;
?>
