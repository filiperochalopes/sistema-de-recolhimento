<?php

header('Content-Type: text/html; charset=utf-8');

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$dados = json_decode($_POST["dados"], true);

if($_COOKIE["setorrs_pvof_verificacao"] == "OK"){
    
    foreach($dados as $pessoa){ //insere todas os envios
        
        $insert1 = $conndb->query("INSERT INTO envios_pessoa (id, pessoa, provisao, oferta, mocambique, missoes, datahora, dataic) VALUES (NULL, '".$pessoa[0]."', '".$pessoa[1]."', '".$pessoa[2]."', '".$pessoa[3]."', '".$pessoa[4]."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d')."');")or die($conndb->error);
             
    }
    
    $totalprovisao = 0;
    
    foreach($dados as $pv){ //insere todas os envios
        
        $totalprovisao += $pv[1];  
             
    }
    
    $totalofertas = 0;
    
    foreach($dados as $of){ //insere todas os envios
        
        $totalofertas += $of[2];  
             
    }
    
    $totalmoc = 0;
    
    foreach($dados as $moc){ //insere todas os envios
        
        $totalmoc += $moc[3];  
             
    }
    
    $totalmis = 0;
    
    foreach($dados as $mis){ //insere todas os envios
        
        $totalmis += $mis[4];  
             
    }

    //verificar se foi validado com $val

    $insert2 = $conndb->query("INSERT INTO envios_ic (id, cidade, setor, ic, provisao, oferta, mocambique, missoes, enviado, validado, recebido, dataic) VALUES (NULL, 'salvador', 'ribeira', '".$_COOKIE["setorrs_ic"]."', '".$totalprovisao."', '".$totalofertas."', '".$totalmoc."', '".$totalmis."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', '', '".date('Y-m-d')."')")or die($conndb->error);
        
    echo "Dados salvos no banco de dados.<br>Gerando tabela mensal...";

}else{
    echo "Sem autorização! [ERR005]";
}



?>
