<!DOCTYPE html>
<html lang="br">
    <head>
        <title><?php echo $_SERVER['SERVER_ADDR']; ?></title> 	
    </head>
    <body>

<?php

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');


$dataic = $_REQUEST["dataic"];
$setor = $_REQUEST["setor"];
$ic = $_REQUEST["ic"];

$query0 = $conndb->query("SELECT * FROM envios_ic WHERE dataic = '".date("Y-m-d")."' ORDER BY enviado DESC LIMIT 0 , 1")or die($hint = "Não identificado envio desse grupo caseiro");
$linhasPesquisa = $query0->num_rows;

echo "<script> var lenghtPesquisa = $linhasPesquisa;</script>\n\n";

echo "<script>\n";

$query = $conndb->query("SELECT * FROM ic_$setor WHERE num = $ic")or die($hint = "O setor não existe [ERR001]");
$num_query = $query->num_rows;

while($row = $query->fetch_assoc()){
    //lider1
    $query2 = $conndb->query("SELECT * FROM pessoas WHERE id = ".$row["lider1"]."")or die($conndb->error);
    while($row2 = $query2->fetch_assoc()){
        //lider2
        if($row["lider2"] != NULL){
            $query3 = $conndb->query("SELECT * FROM pessoas WHERE id = ".$row["lider2"]."")or die($conndb->error);
        }else{
            $query3 = $conndb->query("SELECT * FROM pessoas WHERE id = ".$row["lider1"]."")or die($conndb->error);
            $nomelider2 = "";
        }
        while($row3 = $query3->fetch_assoc()){
            if($row["lider2"] != NULL){
                $nomelider2 = " e ".$row3["nome"];
            }
            $lideres = $row2["nome"].$nomelider2;
        }
    }
}

$queryvalores = $conndb->query("SELECT * FROM envios_ic WHERE ic = $ic AND dataic = '$dataic' ORDER BY enviado DESC LIMIT 0 , 1")or die($hint = "O registro desse dia não foi encontrado [ERR008]");
//echo $queryvalores->num_rows."SELECT * FROM envios_ic WHERE ic = $ic AND dataic = '$dataic' ORDER BY enviado DESC LIMIT 0 , 1";

while($row4 = $queryvalores->fetch_assoc()){
    echo "var provisao = parseFloat('".$row4['provisao']."'), oferta = parseFloat('".$row4['oferta']."'), mocambique = parseFloat('".$row4['mocambique']."'), missoes = parseFloat('".$row4['missoes']."')\n";
}

echo "lideres = '".$lideres."'\n";
echo "setor = '".ucfirst($setor)."'\n";
echo "data = '".substr($dataic, 8, 2)." / ".substr($dataic, 5, 2)." / ".substr($dataic, 0, 4)."'\n";

		echo "</script>";


?>
<style>
    #tabela_mes{
        width:100%;    
    }        
</style>
<canvas id="tabela_mes" width="1736px" height="1200px"></canvas>
<script>

    console.log("Aqui eh da FICHA1");
    
var printCanvas = document.getElementById("tabela_mes");
var context = printCanvas.getContext("2d");

context.lineWidth=4;

//Preenchimento
context.fillStyle="rgb(255,255,255)";
context.fillRect(0,0,1736,1200);


    context.beginPath();
    
    //Preenchimento cinza
    context.fillStyle="#c4c4c4";
    context.fillRect(62,64,1617,62);
    context.fillRect(62,238,1219,74);
    context.fillRect(62,478,406,83);
    context.fillRect(872,478,406,83);
    context.fillRect(62,633,1618,43);
    context.fillRect(62,883,1618,58);
    
    //contornos e linhas por bloco
    
    context.strokeStyle="#eee";
    context.strokeRect(0,0,1736,1200);
    
    context.strokeStyle="#313131";
    
    context.strokeRect(62,64,1617,62);
    
    context.strokeRect(62,133,1617,95);
    
    context.strokeRect(62,238,1617,231);
    context.moveTo(62,313);
    context.lineTo(1680,313);
    context.moveTo(62,370);
    context.lineTo(1680,370);
    
    context.strokeRect(62,478,1617,83);
    context.moveTo(62,633);
    context.lineTo(1680,633);
    context.moveTo(62,675);
    context.lineTo(1680,675);
    context.moveTo(62,730);
    context.lineTo(1680,730);
    context.moveTo(62,782);
    context.lineTo(1680,782);
    context.moveTo(62,834);
    context.lineTo(1680,834);
    
    context.strokeRect(62,576,1617,296);
    context.moveTo(62,941);
    context.lineTo(1680,941);
    
    context.strokeRect(62,884,1617,215);
    context.stroke();
    
    //linhas verticais
    
    context.moveTo(387, 312);
    context.lineTo(387, 469);
    context.moveTo(710, 312);
    context.lineTo(710, 469);
    context.moveTo(1034, 312);
    context.lineTo(1034, 469);
    context.moveTo(1359, 312);
    context.lineTo(1359, 469);
    
    context.moveTo(872, 479);
    context.lineTo(872, 561);  
    
    context.moveTo(469, 633);
    context.lineTo(469, 835);
    context.moveTo(872, 633);
    context.lineTo(872, 835);
    context.moveTo(1278, 633);
    context.lineTo(1278, 835);
    
    context.moveTo(872, 884);
    context.lineTo(872, 1098);    

    context.closePath();

//TEXTOS

    context.fillStyle="#070707";
    context.font="bold 35px Arial";
    context.textAlign="left";
    context.textBaseline="top";
    context.fillText("FICHA\u0020DE\u0020ENTREGA\u0020DE\u0020CONTRIBUI\u00c7\u00d5ES\u0020DA\u0020IGREJA\u0020NA\u0020CASA\u0020PARA\u0020O\u0020DIAC.\u0020SETOR",99,77);

    l1 = 161;

    context.font="normal 37px Arial";
    context.fillText("Igreja na Casa (L\u00EDderes):",92,l1);
    context.fillText("Setor:",1145,l1);

    l2 = 258;

    context.fillText("Contribui\u00E7\u00F5es da Semana",231,l2);
    context.fillText("Data:",1159,l2);

    l3 = 322;
    
    context.font="normal 35px Arial";
    context.fillText("Provis\u00F5es",139,l3);
    context.fillText("Ofertas",481,l3);
    context.fillText("Miss\u00F5es",801,l3);
    context.fillText("Mo\u00E7ambique",1090,l3);
    context.fillText("Total",1476,l3);

    l4 = 500;

    context.font="normal 37px Arial";
    context.fillText("Valor em Esp\u00E9cie:",88,l4);
    context.fillText("Valor em Cheque:",898,l4);
    
    context.font="normal 38px Arial";
    context.fillText("Dados dos Cheques",694,585);

    l6 = 640;

    context.font="normal 28px Arial";
    context.fillText("Nome do Ofertante:",148,l6);
    context.fillText("Data do Cheque:",565,l6);
    context.fillText("N\u00BA do banco e N\u00BA do Cheque:",892,l6);
    context.fillText("Valor:",1446,l6);
    
    context.font="normal 25px Arial";
    context.fillText("Caso haja um cheque com data de emiss\u00E3o anterior a 15 dias de entrega ao diaconato, lembrar-se de indicar o motivo, no verso desta ficha.",95,840);
    
    l8 = 895;
    
    context.font="normal 35px Arial";
    context.fillText("Enviado por (ADS)",305,l8);
    context.fillText("Recebido por (Di\u00E1cono no Setor)",1020,l8);
    
    l9 = 1021;
    
    context.fillStyle="#464646";
    context.font="normal 25px Arial";
    context.fillText("Assinatura leg\u00EDvel",355,l9);
    context.fillText("Assinatura leg\u00EDvel",1190,l9);
    
    context.stroke();
    
    //linha de assinatura
    
    context.beginPath();
    context.lineWidth=2;
    
    context.moveTo(120, 1016);
    context.lineTo(832, 1016);
    context.moveTo(928, 1016);
    context.lineTo(1642, 1016);
    
    context.moveTo(235, 1088);
    context.lineTo(710, 1088);
    context.moveTo(1043, 1088);
    context.lineTo(1520, 1088);
    
    context.stroke();

//DADOS
    
    context.fillStyle="#606060";
    context.font="normal 30px Monospace";
    context.fillText(lideres,525,l1+5);
    context.fillText(setor,1284,l1+5);
    context.fillText(data,1301,261);
    
    ld1 = 400;
    
    context.textAlign="center";
    context.font="normal 45px Monospace";
    context.fillText(provisao.toFixed(2),223,ld1);
    context.fillText(oferta.toFixed(2),544,ld1);
    context.fillText(missoes.toFixed(2),869,ld1);
    context.fillText(mocambique.toFixed(2),1192,ld1);
    context.fillText((provisao+oferta+missoes+mocambique).toFixed(2),1527,ld1);
    
    console.log("Aqui eh da FICHA2");
    
var image = printCanvas.toDataURL('image/jpeg', 0.8);  // here is the most important part because if you dont replace you will get a DOM 18 exception.

    sessionStorage.setItem('setorrs_ficha_dia', image);
    
</script>

</body>
</html>
