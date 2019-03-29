<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$idinput = $_REQUEST["id_input"];
$q = $_REQUEST["q"];
    
if ($q !== "") {
    
    if($idinput == "setor"){
        $query = $conndb->query("SELECT DISTINCT $idinput FROM setores_salvador WHERE nome LIKE '%$q%' ORDER BY $idinput ASC LIMIT 5")or die($conndb->error);
    }else if($idinput == "pessoa"){
        $query = $conndb->query("SELECT DISTINCT nome FROM pessoas WHERE nome LIKE '%$q%' AND ic = '".$_COOKIE['setorrs_ic']."' ORDER BY nome ASC LIMIT 5")or die($conndb->error);
    }
    $num_query = $query->num_rows;

    while($row = $query->fetch_assoc()){
        if($idinput == "setor"){
            $a[] = $row[$idinput];
        }else{
            $a[] = $row["nome"];
        }

    }

    // get the q parameter from URL
    if($num_query >0){
        $idchange = $_REQUEST["id_change"];

        $hint = "";
        // lookup all hints from array if $q is different from ""

        $q = strtolower($q);
        $len=strlen($q);
        foreach($a as $name) {
            $value = $name;
            $name = str_ireplace($q, "<strong>".$q."</strong>", $name);
            if ($hint === "") {
                $hint = "<li onClick='document.getElementById(\"$idinput\").value=\"$value\"; document.getElementById(\"$idchange\").style.display=\"none\"'>$name</li>";
            } else {
                $hint .= "<li onClick='document.getElementById(\"$idinput\").value=\"$value\"; document.getElementById(\"$idchange\").style.display=\"none\"'>$name</li>";
            }
        }

        if($hint === ""){
        }else{
            echo $hint;
        }

    }

}

?>
