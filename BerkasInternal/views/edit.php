<!DOCTYPE html>
<html>
<head>
    <title>Edit Berkas</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        .box {
            width: 500px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 7px 0 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background: #198754;
            color: white;
            border: none;
        }

        a {
            text-decoration: none;
        }

        .check {
            width: auto;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Edit Berkas</h2>

    <form action="index.php?aksi=prosesEdit" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id_berkas"
        value="<?php echo $data['id_berkas']; ?>">

        <label>Nama Dokumen</label>

        <input type="text" name="n_dokumen"
        value="<?php echo $data['n_dokumen']; ?>" required>

        <label>Tanggal Kirim</label>

        <input type="date" name="tgl_kirim"
        value="<?php echo $data['tgl_kirim']; ?>" required>

        <label>Tujuan</label>

        <select name="tujuan" id="tujuan">

            <option value="">Pilih Pengguna</option>

            <?php foreach ($user as $row) { ?>

                <?php if ($row['id_user'] != $_SESSION['id_user']) { ?>

                    <option value="<?php echo $row['id_user']; ?>"
                    <?php
                    if ($data['tujuan_semua'] == 0 &&
                        $row['id_user'] == $data['id_tujuan']) {
                        echo "selected";
                    }
                    ?>>

                        <?php echo $row['nama']; ?>

                    </option>

                <?php } ?>

            <?php } ?>

        </select>

        <label>
            <input type="checkbox"
                   class="check"
                   name="semua"
                   value="1"
                   id="semua"
                   onclick="semuaUser()"
                   <?php if ($data['tujuan_semua'] == 1) echo "checked"; ?>>

            Kirim ke Semua Pengguna
        </label>

        <label>Keterangan</label>

        <textarea name="keterangan"><?php echo $data['keterangan']; ?></textarea>

        <label>Ganti Berkas</label>

        <?php if (!empty($data['file_berkas'])) { ?>

            <p>
                File sekarang:
                <a href="uploads/<?php echo $data['file_berkas']; ?>" target="_blank">
                    Lihat Berkas
                </a>
            </p>

        <?php } else { ?>

            <p>Belum ada file.</p>

        <?php } ?>

        <input type="file" name="file_berkas">

        <button type="submit">Simpan Perubahan</button>

    </form>

    <br>

    <a href="index.php?aksi=berkas">Kembali</a>

</div>

<script>

function semuaUser() {

    var checkbox = document.getElementById("semua");
    var tujuan = document.getElementById("tujuan");

    if (checkbox.checked) {
        tujuan.value = "";
        tujuan.disabled = true;
    } else {
        tujuan.disabled = false;
    }
}

window.onload = function() {

    var checkbox = document.getElementById("semua");
    var tujuan = document.getElementById("tujuan");

    if (checkbox.checked) {
        tujuan.disabled = true;
    }

};

</script>

</body>
</html>