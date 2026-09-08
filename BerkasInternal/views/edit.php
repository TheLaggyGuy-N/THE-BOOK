<!DOCTYPE html>
<html>
<head>
    <title>Edit Berkas</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
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
        <input type="datetime-local" name="tgl_kirim"
        value="<?php echo date('Y-m-d\TH:i', strtotime($data['tgl_kirim'])); ?>" required>
        <label>Tujuan</label>
        <select name="tujuan" id="tujuan">
            <option value="">Pilih Pengguna</option>
            <?php foreach ($user as $row) { ?>
                <?php if ($row['id_user'] != $_SESSION['id_user']) { ?>
                    <option value="<?php echo $row['id_user']; ?>"
                    <?php if ($row['id_user'] == $data['id_tujuan']) {
                        echo "selected";
                    } ?>>
                        <?php echo $row['nama']; ?>
                    </option>
                <?php } ?>
            <?php } ?>
        </select>
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
</body>
</html>
