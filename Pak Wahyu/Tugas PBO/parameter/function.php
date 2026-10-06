<?php
    //function perkenalan(){
     //   echo "Assalamuailaikum...";
     //   echo "Perkenalkan Nama Saya Rhajju Nickholas Putra";
     //   echo "Senang Berkenalan Dengan Anda... ";
   // }

     function perkenalan($nama, $isiotak="Pintar "){
        echo $isiotak;
        echo " Perkenalkan Nama Saya ". $nama. "<br/>";
        
        echo "Senang Berkenalan Dengan Anda... <br/> ";
    }

    perkenalan("Rhajju Nickholas Putra");
    echo "<hr>";
    perkenalan("Fatir Ranadila ", "Kurang Pintar");
?>
