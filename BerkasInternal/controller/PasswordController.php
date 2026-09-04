<?php

require_once "model/User.php";

class PasswordController {

    public function ganti() {
        session_start();

        $mode = isset($_SESSION['id_user']) ? 'ganti' : 'lupa';
        $model = new User();
        $verifikasi = $mode === 'lupa'
            || $model->perluVerifikasiPassword($_SESSION['id_user']);

        if ($verifikasi) {
            $_SESSION['password_angka_1'] = rand(1, 9);
            $_SESSION['password_angka_2'] = rand(1, 9);
        }

        require_once "views/ganti_password.php";
    }

    public function prosesGanti() {
        session_start();

        $mode = $_POST['mode'] ?? 'ganti';
        $passwordLama = $_POST['password_lama'] ?? '';
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $passwordBaru = $_POST['password_baru'] ?? '';
        $konfirmasi = $_POST['konfirmasi_password'] ?? '';

        if ($passwordBaru !== $konfirmasi) {
            echo "Konfirmasi password baru tidak sama";
            exit;
        }

        if (strlen($passwordBaru) < 6) {
            echo "Password baru minimal 6 karakter";
            exit;
        }

        $model = new User();
        if ($mode === 'lupa') {
            $user = $model->ambilUserDenganEmail($username, $email);
        } else {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?aksi=login");
                exit;
            }
            $user = $model->ambilUser($_SESSION['id_user']);
        }

        if (!$user || ($mode === 'ganti' && !password_verify($passwordLama, $user['password']))) {
            echo "Password lama salah";
            exit;
        }

        if ($mode === 'lupa' || $model->perluVerifikasiPassword($user['id_user'])) {
            $jawaban = (int) ($_POST['jawaban_verifikasi'] ?? 0);
            $hasil = (int) ($_SESSION['password_angka_1'] ?? 0)
                + (int) ($_SESSION['password_angka_2'] ?? 0);

            if ($jawaban !== $hasil) {
                echo "Verifikasi salah";
                exit;
            }
        }

        if ($model->gantiPassword($user['id_user'], password_hash($passwordBaru, PASSWORD_DEFAULT))) {
            unset($_SESSION['password_angka_1'], $_SESSION['password_angka_2']);
            echo "Password berhasil diganti. <a href='index.php?aksi=home'>Kembali ke Home</a>";
            exit;
        }

        echo "Password gagal diganti";
    }
}

?>
