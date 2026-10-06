<?php

    class penduduk {
        public $nama;
        public $nik;
        public $umur;
        public $alamat;
        public $jk;

        public function __construct($nama,$nik,$umur,$alamat,$jk){
            $this->nama = $nama;
            $this->nik = $nik;
            $this->umur = $umur;
            $this->alamat = $alamat;
            $this->jk = $jk;
        }

        public function cekUmur(){
            if($this->umur < 18){
                return "Anak-anak";
            } elseif($this->umur > 18 && $this->umur <= 60){
                return "Dewasa";
            } else {
                return "Lansia";
            }
        }

        public function tampil(){
            echo "Nama :" . $this->nama . "<br>";
            echo "Nik :" . $this->nik . "<br>";
            echo "Umur :" . $this->umur . "<br>";
            echo "Alamat :" . $this->alamat . "<br>";
            echo "Jenis Kelamin :" . $this->jk . "<br>";
            echo "Klasifikasi :" . $this->cekUmur() . "<br><br>";
        }
    }

    $pendudukBaru = new penduduk("Khansa Ifra Mikayla", "3214567890123456", "6", "Jalan Anggrek 12", "Perempuan");
    echo $pendudukBaru->tampil();
    $pendudukBaru = new penduduk("Nurul Amelia", "3276543210987654", "31", "Jalan Melati 5", "Perempuan");
    echo $pendudukBaru->tampil();
?>