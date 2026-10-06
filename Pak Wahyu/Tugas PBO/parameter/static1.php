<?php
    function coba(){
        static $a = 0;
        $a = $a + 1;
        return "Ini adalah pemanggilan ke-$a fungsi coba()";
    }

    echo coba()."<br/>";
    echo coba()."<br/>";
    echo coba()."<br/>";
    echo coba()."<br/>";   
?>