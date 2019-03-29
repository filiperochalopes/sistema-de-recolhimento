<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";
require("../functions.php");

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$setor = "ribeira";
$cidade = "salvador";
$ic = $_REQUEST["ic"];
$nome = $_REQUEST["nome"];
$email = $_REQUEST["email"];
$parent = $_REQUEST["parent"];

$query = $conndb->query("INSERT INTO pessoas (id , funcao, cidade, setor, ic, usuario, senha, nome, email, parent) VALUES (NULL , 'pess', '".$cidade."', '".$setor."', '".$ic."', '', 1234, '".$nome."', '".$email."', '$parent');")or die("Falha ao adicionar");

criarJSON();

?>
