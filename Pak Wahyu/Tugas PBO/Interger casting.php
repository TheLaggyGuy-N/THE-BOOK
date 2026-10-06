<!DOCTYPE html>
<html>
<head>
    <title>Belajar Cara Konversi Tipe Data PHP</title>
</head>
<body>
<?php
// Konversi menjadi Integer
var_dump((int) 3.45);
echo "<br />";

var_dump((int) "3.45"); 
echo "<br />";

var_dump((int) "9 Naga"); 
echo "<br />";

var_dump((int) "Naga Bonar");
echo "<br />";

var_dump((int) "212 Wiro Sableng"); 
echo "<br />";

var_dump((int) FALSE); 
echo "<br />";

var_dump((int) "1FALSE"); 
echo "<br />";

var_dump((int) array());
echo "<br />";

var_dump((int) array("data")); 
echo "<br />";


?>
</body>
</html> 