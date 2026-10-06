<?php
    function perkenalan_diri($nama_lengkap, $tanggal_lahir, $usia, $alamat, $kelas="XI") {
        echo "<hr/>";
        echo "Halo, Perkenalkan Nama Lengkap Saya $nama_lengkap <br/>";
        echo "Tanggal Lahir saya $tanggal_lahir <br/>";
        echo "Usia Saya Saat ini $usia Tahun <br/>";
        echo "Saya Sekarang Berada Di Kelas $kelas";
        echo "Dan Saya Tingga Di Kota $alamat";
        echo "<hr/>";
    }
    perkenalan_diri("Rhajju Nickholas Putra", "09 Januari 2009", "16", "Depok");
    perkenalan_diri("Dhanu Hastungkoro", "08 September 2008", "17", "Depok");
?>