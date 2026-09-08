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
        $user = $model->tampilUser();
        require_once "views/tampilan.php";
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
        header("Location: index.php?aksi=penerima");
        exit;
    }
    public function tambah() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?aksi=login");
            exit;
        }
        $model = new Berkas();
        $user = $model->tampilUser();
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
        $tujuan = isset($_POST['tujuan']) && $_POST['tujuan'] != ""
            ? $_POST['tujuan']
            : NULL;
        $semua = isset($_POST['semua']) ? 1 : 0;
        $keterangan = $_POST['keterangan'];
        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $model = new Berkas();
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
                $model->tambahData(
                    $nama,
                    $tgl,
                    $pengirim,
                    $tujuan,
                    $semua,
                    $keterangan,
                    $file
                );
            }
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
        $tujuan = isset($_POST['tujuan']) && $_POST['tujuan'] != ""
            ? $_POST['tujuan']
            : NULL;
        $semua = isset($_POST['semua']) ? 1 : 0;
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
            $semua,
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
        $model->terimaData($id, $id_user);
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
        $model->terimaKelompok(
            $_SESSION['id_user'],
            $_GET['pengirim'],
            $_GET['tgl'],
            $_GET['dokumen'],
            $_GET['keterangan']
        );
        header("Location: index.php?aksi=penerima");
        exit;
    }
}
?>
