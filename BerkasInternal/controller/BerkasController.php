<?php 
    require_once "model/Berkas.php";

    class BerkasController {

    public function index() {
        $model = new Berkas();
        $data = $model->tampilData();

        require_once "views/tampilan.php";
    }

    public function tambah() {
        $model = new Berkas();
        $kategoriPilihan = $model->tampilKategori();

        require_once "views/tambah.php";
    }

    public function prosesTambah() {
        $nama = trim($_POST['nama_brg'] ?? '');
        $idKat = (int) ($_POST['id_kategori'] ?? 0);
        $harga = (float) ($_POST['harga'] ?? 0);
        $stok = (int) ($_POST['stok'] ?? 0);

        $model = new Berkas();
        $model->tambahData($nama, $idKat, $harga, $stok);

        header("Location: index.php");
    }

    public function edit(){
        $id = $_GET['id'];

        $model = new Berkas();
        $data = $model->editData($id);
        $kategoriPilihan = $model->tampilKategori();

        require_once "views/edit.php";
    }

    public function prosesEdit(){
        $id = (int) ($_POST['id_produk'] ?? 0);
        $nama = trim($_POST['nama_brg'] ?? '');
        $idKat = (int) ($_POST['id_kategori'] ?? 0);
        $harga = (float) ($_POST['harga'] ?? 0);
        $stok = (int) ($_POST['stok'] ?? 0);

        $model = new Berkas();
        $model->prosesEdit($id, $nama, $idKat, $harga, $stok);

        header("Location: index.php");
    }

    public function kasir(){
        $model = new Berkas();
        $produk = $model->tampilData();
        require_once "views/kasir.php";
    }

    public function prosesKasir(){
        $items = [];
        foreach (($_POST['jumlah'] ?? []) as $id => $jumlah) {
            $jumlah = (int) $jumlah;
            if ($jumlah > 0) {
                $items[(int) $id] = $jumlah;
            }
        }
        if (!$items) {
            header("Location: index.php?action=kasir&status=gagal");
            exit;
        }
        $model = new Berkas();
        $idTransaksi = $model->buatTransaksi($items);
        header("Location: index.php?action=kasir&status=" . ($idTransaksi ? 'sukses' : 'gagal'));
    }

    public function riwayat(){
        $model = new Berkas();
        $data = $model->riwayatTransaksi();
        require_once "views/riwayat.php";
    }

        public function hapus() {
        $id = $_GET['id'];

        $model = new Berkas();
        $model->hapusData($id);

        header("Location: index.php");
    }
    }
?>