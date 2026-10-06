<?php
    class kubus {
        public function Luas($r = 8) {
            return $l = 6 * $r ** 2;
        }
        public function Volume($r = 8) {
            return $r ** 3;
        }
    }
    $Kubus = new kubus();
    echo "Luas Kubus:".$Kubus->Luas();
    echo "</br>";
    echo "Luas Volume Kubus:".$Kubus->Volume();
    echo "</br>";
    echo "</br>";

    class tabung {
        public function Luas($t = 16, $phi = 3.14, $r = 10) {
            return 2 * $phi * 2 * $t;
        }
        public function Volume($t = 16, $phi = 3.14, $r = 10) {
            return $phi = 3.14 * $r * $t;
        }
    }
    $tabung = new tabung();
    echo "Luas Tabung:". $tabung->Luas();
    echo "</br>";
    echo "Luas Volume Tabung:". $tabung->Volume();
    echo "</br>";
    echo "</br>";

    class bola {
        public function Luas($phi = 3.14, $r = 14) {
            return 4 * $phi * $r ** 2;
        }
        public function Volume($phi = 3.14, $r = 14) {
            return 4/3 * $phi * $r ** 3;
        }
    }
    $bola = new bola();
    echo "Luas Bola:". $bola->Luas();
    echo "</br>";
    echo "Luas Volume Bola:". $bola->Volume();
    echo "</br>";
    echo "</br>";

