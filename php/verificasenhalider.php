<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$id = $_POST["id"];
$senha = $_POST["num"];

$query = $conndb->query("SELECT * FROM pessoas WHERE id = '$id' AND senha = '$senha' AND ic = '".$_COOKIE["setorrs_ic"]."' AND (funcao = 'lider' OR funcao = 'diacono')")or die($conndb->error);
$num_query = $query->num_rows;

while($row = $query->fetch_assoc()){
    
    setcookie("setorrs_pvof_verificacao", "OK", time() + (30 * 60), "/");
    echo "Senha confirmada.<br>".$row["nome"]." reconhecido<br>Enviando...";

}

if($num_query <= 0){
    echo "Autorização negada! [ERR004]";
}

?>
