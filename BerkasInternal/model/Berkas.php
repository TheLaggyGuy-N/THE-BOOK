<?php
require_once "config/Koneksi.php";
class Berkas {
    private $conn;
    public function __construct() {
        $db = new Koneksi();
        $this->conn = $db->getKoneksi();
        $this->buatTabelKomentar();
    }

    private function buatTabelKomentar() {
        $this->conn->query("CREATE TABLE IF NOT EXISTS komentar_berkas (
            id_komentar INT NOT NULL AUTO_INCREMENT,
            id_berkas INT NOT NULL,
            id_user INT NOT NULL,
            komentar TEXT NOT NULL,
            dibuat_pada TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id_komentar),
            INDEX (id_berkas),
            INDEX (id_user)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    public function tampilData($id_user) {
        $sql = "SELECT berkas.*,
                pengirim.nama AS nama_pengirim,
                penerima.nama AS nama_penerima
                FROM berkas
                JOIN `user` pengirim
                ON berkas.id_pengirim = pengirim.id_user
                LEFT JOIN `user` penerima
                ON berkas.id_tujuan = penerima.id_user
                WHERE berkas.id_tujuan = $id_user
                OR berkas.tujuan_semua = 1
                OR berkas.id_pengirim = $id_user
                ORDER BY berkas.id_berkas DESC";
        $hasil = $this->conn->query($sql);
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function tampilDiterima($id_user) {
        $sql = "SELECT
            MIN(berkas.id_berkas) AS id_berkas,
            berkas.n_dokumen,
            berkas.tgl_kirim,
            berkas.id_pengirim,
            berkas.keterangan,
            pengirim.nama AS nama_pengirim,
            GROUP_CONCAT(berkas.file_berkas SEPARATOR '|||') AS daftar_file,
            COUNT(*) AS jumlah_file,
            SUM(CASE WHEN berkas.tgl_terima IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_diterima
                FROM berkas
                JOIN `user` pengirim
                ON berkas.id_pengirim = pengirim.id_user
                WHERE (berkas.id_tujuan = $id_user
                OR berkas.tujuan_semua = 1)
                AND berkas.id_pengirim != $id_user
            GROUP BY berkas.id_pengirim, berkas.tgl_kirim,
            berkas.n_dokumen, berkas.keterangan, pengirim.nama
            ORDER BY MAX(berkas.id_berkas) DESC";
        $hasil = $this->conn->query($sql);
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function komentarUntukBerkas($id_berkas) {
        $stmt = $this->conn->prepare("SELECT komentar_berkas.komentar,
                komentar_berkas.dibuat_pada, user.nama
                FROM komentar_berkas
                JOIN `user` ON komentar_berkas.id_user = user.id_user
                WHERE komentar_berkas.id_berkas = ?
                ORDER BY komentar_berkas.dibuat_pada ASC");
        $stmt->bind_param("i", $id_berkas);
        $stmt->execute();
        $hasil = $stmt->get_result();
        $komentar = [];
        while ($row = $hasil->fetch_assoc()) {
            $komentar[] = $row;
        }
        return $komentar;
    }

    public function tambahKomentar($id_berkas, $id_user, $komentar) {
        $akses = $this->conn->prepare("SELECT id_berkas FROM berkas
            WHERE id_berkas = ? AND id_pengirim != ?
            AND (id_tujuan = ? OR tujuan_semua = 1)");
        $akses->bind_param("iii", $id_berkas, $id_user, $id_user);
        $akses->execute();
        if (!$akses->get_result()->fetch_assoc()) {
            return false;
        }

        $stmt = $this->conn->prepare("INSERT INTO komentar_berkas
            (id_berkas, id_user, komentar) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_berkas, $id_user, $komentar);
        return $stmt->execute();
    }
    public function terimaKelompok($id_user, $id_pengirim, $tgl_kirim, $n_dokumen, $keterangan) {
        $sql = "UPDATE berkas SET
                tgl_terima = CURRENT_TIMESTAMP,
                status = 'Diterima'
                WHERE id_pengirim = $id_pengirim
                AND tgl_kirim = '$tgl_kirim'
                AND n_dokumen = '$n_dokumen'
                AND keterangan = '$keterangan'
                AND (id_tujuan = $id_user OR tujuan_semua = 1)";
        return $this->conn->query($sql);
    }
    public function tampilUser() {
        $sql = "SELECT * FROM `user`
                ORDER BY nama ASC";
        $hasil = $this->conn->query($sql);
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function statistikDashboard() {
        $sql = "SELECT
                    COUNT(*) AS total_berkas,
                    SUM(CASE WHEN tgl_terima IS NOT NULL THEN 1 ELSE 0 END) AS berkas_masuk,
                    COUNT(*) AS berkas_keluar
                FROM berkas";
        $hasil = $this->conn->query($sql);
        $data = $hasil->fetch_assoc();
        return [
            'total_berkas' => (int) $data['total_berkas'],
            'berkas_masuk' => (int) $data['berkas_masuk'],
            'berkas_keluar' => (int) $data['berkas_keluar']
        ];
    }
    public function berkasTerbaru() {
        $sql = "SELECT berkas.n_dokumen,
                       berkas.tgl_kirim,
                       pengirim.nama AS nama_pengirim,
                       CASE
                           WHEN berkas.tujuan_semua = 1 THEN 'Semua Pengguna'
                           ELSE penerima.nama
                       END AS nama_tujuan,
                       CASE
                           WHEN berkas.tgl_terima IS NULL THEN 'Belum diterima'
                           ELSE 'Sudah diterima'
                       END AS status
                FROM berkas
                JOIN `user` pengirim
                    ON berkas.id_pengirim = pengirim.id_user
                LEFT JOIN `user` penerima
                    ON berkas.id_tujuan = penerima.id_user
                ORDER BY berkas.id_berkas DESC
                LIMIT 5";
        $hasil = $this->conn->query($sql);
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function tambahData($nama, $tgl, $pengirim, $tujuan, $semua, $keterangan, $file) {
        if ($semua == 1) {
            $sql = "INSERT INTO berkas
            (n_dokumen, tgl_kirim, id_pengirim, id_tujuan, tujuan_semua, tgl_terima, keterangan, file_berkas)
            VALUES
            (?, ?, ?, NULL, 1, NULL, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssiss", $nama, $tgl, $pengirim, $keterangan, $file);
        } else {
            $sql = "INSERT INTO berkas
            (n_dokumen, tgl_kirim, id_pengirim, id_tujuan, tujuan_semua, tgl_terima, keterangan, file_berkas)
            VALUES
            (?, ?, ?, ?, 0, NULL, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssiiss", $nama, $tgl, $pengirim, $tujuan, $keterangan, $file);
        }
        return $stmt->execute();
    }
    public function editData($id) {
        $sql = "SELECT * FROM berkas
                WHERE id_berkas = $id";
        $hasil = $this->conn->query($sql);
        return $hasil->fetch_assoc();
    }
    public function prosesEdit($id, $nama, $tgl, $tujuan, $semua, $keterangan, $file) {
        if ($semua == 1) {
            if ($file != "") {
                $sql = "UPDATE berkas SET
                        n_dokumen = '$nama',
                        tgl_kirim = '$tgl',
                        id_tujuan = NULL,
                        tujuan_semua = 1,
                        tgl_terima = NULL,
                        status = 'Dikirim',
                        keterangan = '$keterangan',
                        file_berkas = '$file'
                        WHERE id_berkas = $id";
            } else {
                $sql = "UPDATE berkas SET
                        n_dokumen = '$nama',
                        tgl_kirim = '$tgl',
                        id_tujuan = NULL,
                        tujuan_semua = 1,
                        tgl_terima = NULL,
                        status = 'Dikirim',
                        keterangan = '$keterangan'
                        WHERE id_berkas = $id";
            }
        } else {
            if ($file != "") {
                $sql = "UPDATE berkas SET
                        n_dokumen = '$nama',
                        tgl_kirim = '$tgl',
                        id_tujuan = '$tujuan',
                        tujuan_semua = 0,
                        tgl_terima = NULL,
                        status = 'Dikirim',
                        keterangan = '$keterangan',
                        file_berkas = '$file'
                        WHERE id_berkas = $id";
            } else {
                $sql = "UPDATE berkas SET
                        n_dokumen = '$nama',
                        tgl_kirim = '$tgl',
                        id_tujuan = '$tujuan',
                        tujuan_semua = 0,
                        tgl_terima = NULL,
                        status = 'Dikirim',
                        keterangan = '$keterangan'
                        WHERE id_berkas = $id";
            }
        }
        return $this->conn->query($sql);
    }
    public function hapusData($id) {
        $sql = "DELETE FROM berkas
                WHERE id_berkas = $id";
        return $this->conn->query($sql);
    }
    public function terimaData($id, $id_user) {
        $sql = "UPDATE berkas SET
                tgl_terima = CURRENT_TIMESTAMP,
                status = 'Diterima'
                WHERE id_berkas = $id
                AND (
                    id_tujuan = $id_user
                    OR tujuan_semua = 1
                )";
        return $this->conn->query($sql);
    }
}
?>
