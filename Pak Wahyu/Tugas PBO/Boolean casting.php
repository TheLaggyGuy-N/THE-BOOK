<!DOCTYPE html>
<html>
<head>
    <title>Belajar Cara Konversi Tipe Data PHP</title>
</head>
<body>
<?php
// Konversi menjadi Boolean
var_dump((bool) 3); 
echo "<br />";

var_dump((bool) 0);
echo "<br />";

var_dump((bool) -1);
echo "<br />";

var_dump((bool) 0.0);
echo "<br />";

var_dump((bool) "");
echo "<br />";

var_dump((bool) " ");
echo "<br />";

var_dump((bool) "0");
echo "<br />";

var_dump((bool) "FALSE");
echo "<br />";

var_dump((bool) array());
echo "<br />";

var_dump((bool) array("data"));
echo "<br />";
?>
</body>
</html>
