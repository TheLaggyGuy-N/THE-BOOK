<?php

require_once "config/Koneksi.php";

class User {
    private $conn;

    public function __construct() {
        $db = new Koneksi();
        $this->conn = $db->getKoneksi();
    }

    public function login($username) {
        $sql = "SELECT * FROM `user` WHERE username = '$username'";
        $hasil = $this->conn->query($sql);

        return $hasil->fetch_assoc();
    }

    public function register($nama, $username, $password, $bagian, $no_tlp, $email) {
        $sql = "INSERT INTO `user`
        (nama, username, password, bagian, no_tlp, email, role)
        VALUES
        ('$nama', '$username', '$password', '$bagian', '$no_tlp', '$email', 'pegawai')";

        return $this->conn->query($sql);
    }

    public function ambilUser($id_user) {
        $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function ambilUserDenganEmail($username, $email) {
        $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE username = ? AND email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function perluVerifikasiPassword($id_user) {
        $user = $this->ambilUser($id_user);

        if (!$user || empty($user['pw_waktuganti'])) {
            return false;
        }

        $awalPeriode = strtotime($user['pw_waktuganti']);
        return $user['pw_batas'] >= 2
            && $awalPeriode >= strtotime('-14 days');
    }

    public function gantiPassword($id_user, $password) {
        $user = $this->ambilUser($id_user);
        $sekarang = time();
        $awalPeriode = $user['pw_waktuganti']
            ? strtotime($user['pw_waktuganti'])
            : 0;

        if (!$awalPeriode || $awalPeriode < strtotime('-14 days')) {
            $jumlahPerubahan = 1;
            $awalPeriodeBaru = date('Y-m-d H:i:s', $sekarang);
        } else {
            $jumlahPerubahan = (int) $user['pw_batas'] + 1;
            $awalPeriodeBaru = $user['pw_waktuganti'];
        }

        $stmt = $this->conn->prepare("UPDATE `user`
            SET password = ?, pw_diganti = NOW(),
                pw_batas = ?, pw_waktuganti = ?
            WHERE id_user = ?");
        $stmt->bind_param("sisi", $password, $jumlahPerubahan, $awalPeriodeBaru, $id_user);

        return $stmt->execute();
    }
}

?>