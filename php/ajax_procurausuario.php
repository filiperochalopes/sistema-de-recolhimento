<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";
require("../functions.php");

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$usuario = $_REQUEST["usuario"];   

$query = $conndb->query("SELECT * FROM pessoas WHERE nome = '$usuario' LIMIT 1")or die("none");
$num_query = $query->num_rows;

$doc = "../js/pessoas.json";

if (file_exists("../js/pessoas.json")){

    if(date("U", filectime($doc) <= time() - 3600)){
        criarJSON();
    }
       
}else{
    criarJSON();
}

while($row = $query->fetch_assoc()){

    $usu_id = $row["id"];
    echo $usu_id;

}

?>
