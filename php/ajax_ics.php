<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$setor = $_REQUEST["setor"];
$ics = $_REQUEST["ics"];

if($ics != ""){

    $query = $conndb->query("SELECT * FROM ic_$setor ORDER BY num ASC")or die($hint = "O setor não existe [ERR001]");
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
                    $nomelider2 = ", ".$row3[nome];
                }
                $a[] = array($row[num]." - ".$row2[nome].$nomelider2, $row[num] );
            }
        }
    }

    // get the q parameter from URL
    if($num_query >0){
        // lookup all hints from array if $q is different from ""
        
        $hint = "<option>Selecione uma Igreja na Casa</option>";
        
        $q = strtolower($q);
        $len=strlen($q);
        foreach($a as $name) {
            if ($hint === "") {
                $hint .= "<option value='".$name[1]."'>".$name[0]."</option>";
            } else {
                $hint .= "<option value='".$name[1]."'>".$name[0]."</option>";
            }
        }

        if($hint === ""){
        }else{
            echo $hint;
        }

    }
    
}else{
    $query = $conndb->query("SELECT * FROM ic_$setor ORDER BY num ASC")or die($hint = "O setor não existe [ERR001]");
}


?>
