<?php
    function tambah($a, $b= 2) {
        return $a + $b;
    }

    echo tambah(4,4); // hasilnya 8 karena nilai default parameter $b tidak statis(tetap)