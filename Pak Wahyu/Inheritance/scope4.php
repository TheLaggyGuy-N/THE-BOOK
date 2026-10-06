<?php
    class komputer{
        public $milik = "Niko";

        public function ganteng() {
            return "Niko ganteng ";
        }
    }
    class laptop extends komputer{
        public $milik = "keren";

        public function ganteng() {
            return "Niko keren ";
        }
         public function lihat_niko_ganteng() {
            return parent::ganteng();
        }
         public function lihat_niko_lucu() {
            return parent::$milik;
        } 
    }
    $gadget_baru = new laptop();
    echo $gadget_baru->ganteng();
    echo "<br>";
    echo $gadget_baru->lihat_niko_ganteng();
    echo $gadget_baru->lihat_niko_lucu();