<?php
    class persegi_panjang {
        public function Luas($p, $l, $t = 12) {
            return $p * $l * $t;
        }
    }
    $persegi = new persegi_panjang();
    echo $persegi->Luas(6,8);