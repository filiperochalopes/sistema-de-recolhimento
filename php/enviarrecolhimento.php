<html>
    <body>
    
<?php

header('Content-Type: text/html; charset=utf-8');
include "dbconfig.php";
require("../functions.php");

$ic = $_POST["ic"];
$cidade = $_POST["cidade"];
$setor = $_POST["setor"];
$data = date('Y-m-d H:i:s');

$img_tabela_mes = $_POST["img_tabela_mes"];
$img_ficha_dia = $_POST["img_ficha_dia"];

$nomeDestinatario = "Provisão e Oferta";

$destinatarios = 'provisao_oferta@setorrs.com.br';

$usuarioemail = "provisao_oferta@setorrs.com.br";

$nomeRemetente = "AVISO - Recolhimento";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

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
        
$assunto = "RECOLHIMENTO [$ic]";
//$mensagem = "Prezado irmão,<br><br>Segue em anexo as planilhas referentes ao recolhimento da semana do grupo caseiro $ic, cujos líderes $lideres são responsáveis na Igreja em $cidade.<br><br>Saudações<br><br><img src='$img_ficha_dia'><br><br><img src='$img_tabela_mes'><br><br> Responsáveis. <br> $data";
        
$mensagem = "Prezado irmão,<br><br>Segue em anexo as planilhas referentes ao recolhimento da semana do grupo caseiro $ic, cujos líderes $lideres são responsáveis na Igreja em $cidade.<br><br>Saudações<br><br>Responsáveis. <br> $data";
        
        //criar imagens
        $anexo = [];
        
        $img1url = 'tmp'.random_img_name().'.jpg';
        $img2url = 'tmp'.random_img_name().'.jpg';
        
        $image1 = base64_to_jpeg( $img_ficha_dia, '../tmp/'.$img1url );
        $image2 = base64_to_jpeg( $img_tabela_mes, '../tmp/'.$img2url );
        
        array_push($anexo, $img1url, $img2url);
        
        
enviaremail("", $assunto, $mensagem, $anexo);
        
        //unlink($img1url);
        //unlink($img2url);
        
?>
    </body>
</html>
