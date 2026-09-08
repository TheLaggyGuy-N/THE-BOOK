<?php
require_once "model/Berkas.php";
class BerkasController {
    public function index() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $model = new Berkas();
        $data = $model->tampilData($_SESSION['id_user']);
        $pesan = $_SESSION['pesan'] ?? '';
        unset($_SESSION['pesan']);
        foreach ($data as &$row) {
            $detail = $model->detailKelompok($row['id_berkas']);
            $row['daftar_file'] = $detail['daftar_file'];
            $row['komentar'] = $detail['komentar'];
            $row['belum_dapat_diterima'] = $model->adaPesanBelumDapatDiterima(
                $row['id_berkas'],
                $_SESSION['id_user']
            );
        }
        unset($row);
        $user = $model->tampilUser();
        require_once "views/list_berkas.php";
    }
    public function penerima() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $model = new Berkas();
        $data = $model->tampilDiterima($_SESSION['id_user']);
        foreach ($data as &$row) {
            $row['komentar'] = $model->komentarUntukBerkas($row['id_berkas']);
        }
        unset($row);
        require_once "views/penerima.php";
    }

    public function prosesKomentar() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }

        $idBerkas = (int) ($_POST['id_berkas'] ?? 0);
        $komentar = trim($_POST['komentar'] ?? '');
        if ($idBerkas > 0 && $komentar !== '') {
            $model = new Berkas();
            $model->tambahKomentar($idBerkas, $_SESSION['id_user'], $komentar);
        }
        $kembali = ($_POST['kembali'] ?? '') === 'berkas'
            ? 'berkas'
            : 'penerima';
        header("Location: index.php?aksi=" . $kembali);
        exit;
    }
    public function tambah() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $model = new Berkas();
        if ($model->adaBerkasMenunggu($_SESSION['id_user'])) {
            $_SESSION['pesan'] = 'Anda belum dapat mengirim berkas baru karena masih ada berkas yang belum diterima.';
            header("Location: index.php?aksi=berkas");
            exit;
        }
        $user = $model->tampilUser();
        $pesan = $_SESSION['pesan'] ?? '';
        unset($_SESSION['pesan']);
        require_once "views/tambah.php";
    }
    public function prosesTambah() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $nama = $_POST['n_dokumen'];
        $tgl = date('Y-m-d H:i:s');
        $pengirim = $_SESSION['id_user'];
        $tujuan = (int) ($_POST['tujuan'] ?? 0);
        $keterangan = $_POST['keterangan'];
        $model = new Berkas();
        if ($tujuan <= 0 || $tujuan == $pengirim) {
            $_SESSION['pesan'] = 'Pilih satu penerima yang valid.';
            header("Location: index.php?aksi=tambah");
            exit;
        }
        if ($model->adaBerkasMenunggu($pengirim)) {
            $_SESSION['pesan'] = 'Anda belum dapat mengirim berkas baru karena masih ada berkas yang belum diterima.';
            header("Location: index.php?aksi=berkas");
            exit;
        }
        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $idBerkas = 0;
        if (isset($_FILES['file_berkas']['name']) &&
            is_array($_FILES['file_berkas']['name'])) {
            foreach ($_FILES['file_berkas']['name'] as $i => $namaFile) {
                if ($_FILES['file_berkas']['error'][$i] != 0) {
                    continue;
                }
                $namaFile = basename($namaFile);
                $file = time() . "_" . bin2hex(random_bytes(4)) . "_" . $namaFile;
                if (!move_uploaded_file(
                    $_FILES['file_berkas']['tmp_name'][$i],
                    $folder . $file
                )) {
                    continue;
                }
                $idBaru = $model->tambahData(
                    $nama,
                    $tgl,
                    $pengirim,
                    $tujuan,
                    $keterangan,
                    $file
                );
                if ($idBerkas === 0) {
                    $idBerkas = $idBaru;
                }
            }
        }
        if ($idBerkas > 0) {
            $model->buatPesanSistem(
                $idBerkas,
                $pengirim,
                $tujuan,
                'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.'
            );
        }
        header("Location: index.php?aksi=berkas");
        exit;
    }
    public function edit() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $id = $_GET['id'];
        $model = new Berkas();
        $data = $model->editData($id);
        $user = $model->tampilUser();
        require_once "views/edit.php";
    }
    public function prosesEdit() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $id = $_POST['id_berkas'];
        $nama = $_POST['n_dokumen'];
        $tgl = $_POST['tgl_kirim'];
        $tujuan = (int) ($_POST['tujuan'] ?? 0);
        $keterangan = $_POST['keterangan'];
        $file = "";
        if (isset($_FILES['file_berkas']) &&
            $_FILES['file_berkas']['error'] == 0) {
            $namaFile = $_FILES['file_berkas']['name'];
            $tmpFile = $_FILES['file_berkas']['tmp_name'];
            $folder = "uploads/";
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
            $file = time() . "_" . $namaFile;
            move_uploaded_file(
                $tmpFile,
                $folder . $file
            );
        }
        $model = new Berkas();
        $model->prosesEdit(
            $id,
            $nama,
            $tgl,
            $tujuan,
            $keterangan,
            $file
        );
        header("Location: index.php?aksi=berkas");
        exit;
    }
    public function hapus() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $id = $_GET['id'];
        $model = new Berkas();
        $model->hapusData($id);
        header("Location: index.php?aksi=berkas");
        exit;
    }
    public function terima() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $id = $_GET['id'];
        $id_user = $_SESSION['id_user'];
        $model = new Berkas();
        if ($model->terimaData($id, $id_user)) {
            $model->tandaiPesanBerkasDibaca($id, $id_user);
        }
        header("Location: index.php?aksi=berkas");
        exit;
    }
    public function terimaKelompok() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $model = new Berkas();
        $berhasil = $model->terimaKelompok(
            $_SESSION['id_user'],
            $_GET['pengirim'],
            $_GET['tgl'],
            $_GET['dokumen'],
            $_GET['keterangan']
        );
        if ($berhasil) {
            $pesanBerkas = $model->tampilDiterima($_SESSION['id_user']);
            foreach ($pesanBerkas as $berkas) {
                if ($berkas['id_pengirim'] == $_GET['pengirim'] &&
                    $berkas['n_dokumen'] == $_GET['dokumen'] &&
                    $berkas['tgl_kirim'] == $_GET['tgl'] &&
                    $berkas['keterangan'] == $_GET['keterangan']) {
                    $model->tandaiPesanBerkasDibaca(
                        $berkas['id_berkas'],
                        $_SESSION['id_user']
                    );
                    break;
                }
            }
        }
        header("Location: index.php?aksi=penerima");
        exit;
    }

    public function kirimPengingat() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $id = (int) ($_POST['id_berkas'] ?? 0);
        $pesan = trim($_POST['pesan'] ?? 'Mohon segera menerima berkas ini.');
        if ($id > 0 && $pesan !== '') {
            $model = new Berkas();
            $model->kirimPengingat($id, $_SESSION['id_user'], $pesan);
        }
        header("Location: index.php?aksi=berkas");
        exit;
    }

    public function belumDapatDiterima() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $id = (int) ($_POST['id_berkas'] ?? 0);
        if ($id > 0) {
            $model = new Berkas();
            $model->beriTahuBelumDapatDiterima($id, $_SESSION['id_user']);
        }
        header("Location: index.php?aksi=penerima");
        exit;
    }

    public function kotakPesan() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $model = new Berkas();
        $pesan = $model->daftarPesan($_SESSION['id_user']);
        require_once "views/pesan.php";
    }

    public function bacaPesan() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model = new Berkas();
            $model->tandaiPesanDibaca($id, $_SESSION['id_user']);
        }
        header("Location: index.php?aksi=kotakPesan");
        exit;
    }
}
?>
