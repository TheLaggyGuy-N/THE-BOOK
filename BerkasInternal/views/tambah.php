<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berkas</title>
    <link rel="stylesheet" href="views/css/style.css?v=3">
</head>
<body>
<div class="container">
<div class="box">
    <h2>Tambah Berkas Internal</h2>
    <?php if (!empty($pesan)) { ?>
        <p class="form-message"><?php echo htmlspecialchars($pesan); ?></p>
    <?php } ?>
    <form action="index.php?aksi=prosesTambah" method="POST" enctype="multipart/form-data">
        <label>Nama Dokumen</label>
        <input type="text" name="n_dokumen" required>
        <label>Tujuan</label>
        <select name="tujuan" id="tujuan">
            <option value="" style="text-align: center;">--- Pilih Pengguna ---</option>
            <?php foreach ($user as $row) { ?>
                <?php if ($row['id_user'] != $_SESSION['id_user']) { ?>
                    <option value="<?php echo $row['id_user']; ?>" style="text-align: center;">
                        <?php echo $row['nama']; ?> (<?php echo $row['bagian']; ?>)
                    </option>
                <?php } ?>
            <?php } ?>
        </select>
        <label>Keterangan</label>
        <textarea name="keterangan"></textarea>
        <label>Upload Berkas</label>
        <input type="file" name="file_berkas[]" id="file_berkas" multiple>
        <div id="daftar-file"></div>
        <div class="file-actions">
            <button type="submit">Kirim Berkas</button>
            <button type="button" class="batal" onclick="batalFile()">
                Batal Pilih File
            </button>
        </div>
    </form>
    <br>
    <a href="index.php?aksi=berkas">Kembali</a>
</div>
</div>
<script>
var fileTerpilih = new DataTransfer();

function batalFile() {
    fileTerpilih = new DataTransfer();
    document.getElementById('file_berkas').value = '';
    document.getElementById('daftar-file').innerHTML = '';
}
document.getElementById('file_berkas').addEventListener('change', function() {
    var daftar = document.getElementById('daftar-file');
    for (var i = 0; i < this.files.length; i++) {
        var fileBaru = this.files[i];
        var sudahAda = Array.from(fileTerpilih.files).some(function(fileLama) {
            return fileLama.name === fileBaru.name &&
                fileLama.size === fileBaru.size &&
                fileLama.lastModified === fileBaru.lastModified;
        });
        if (!sudahAda) {
            fileTerpilih.items.add(fileBaru);
        }
    }
    this.files = fileTerpilih.files;
    daftar.innerHTML = '';
    for (var j = 0; j < fileTerpilih.files.length; j++) {
        daftar.innerHTML += '<p>' + fileTerpilih.files[j].name + '</p>';
    }
});
</script>
</body>
</html>
