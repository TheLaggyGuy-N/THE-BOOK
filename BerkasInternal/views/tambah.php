<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berkas</title>

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
    </style>
</head>

<body>

<div class="box">

    <h2>Tambah Berkas Internal</h2>

    <form action="index.php?aksi=prosesTambah" method="POST" enctype="multipart/form-data">

        <label>Nama Dokumen</label>
        <input type="text" name="n_dokumen" required>

        <label>Tanggal Kirim</label>
        <input type="date" name="tgl_kirim" required>

        <label>Tujuan</label>

        <select name="tujuan" id="tujuan">

            <option value="">Pilih Pengguna</option>

            <?php foreach ($user as $row) { ?>

                <?php if ($row['id_user'] != $_SESSION['id_user']) { ?>

                    <option value="<?php echo $row['id_user']; ?>">
                        <?php echo $row['nama']; ?>
                    </option>

                <?php } ?>

            <?php } ?>

        </select>

        <label>
            <input type="checkbox" name="semua" value="1"
            onclick="semuaUser()">

            Kirim ke Semua Pengguna
        </label>

        <label>Keterangan</label>

        <textarea name="keterangan"></textarea>

        <label>Upload Berkas</label>
        <input type="file" name="file_berkas" required>

        <button type="submit">Kirim Berkas</button>

    </form>

    <br>

    <a href="index.php?aksi=berkas">Kembali</a>

</div>

<script>

function semuaUser() {
    var checkbox = document.querySelector('input[name="semua"]');
    var tujuan = document.getElementById('tujuan');

    if (checkbox.checked) {
        tujuan.value = "";
        tujuan.disabled = true;
    } else {
        tujuan.disabled = false;
    }
}

</script>

</body>
</html>