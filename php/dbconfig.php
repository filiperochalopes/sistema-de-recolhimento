<?php

$dbhost = 'setorrs.com.br';
$dbuser = 'setor795_db';
$dbpass = '@nilton7';

$conndb = new mysqli($dbhost,$dbuser,$dbpass,"setor795_pvof") or die("Error " . mysqli_error($conn));
$conndb->set_charset("utf8");
//mysql_close($conn);

?>
