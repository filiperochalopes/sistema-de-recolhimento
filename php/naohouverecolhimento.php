<html>
    <body>
    
<?php

header('Content-Type: text/html; charset=utf-8');

$ic = $_POST["ic"];
$cidade = $_POST["cidade"];
$setor = $_POST["setor"];
$data = date('Y-m-d H:i:s');

include "dbconfig.php";
require("../functions.php");

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$query = $conndb->query("SELECT * FROM ic_$setor WHERE num = $ic")or die($hint = "O setor não existe [ERR001]");
$num_query = $query->num_rows;

while($row = $query->fetch_assoc()){
    //lider1
    $query2 = $conndb->query("SELECT * FROM pessoas WHERE id = ".$row[lider1]."")or die($conndb->error);
    while($row2 = $query2->fetch_assoc()){
        //lider2
        if($row[lider2] != NULL){
            $query3 = $conndb->query("SELECT * FROM pessoas WHERE id = ".$row[lider2]."")or die($conndb->error);
        }else{
            $query3 = $conndb->query("SELECT * FROM pessoas WHERE id = ".$row[lider1]."")or die($conndb->error);
            $nomelider2 = "";
        }
        while($row3 = $query3->fetch_assoc()){
            if($row[lider2] != NULL){
                $nomelider2 = " e ".$row3[nome];
            }
            $lideres = $row2[nome].$nomelider2;
        }
    }
}
    
        
$assunto = "NÃO HOUVE RECOLHIMENTO [$ic]";
$mensagem = "Prezado irmão,<br><br>O grupo caseiro $ic, cujos líderes $lideres são responsáveis na Igreja em $cidade informa que não houve recolhimento na reunião da Igreja na casa essa semana.<br><br>Saudações,<br><br> Responsáveis. <br> $data";
        
enviaremail("", $assunto, $mensagem, "");

?>
    </body>
</html>