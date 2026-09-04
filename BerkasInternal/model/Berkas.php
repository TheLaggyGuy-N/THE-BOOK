<?php

require_once "config/Koneksi.php";

class Berkas {

    private $conn;

    public function __construct() {
        $db = new Koneksi();
        $this->conn = $db->getKoneksi();
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

    public function tambahData($nama, $tgl, $pengirim, $tujuan, $semua, $keterangan, $file) {

        if ($semua == 1) {

            $sql = "INSERT INTO berkas
            (n_dokumen, tgl_kirim, id_pengirim, id_tujuan, tujuan_semua, tgl_terima, keterangan, file_berkas)
            VALUES
            ('$nama', '$tgl', '$pengirim', NULL, 1, NULL, '$keterangan', '$file')";

        } else {

            $sql = "INSERT INTO berkas
            (n_dokumen, tgl_kirim, id_pengirim, id_tujuan, tujuan_semua, tgl_terima, keterangan, file_berkas)
            VALUES
            ('$nama', '$tgl', '$pengirim', '$tujuan', 0, NULL, '$keterangan', '$file')";
        }

        return $this->conn->query($sql);
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
                tgl_terima = CURDATE()
                WHERE id_berkas = $id
                AND (
                    id_tujuan = $id_user
                    OR tujuan_semua = 1
                )";

        return $this->conn->query($sql);
    }
}

?>