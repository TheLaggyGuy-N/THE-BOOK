<?php
require_once "config/Koneksi.php";
class Berkas {
    private $conn;
    public function __construct() {
        $db = new Koneksi();
        $this->conn = $db->getKoneksi();
        $this->buatTabelKomentar();
        $this->buatTabelPesan();
        $this->pastikanStrukturBerkas();
    }

    private function pastikanStrukturBerkas() {
        $this->conn->query("ALTER TABLE `berkas`
            MODIFY `status` ENUM('Dikirim', 'Diterima', 'Ditolak')
                NOT NULL DEFAULT 'Dikirim'");
        $this->conn->query("UPDATE `berkas` b
            LEFT JOIN `user` u ON b.id_tujuan = u.id_user
            SET b.id_tujuan = NULL
            WHERE b.id_tujuan IS NOT NULL AND u.id_user IS NULL");

        $this->ubahAksiHapusPengirim();

        $this->tambahForeignKeyJikaBelumAda(
            'berkas_pengirim_fk',
            'id_pengirim',
            'user',
            'id_user'
        );
        $this->tambahForeignKeyJikaBelumAda(
            'berkas_tujuan_fk',
            'id_tujuan',
            'user',
            'id_user'
        );
    }

    private function tambahForeignKeyJikaBelumAda($nama, $kolom, $tabelReferensi, $kolomReferensi) {
        $stmt = $this->conn->prepare("SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'berkas'
            AND COLUMN_NAME = ?
            AND REFERENCED_TABLE_NAME IS NOT NULL
            LIMIT 1");
        $stmt->bind_param("s", $kolom);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            $this->conn->query("ALTER TABLE `berkas`
                ADD CONSTRAINT `$nama`
                FOREIGN KEY (`$kolom`) REFERENCES `$tabelReferensi` (`$kolomReferensi`)
                ON DELETE SET NULL ON UPDATE CASCADE");
        }
    }

    private function ubahAksiHapusPengirim() {
        $stmt = $this->conn->prepare("SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'berkas'
            AND COLUMN_NAME = 'id_pengirim'
            AND REFERENCED_TABLE_NAME = 'user'
            LIMIT 1");
        $stmt->execute();
        $fk = $stmt->get_result()->fetch_assoc();
        if (!$fk) {
            return;
        }

        $namaFk = str_replace('`', '', $fk['CONSTRAINT_NAME']);
        $aturan = $this->conn->prepare("SELECT DELETE_RULE
            FROM information_schema.REFERENTIAL_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE() AND CONSTRAINT_NAME = ?");
        $aturan->bind_param("s", $namaFk);
        $aturan->execute();
        $dataAturan = $aturan->get_result()->fetch_assoc();
        if ($dataAturan && $dataAturan['DELETE_RULE'] === 'RESTRICT') {
            return;
        }

        $this->conn->query("ALTER TABLE `berkas` DROP FOREIGN KEY `$namaFk`");
        $this->conn->query("ALTER TABLE `berkas`
            ADD CONSTRAINT `berkas_pengirim_fk`
            FOREIGN KEY (`id_pengirim`) REFERENCES `user` (`id_user`)
            ON DELETE RESTRICT ON UPDATE CASCADE");
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

    private function buatTabelPesan() {
        $this->conn->query("CREATE TABLE IF NOT EXISTS pesan_berkas (
            id_pesan INT NOT NULL AUTO_INCREMENT,
            id_berkas INT NOT NULL,
            id_pengirim INT NOT NULL,
            id_penerima INT NOT NULL,
            jenis VARCHAR(30) NOT NULL,
            pesan TEXT NOT NULL,
            sudah_dibaca TINYINT(1) NOT NULL DEFAULT 0,
            dibuat_pada TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id_pesan),
            INDEX (id_penerima),
            INDEX (id_berkas)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    public function tampilData($id_user, $pencarian = '') {
        $sql = "SELECT berkas.*,
                pengirim.nama AS nama_pengirim,
                penerima.nama AS nama_penerima
                FROM berkas
                JOIN `user` pengirim
                ON berkas.id_pengirim = pengirim.id_user
                LEFT JOIN `user` penerima
                ON berkas.id_tujuan = penerima.id_user
                WHERE (berkas.id_tujuan = ?
                OR berkas.id_pengirim = ?)";
        if ($pencarian !== '') {
            $sql .= " AND (berkas.n_dokumen LIKE ?
                OR pengirim.nama LIKE ?
                OR penerima.nama LIKE ?
                OR berkas.tgl_kirim LIKE ?
                OR berkas.status LIKE ?)";
        }
        $sql .= "
                ORDER BY berkas.id_berkas DESC";
        $stmt = $this->conn->prepare($sql);
        if ($pencarian !== '') {
            $kataKunci = "%" . $pencarian . "%";
            $stmt->bind_param(
                "iisssss",
                $id_user,
                $id_user,
                $kataKunci,
                $kataKunci,
                $kataKunci,
                $kataKunci,
                $kataKunci
            );
        } else {
            $stmt->bind_param("ii", $id_user, $id_user);
        }
        $stmt->execute();
        $hasil = $stmt->get_result();
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function jumlahBerkasBelumDiterima($id_user) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS jumlah
            FROM berkas
            WHERE id_tujuan = ? AND tgl_terima IS NULL");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $hasil = $stmt->get_result()->fetch_assoc();
        return (int) $hasil['jumlah'];
    }

    public function tampilDiterima($id_user, $pencarian = '') {
        $sql = "SELECT
            MIN(berkas.id_berkas) AS id_berkas,
            berkas.n_dokumen,
            berkas.tgl_kirim,
            berkas.id_pengirim,
            berkas.keterangan,
            pengirim.nama AS nama_pengirim,
            GROUP_CONCAT(berkas.file_berkas SEPARATOR '|||') AS daftar_file,
            COUNT(*) AS jumlah_file,
            SUM(CASE WHEN berkas.tgl_terima IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_diterima,
            SUM(CASE WHEN berkas.status = 'Ditolak' THEN 1 ELSE 0 END) AS jumlah_ditolak
                FROM berkas
                JOIN `user` pengirim
                ON berkas.id_pengirim = pengirim.id_user
                WHERE berkas.id_tujuan = ?
                AND berkas.id_pengirim != ?";
        if ($pencarian !== '') {
            $sql .= " AND (berkas.n_dokumen LIKE ?
                OR pengirim.nama LIKE ?
                OR berkas.tgl_kirim LIKE ?
                OR berkas.keterangan LIKE ?)";
        }
        $sql .= "
            GROUP BY berkas.id_pengirim, berkas.tgl_kirim,
            berkas.n_dokumen, berkas.keterangan, pengirim.nama
            ORDER BY MAX(berkas.id_berkas) DESC";
        $stmt = $this->conn->prepare($sql);
        if ($pencarian !== '') {
            $kataKunci = "%" . $pencarian . "%";
            $stmt->bind_param(
                "iissss",
                $id_user,
                $id_user,
                $kataKunci,
                $kataKunci,
                $kataKunci,
                $kataKunci
            );
        } else {
            $stmt->bind_param("ii", $id_user, $id_user);
        }
        $stmt->execute();
        $hasil = $stmt->get_result();
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

    public function detailKelompok($id_berkas) {
        $detail = [
            'daftar_file' => [],
            'komentar' => []
        ];
        $kelompok = $this->conn->prepare("SELECT n_dokumen, tgl_kirim,
                id_pengirim, keterangan
                FROM berkas WHERE id_berkas = ?");
        $kelompok->bind_param("i", $id_berkas);
        $kelompok->execute();
        $dataKelompok = $kelompok->get_result()->fetch_assoc();
        if (!$dataKelompok) {
            return $detail;
        }

        $files = $this->conn->prepare("SELECT file_berkas FROM berkas
            WHERE n_dokumen = ? AND tgl_kirim = ? AND id_pengirim = ?
            AND keterangan = ? ORDER BY id_berkas ASC");
        $files->bind_param("ssis", $dataKelompok['n_dokumen'],
            $dataKelompok['tgl_kirim'], $dataKelompok['id_pengirim'],
            $dataKelompok['keterangan']);
        $files->execute();
        $hasilFile = $files->get_result();
        while ($file = $hasilFile->fetch_assoc()) {
            if (!empty($file['file_berkas'])) {
                $detail['daftar_file'][] = $file['file_berkas'];
            }
        }

        $comments = $this->conn->prepare("SELECT komentar_berkas.komentar,
                komentar_berkas.dibuat_pada, user.nama
                FROM komentar_berkas
                JOIN `user` ON komentar_berkas.id_user = user.id_user
                JOIN berkas ON komentar_berkas.id_berkas = berkas.id_berkas
                WHERE berkas.n_dokumen = ? AND berkas.tgl_kirim = ?
                AND berkas.id_pengirim = ? AND berkas.keterangan = ?
                ORDER BY komentar_berkas.dibuat_pada ASC");
        $comments->bind_param("ssis", $dataKelompok['n_dokumen'],
            $dataKelompok['tgl_kirim'], $dataKelompok['id_pengirim'],
            $dataKelompok['keterangan']);
        $comments->execute();
        $hasilKomentar = $comments->get_result();
        while ($komentar = $hasilKomentar->fetch_assoc()) {
            $detail['komentar'][] = $komentar;
        }
        return $detail;
    }

    public function tambahKomentar($id_berkas, $id_user, $komentar) {
        $akses = $this->conn->prepare("SELECT id_berkas FROM berkas
            WHERE id_berkas = ?
            AND (id_pengirim = ? OR id_tujuan = ?)");
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

    public function adaBerkasMenunggu($id_user) {
        $stmt = $this->conn->prepare("SELECT id_berkas FROM berkas
            WHERE id_pengirim = ? AND id_tujuan IS NOT NULL
            AND tgl_terima IS NULL AND status = 'Dikirim' LIMIT 1");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return (bool) $stmt->get_result()->fetch_assoc();
    }

    public function buatPesanSistem($id_berkas, $id_pengirim, $id_penerima, $pesan) {
        $jenis = 'sistem';
        $stmt = $this->conn->prepare("INSERT INTO pesan_berkas
            (id_berkas, id_pengirim, id_penerima, jenis, pesan)
            VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $id_berkas, $id_pengirim, $id_penerima,
            $jenis, $pesan);
        return $stmt->execute();
    }

    public function kirimPengingat($id_berkas, $id_pengirim, $pesan) {
        $stmt = $this->conn->prepare("SELECT id_tujuan FROM berkas
            WHERE id_berkas = ? AND id_pengirim = ?
            AND tgl_terima IS NULL AND status = 'Dikirim'");
        $stmt->bind_param("ii", $id_berkas, $id_pengirim);
        $stmt->execute();
        $berkas = $stmt->get_result()->fetch_assoc();
        if (!$berkas || empty($berkas['id_tujuan'])) {
            return false;
        }
        $jenis = 'pengingat';
        $penerima = (int) $berkas['id_tujuan'];
        $insert = $this->conn->prepare("INSERT INTO pesan_berkas
            (id_berkas, id_pengirim, id_penerima, jenis, pesan)
            VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iiiss", $id_berkas, $id_pengirim, $penerima,
            $jenis, $pesan);
        return $insert->execute();
    }

    public function beriTahuBelumDapatDiterima($id_berkas, $id_penerima) {
        $stmt = $this->conn->prepare("SELECT id_pengirim FROM berkas
            WHERE id_berkas = ? AND id_tujuan = ?
            AND tgl_terima IS NULL AND status = 'Dikirim'");
        $stmt->bind_param("ii", $id_berkas, $id_penerima);
        $stmt->execute();
        $berkas = $stmt->get_result()->fetch_assoc();
        if (!$berkas) {
            return false;
        }
        $jenis = 'belum_dapat_diterima';
        $pesan = 'Penerima memberi tahu bahwa berkas belum dapat diterima.';
        $pengirim = (int) $berkas['id_pengirim'];
        $insert = $this->conn->prepare("INSERT INTO pesan_berkas
            (id_berkas, id_pengirim, id_penerima, jenis, pesan)
            VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iiiss", $id_berkas, $id_penerima, $pengirim,
            $jenis, $pesan);
        return $insert->execute();
    }

    public function tolakKelompok($id_user, $id_pengirim, $tgl_kirim, $n_dokumen, $keterangan) {
        $stmt = $this->conn->prepare("UPDATE berkas SET status = 'Ditolak'
            WHERE id_pengirim = ? AND tgl_kirim = ? AND n_dokumen = ?
            AND keterangan = ? AND id_tujuan = ? AND tgl_terima IS NULL");
        $stmt->bind_param("isssi", $id_pengirim, $tgl_kirim, $n_dokumen,
            $keterangan, $id_user);
        if (!$stmt->execute() || $stmt->affected_rows === 0) {
            return false;
        }
        $pesan = 'Berkas belum dapat diterima oleh penerima.';
        $jenis = 'belum_dapat_diterima';
        $notifikasi = $this->conn->prepare("INSERT INTO pesan_berkas
            (id_berkas, id_pengirim, id_penerima, jenis, pesan)
            SELECT MIN(id_berkas), ?, ?, ?, ?
            FROM berkas
            WHERE id_pengirim = ? AND tgl_kirim = ? AND n_dokumen = ?
            AND keterangan = ? AND id_tujuan = ?");
        $notifikasi->bind_param("iississsi", $id_user, $id_pengirim, $jenis, $pesan,
            $id_pengirim, $tgl_kirim, $n_dokumen, $keterangan, $id_user);
        return $notifikasi->execute();
    }

    public function adaPesanBelumDapatDiterima($id_berkas, $id_pengirim) {
        $stmt = $this->conn->prepare("SELECT id_pesan FROM pesan_berkas
            WHERE id_berkas = ? AND id_penerima = ?
            AND jenis = 'belum_dapat_diterima' LIMIT 1");
        $stmt->bind_param("ii", $id_berkas, $id_pengirim);
        $stmt->execute();
        return (bool) $stmt->get_result()->fetch_assoc();
    }

    public function daftarPesan($id_user) {
        $stmt = $this->conn->prepare("SELECT pesan_berkas.*,
                berkas.n_dokumen, pengirim.nama AS nama_pengirim
                FROM pesan_berkas
                JOIN berkas ON pesan_berkas.id_berkas = berkas.id_berkas
                JOIN `user` pengirim ON pesan_berkas.id_pengirim = pengirim.id_user
                WHERE pesan_berkas.id_penerima = ?
                ORDER BY pesan_berkas.sudah_dibaca ASC,
                pesan_berkas.dibuat_pada DESC");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $hasil = $stmt->get_result();
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function tandaiPesanDibaca($id_pesan, $id_user) {
        $stmt = $this->conn->prepare("UPDATE pesan_berkas SET sudah_dibaca = 1
            WHERE id_pesan = ? AND id_penerima = ?");
        $stmt->bind_param("ii", $id_pesan, $id_user);
        return $stmt->execute();
    }

    public function tandaiPesanBerkasDibaca($id_berkas, $id_user) {
        $stmt = $this->conn->prepare("UPDATE pesan_berkas SET sudah_dibaca = 1
            WHERE id_berkas = ? AND id_penerima = ?");
        $stmt->bind_param("ii", $id_berkas, $id_user);
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
                AND id_tujuan = $id_user
                AND status = 'Dikirim'";
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
        $sql = "SELECT berkas.id_berkas,
                       berkas.n_dokumen,
                       berkas.tgl_kirim,
                       COALESCE(pengirim.nama, 'Pengguna tidak ditemukan') AS nama_pengirim,
                       COALESCE(penerima.nama, 'Tujuan tidak ditemukan') AS nama_tujuan,
                       CASE
                           WHEN berkas.status = 'Ditolak' THEN 'Ditolak'
                           WHEN berkas.tgl_terima IS NULL THEN 'Belum diterima'
                           ELSE 'Sudah diterima'
                       END AS status
                FROM berkas
                LEFT JOIN `user` pengirim
                    ON berkas.id_pengirim = pengirim.id_user
                LEFT JOIN `user` penerima
                    ON berkas.id_tujuan = penerima.id_user
                ORDER BY berkas.id_berkas DESC";
        $hasil = $this->conn->query($sql);
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function tambahData($nama, $tgl, $pengirim, $tujuan, $keterangan, $file) {
        if ((int) $pengirim <= 0) {
            return 0;
        }
        $sql = "INSERT INTO berkas
            (n_dokumen, tgl_kirim, id_pengirim, id_tujuan, tujuan_semua,
            tgl_terima, keterangan, file_berkas)
            VALUES (?, ?, ?, ?, 0, NULL, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiiss", $nama, $tgl, $pengirim, $tujuan,
            $keterangan, $file);
        if (!$stmt->execute()) {
            return 0;
        }
        return $this->conn->insert_id;
    }
    public function editData($id) {
        $sql = "SELECT * FROM berkas
                WHERE id_berkas = $id";
        $hasil = $this->conn->query($sql);
        return $hasil->fetch_assoc();
    }
    public function prosesEdit($id, $nama, $tgl, $tujuan, $keterangan, $file) {
        $sql = "UPDATE berkas SET
                n_dokumen = ?, tgl_kirim = ?, id_tujuan = ?,
                tujuan_semua = 0, tgl_terima = NULL, status = 'Dikirim',
                keterangan = ?";
        if ($file != "") {
            $sql .= ", file_berkas = ?";
        }
        $sql .= " WHERE id_berkas = ?";
        $stmt = $this->conn->prepare($sql);
        if ($file != "") {
            $stmt->bind_param("ssissi", $nama, $tgl, $tujuan, $keterangan,
                $file, $id);
        } else {
            $stmt->bind_param("ssisi", $nama, $tgl, $tujuan, $keterangan, $id);
        }
        return $stmt->execute();
    }
    public function hapusData($id) {
        $stmt = $this->conn->prepare("SELECT file_berkas FROM berkas WHERE id_berkas = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $berkas = $stmt->get_result()->fetch_assoc();
        if (!$berkas) {
            return false;
        }
        $hapusKomentar = $this->conn->prepare(
            "DELETE FROM komentar_berkas WHERE id_berkas = ?"
        );
        $hapusKomentar->bind_param("i", $id);
        $hapusKomentar->execute();
        $hapusPesan = $this->conn->prepare(
            "DELETE FROM pesan_berkas WHERE id_berkas = ?"
        );
        $hapusPesan->bind_param("i", $id);
        $hapusPesan->execute();
        $hapus = $this->conn->prepare("DELETE FROM berkas WHERE id_berkas = ?");
        $hapus->bind_param("i", $id);
        if (!$hapus->execute()) {
            return false;
        }
        if (!empty($berkas['file_berkas'])) {
            $namaFile = basename($berkas['file_berkas']);
            $lokasiFile = __DIR__ . '/../uploads/' . $namaFile;
            if (is_file($lokasiFile)) {
                unlink($lokasiFile);
            }
        }
        return true;
    }
    public function terimaData($id, $id_user) {
        $sql = "UPDATE berkas SET
                tgl_terima = CURRENT_TIMESTAMP,
                status = 'Diterima'
                WHERE id_berkas = $id
                AND id_tujuan = $id_user
                AND status = 'Dikirim'";
        return $this->conn->query($sql);
    }
}
?>
