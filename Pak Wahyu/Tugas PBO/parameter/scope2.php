<?php
    $a = 7;

    function coba(){
        global $a;
        global $b;

       $b = 15;
       echo "$a <br/>"; // 7
       echo "$b <br/>" ; // 15

    }
    
    coba();
    echo "$a <br/>"; // 7
    echo $b; // 15

?>