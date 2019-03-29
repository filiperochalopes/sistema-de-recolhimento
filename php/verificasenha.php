<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$id = $_POST["id"];
$senha = $_POST["num"];

$query = $conndb->query("SELECT * FROM pessoas WHERE id = '$id' AND senha = '$senha' ")or die($conndb->error);
$num_query = $query->num_rows;

while($row = $query->fetch_assoc()){
    
    setcookie("setorrs_pvof_senha", md5($id.$senha), time() + (60 * 60), "/");
    setcookie("setorrs_pvof_nome", $row["nome"], time() + (60 * 60), "/");
    setcookie("setorrs_pvof_id", $row["id"], time() + (60 * 60), "/");
    setcookie("setorrs_pvof_ic", $row["ic"], time() + (60 * 60), "/");
    echo $row["nome"];

}

if($num_query <= 0){
    echo "Senha inválida.";
}

?>
