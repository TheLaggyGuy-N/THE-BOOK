<?php
    class motor {
        protected $nama;

        private function jalan(){
            return "Brian Abraham jalan";
        }

        public function cetakjalan(){
            return $this->jalan();
        }
    }
$aksi_motor = new motor;
echo $aksi_motor->cetakjalan();
