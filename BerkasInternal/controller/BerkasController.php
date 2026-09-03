<?php

require_once "model/Berkas.php";

class BerkasController {

    public function index() {
        $model = new Berkas();
        $data = $model->tampilData();
        $user = $model->tampilUser();

        require_once "views/tampilan.php";
    }

    public function login() {
        $error = "";

        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        require_once "views/login.php";
    }

    public function prosesLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $model = new Berkas();
        $user = $model->cekLogin($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: index.php?page=beranda");
        } else {
            $_SESSION['error'] = "Username atau password salah";
            header("Location: index.php?page=login");
        }
    }

    public function signIn() {
        $error = "";

        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        require_once "views/sign_in.php";
    }

    public function prosesSignIn() {
        $nama = trim($_POST['nama']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $no_tlp = trim($_POST['no_tlp']);
        $email = trim($_POST['email']);
        $bagian = trim($_POST['bagian']);

        if (empty($nama) || empty($username) || empty($password) || empty($no_tlp) || empty($bagian)) {
            $_SESSION['error'] = "Nama, username, password, no. telepon, dan bagian wajib diisi.";
            header("Location: index.php?page=signIn");
            exit;
        }

        $model = new Berkas();
        if (!$model->tambahUser($nama, $username, $password, $no_tlp, $email, $bagian)) {
            $_SESSION['error'] = "Username sudah digunakan atau pendaftaran gagal.";
            header("Location: index.php?page=signIn");
            exit;
        }

        $_SESSION['success'] = "Pendaftaran berhasil. Silakan login.";
        header("Location: index.php?page=login");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
    }

    public function beranda() {
        $model = new Berkas();
        $user = $_SESSION['user'];
        $data = $model->tampilData();

        $total = count($data);
        $diterima = 0;

        foreach ($data as $row) {
            if ($row['status'] == "Diterima") {
                $diterima++;
            }
        }

        $menunggu = $total - $diterima;

        require_once "views/beranda.php";
    }

    public function berkasInternal() {
        require_once "views/berkas_internal.php";
    }

    public function listBerkas() {
        $model = new Berkas();
        $data = $model->tampilData();

        require_once "views/list_berkas.php";
    }

    public function tambah() {
        $model = new Berkas();
        $users = $model->daftarUser();

        require_once "views/tambah.php";
    }

    public function prosesTambah() {
        $nama = trim($_POST['n_dokumen'] ?? '');
        $tgl = trim($_POST['tgl_kirim'] ?? '');
        $tujuan = trim($_POST['tujuan'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        $model = new Berkas();

        if (empty($nama) || empty($tgl) || empty($tujuan)) {
            $_SESSION['error'] = "Semua field wajib diisi.";
            header("Location: index.php?page=tambah");
            exit;
        }

        $result = $model->tambahData($nama, $tgl, $tujuan, $keterangan);

        if (!$result) {
            $_SESSION['error'] = "Gagal menambah data. Periksa data atau struktur database.";
            header("Location: index.php?page=tambah");
            exit;
        }

        header("Location: index.php?page=listBerkas");
        exit;
    }

    public function edit() {
        $id = $_GET['id'];

        $model = new Berkas();
        $data = $model->editData($id);

        require_once "views/edit.php";
    }

    public function prosesEdit() {
        $id = $_POST['id_berkas'];
        $nama = $_POST['n_dokumen'];
        $tgl = $_POST['tgl_kirim'];
        $tujuan = $_POST['tujuan'];
        $keterangan = $_POST['keterangan'];

        $model = new Berkas();
        $model->prosesEdit($id, $nama, $tgl, $tujuan, $keterangan);

        header("Location: index.php?page=listBerkas");
    }

    public function terima() {
        $id = $_GET['id'];

        $model = new Berkas();
        $model->terimaData($id);

        header("Location: index.php?page=listBerkas");
    }

    public function hapus() {
        $id = $_GET['id'];

        $model = new Berkas();
        $model->hapusData($id);

        header("Location: index.php?page=listBerkas");
    }

    public function profile() {
        $model = new Berkas();
        $user = $_SESSION['user'];
        $data = $model->profilData($user['id_user']);

        require_once "views/profile.php";
    }

    public function prosesProfile() {
        $id = $_POST['id_user'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $bagian = $_POST['bagian'];
        $no_tlp = $_POST['no_tlp'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $model = new Berkas();
        $model->updateProfile($id, $nama, $username, $password, $bagian, $no_tlp, $email, $role);

        $_SESSION['user'] = $model->profilData($id);

        header("Location: index.php?page=profile");
    }
}

?>