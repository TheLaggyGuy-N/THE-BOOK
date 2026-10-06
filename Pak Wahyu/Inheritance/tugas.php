<?php 
class Pembayaran {
    protected $jumlah;

    function __construct($jumlah) {
        $this->jumlah = $jumlah;
    }

    function konfirmasi(){
        return "Pesanan diterima sebesar Rp " . number_format($this->jumlah);
    }
}

class TransferBank extends Pembayaran {
    public $kodeunik = rand(100, 999);

    function __construct($jumlah, $kodeunik) {
        parent:: __construct($jumlah, $kodeunik);
    }

    function konfirmasi() {
        $total = $jumlah + $kodeunik;
        return "Total yang harus di bayar adalah: $this->jumlah"; 
        }
}

class KartuKredit extends Pembayaran {
    public $biayaadmin = 0.025;

    function __construct($jumlah, $kodeunik) {
        parent:: __construct($jumlah, $kodeunik);
    }

    function konfirmasi() {
        $total = $jumlah + $kodeunik;
        return "Total yang harus di bayar adalah: $this->jumlah"; 
        }
}

