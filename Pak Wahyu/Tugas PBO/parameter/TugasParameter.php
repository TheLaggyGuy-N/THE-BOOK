<?php   
    function perkenalan($salam, $nama, $sekolah="<b>SMK PGRI 1 Depok</b>", $jurusan="<b>Pengembangan Perangkat Lunak dan Gim</b>"){
        echo $salam. "<br/>";
        echo "<i>Saya $nama, Saya Sekolah di $sekolah</i><br/>";
        echo "<i> Saya Merupakan Siswa jurusan $jurusan</i>";
    }
    perkenalan("Hai kawan,, ", "Muhammad faisal harnandaa");
?>