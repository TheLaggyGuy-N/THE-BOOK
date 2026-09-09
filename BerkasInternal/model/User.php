<?php
require_once "config/Koneksi.php";
class User {
    private $conn;
    public function __construct() {
        $db = new Koneksi();
        $this->conn = $db->getKoneksi();
        $this->pastikanKolomPersonal();
        $this->hapusKolomTidakTerpakai();
    }
    private function pastikanKolomPersonal() {
        $kolomPersonal = [
            'hobi' => 'VARCHAR(100) DEFAULT NULL',
            'makanan_favorit' => 'VARCHAR(100) DEFAULT NULL',
            'hewan_favorit' => 'VARCHAR(100) DEFAULT NULL'
        ];
        foreach ($kolomPersonal as $namaKolom => $definisi) {
            $namaKolomAman = $this->conn->real_escape_string($namaKolom);
            $cekKolom = $this->conn->query(
                "SHOW COLUMNS FROM `user` LIKE '$namaKolomAman'"
            );
            if ($cekKolom->num_rows === 0) {
                $this->conn->query(
                    "ALTER TABLE `user` ADD COLUMN `$namaKolom` $definisi"
                );
            }
        }
    }
    private function hapusKolomTidakTerpakai() {
        foreach (['email', 'no_tlp'] as $namaKolom) {
            $namaKolomAman = $this->conn->real_escape_string($namaKolom);
            $cekKolom = $this->conn->query(
                "SHOW COLUMNS FROM `user` LIKE '$namaKolomAman'"
            );
            if ($cekKolom->num_rows > 0) {
                $this->conn->query("ALTER TABLE `user` DROP COLUMN `$namaKolom`");
            }
        }
    }
    public function login($username) {
        $sql = "SELECT * FROM `user` WHERE username = '$username'";
        $hasil = $this->conn->query($sql);
        return $hasil->fetch_assoc();
    }
    public function jumlahPengguna() {
        $hasil = $this->conn->query("SELECT COUNT(*) AS total FROM `user`");
        $data = $hasil->fetch_assoc();
        return (int) $data['total'];
    }
    public function daftarPengguna() {
        $hasil = $this->conn->query("SELECT id_user, nama, bagian FROM `user` ORDER BY nama ASC");
        return $hasil->fetch_all(MYSQLI_ASSOC);
    }
    public function register($nama, $username, $password, $bagian) {
        $sql = "INSERT INTO `user`
        (nama, username, password, bagian, role)
        VALUES
        ('$nama', '$username', '$password', '$bagian', 'pegawai')";
        return $this->conn->query($sql);
    }
    public function ambilUser($id_user) {
        $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function dataPersonalLengkap($id_user) {
        $user = $this->ambilUser($id_user);
        return $user
            && (
                trim((string) $user['hobi']) !== ''
                || trim((string) $user['makanan_favorit']) !== ''
                || trim((string) $user['hewan_favorit']) !== ''
            );
    }
    public function ubahDataPersonal($id_user, $hobi, $makananFavorit, $hewanFavorit) {
        $stmt = $this->conn->prepare("UPDATE `user`
            SET hobi = ?, makanan_favorit = ?, hewan_favorit = ?
            WHERE id_user = ?");
        $stmt->bind_param("sssi", $hobi, $makananFavorit, $hewanFavorit, $id_user);
        return $stmt->execute();
    }
    public function verifikasiDataPersonal($id_user, $hobi, $makananFavorit, $hewanFavorit) {
        $user = $this->ambilUser($id_user);
        $jawaban = [
            [$user['hobi'] ?? '', $hobi],
            [$user['makanan_favorit'] ?? '', $makananFavorit],
            [$user['hewan_favorit'] ?? '', $hewanFavorit]
        ];
        foreach ($jawaban as $pasangan) {
            if (trim($pasangan[1]) !== ''
                && strcasecmp(trim($pasangan[0]), trim($pasangan[1])) === 0) {
                return true;
            }
        }
        return false;
    }
    public function ubahPassword($id_user, $password) {
        $stmt = $this->conn->prepare("UPDATE `user` SET password = ? WHERE id_user = ?");
        $stmt->bind_param("si", $password, $id_user);
        return $stmt->execute();
    }
}
?>
