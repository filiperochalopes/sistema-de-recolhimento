<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$array = $_POST["array"];

$ic= $_COOKIE["setorrs_ic"];

$file = fopen("../js/".$ic.".json", "w+");

$json = json_decode($array, true);

fwrite($file, json_encode($json, JSON_PRETTY_PRINT));

fclose($file);
?>
