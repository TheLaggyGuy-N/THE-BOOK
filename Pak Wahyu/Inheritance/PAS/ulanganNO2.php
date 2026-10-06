<?php
abstract class MetodePembayaran {
    protected $totalBelanja;

    public function __construct($totalBelanja){
        $this->totalBelanja = $totalBelanja;
    }

    abstract function prosesBayar();
}

class TransferBank extends MetodePembayaran {
    private $biayaAdmin = 2500;

    public function prosesBayar() {
        $totalBayar = $this->totalBelanja + $this->biayaAdmin; 
        return "Berhasil bayar! Nominal bayar setelah biaya admin: Rp " . $totalBayar; 
    }
}

class EWallet extends MetodePembayaran {
    public $diskon = 0.05;

    public function prosesBayar() {
        $totalBayar = $this->totalBelanja - ($this->totalBelanja * $this->diskon);
        return "Total yang harus dibayar pake E-Wallet: Rp " . $totalBayar; 
    }
}

class Transaksi {
    private $produk;
    private $harga;

    public function __construct($produk, $harga){
        $this->produk = $produk;
        $this->harga = $harga;
    }

    public function bayar(MetodePembayaran $metode) {
        echo "Membeli {$this->produk} harga Rp " .$this->harga . "<br>";
        echo $metode->prosesBayar() . "<br><br>";
    }
}

$hargaBuku = 50000;

$transaksi1 = new Transaksi("Buku Masak", $hargaBuku);
$metodeBank = new TransferBank($hargaBuku);
$transaksi1->bayar($metodeBank);

$transaksi2 = new Transaksi("Buku Ngoding", $hargaBuku);
$metodeEWallet = new EWallet($hargaBuku);
$transaksi2->bayar($metodeEWallet);

?>