<!DOCTYPE html>
<html lang="br">
    <head>
        <title><?php echo $_SERVER['SERVER_ADDR']; ?></title>
        <link rel="stylesheet" href="css/print.css" type="text/css"/>
        <meta charset="ISO-8859-1"/> 	
    </head>
    <body>

<?php

require 'parts/config.php';

$query1 = mysql_query("SELECT * FROM nomes_pv_of ORDER BY nome ASC");
$linhasPesquisa = mysql_num_rows($query1);

$mes = $_POST["mes"];
$ano = $_POST["ano"];
echo "<script> var lenghtPesquisa = $linhasPesquisa;</script>\n\n";

switch ($mes) {
        case "1":    $nomeMes = Jan;   break;
        case "2":    $nomeMes = Fev;   break;
        case "3":    $nomeMes = Mar;   break;
        case "4":    $nomeMes = Abr;   break;
        case "5":    $nomeMes = Mai;   break;
        case "6":    $nomeMes = Jun;   break;
        case "7":    $nomeMes = Jul;   break;
        case "8":    $nomeMes = Ago;   break;
        case "9":    $nomeMes = Set;   break;
        case "10":    $nomeMes = Out;   break;
        case "11":    $nomeMes = Nov;   break;
        case "12":    $nomeMes = Dez;   break; 
 }

if ($linhasPesquisa !== 0){
while ($row = mysql_fetch_array($query1)){
$nome[] = $row['nome'];
}
}

echo "<script>\n";

if (intval($mes) < 10){
$mes = "0".$mes;
}

for ($i = 0; $i <= $linhasPesquisa-1; $i++) {

//Array nome

    echo "nome_$i = '".$nome[$i]."';\n";

//----Array data

$query2 = mysql_query("SELECT * FROM provisao_oferta WHERE data LIKE '$ano-$mes-%' AND nome = '".$nome[$i]."' ORDER BY data ASC");
$linPesquisa2 = mysql_num_rows($query2);
echo "\n\nvar nome_".$i."_lenght = $linPesquisa2;\n";
$x = 0;

		while ($row2 = mysql_fetch_array($query2)){
			$data = $row2['data'];
			echo "nome_".$i."_".$x." = '".substr($data, 8, 2)."-".substr($data, 5, 2)."-".substr($data, 0, 4)."';\n";

//--------Array pv-of-o

	$query3 = mysql_query("SELECT * FROM provisao_oferta WHERE data = '$data' AND nome = '".$nome[$i]."' ORDER BY data ASC");
	$linPesquisa3 = mysql_num_rows($query3);
	$y = 0;
		while ($row3 = mysql_fetch_array($query3)){
			$pv = $row3['provisao'];
			echo "nome_".$i."_".$x."_".$y." = '".number_format($pv, 2, ".", "")."';\n";
			$y ++;
			$of = $row3['oferta'];
			echo "nome_".$i."_".$x."_".$y." = '".number_format($of, 2, ".", "")."';\n";
			$y ++;
			$ou = $row3['outros'];
			echo "nome_".$i."_".$x."_".$y." = '".number_format($ou, 2, ".", "")."';\n";
			$y ++;
		}


			$x ++;

		}

	if($i == $linhasPesquisa-1){

$query4 = mysql_query("SELECT DISTINCT data FROM provisao_oferta WHERE data LIKE '$ano-$mes-%' ORDER BY data ASC");
$linPesquisa4 = mysql_num_rows($query4);
echo "\n\nvar dataLenght = $linPesquisa4;\n";
$d = 0;
echo "\n\nvar data = [];\n";

	while ($row4 = mysql_fetch_array($query4)){
		$dataVar = $row4['data'];
		echo "data[$d] = '".substr($dataVar, 8, 2)."-".substr($dataVar, 5, 2)."-".substr($dataVar, 0, 4)."';\n";
		$d++;
	}


		echo "</script>";


?>

<canvas id="print" width="1169px" height="827px"></canvas>
<script>

var printCanvas = document.getElementById("print");
var context = printCanvas.getContext("2d");

context.lineWidth=1

//Preenchimento
context.fillStyle="rgb(255,255,255)";
context.fillRect(0,0,1169,827);

//Contorno
context.beginPath();
context.moveTo(0,0);
context.lineTo(0,827);
context.lineTo(1169,827);
context.lineTo(1169,0);
context.lineTo(0,0);

context.strokeStyle="#eee";
context.stroke();

//retangulos none
context.fillStyle="rgb(153,153,153)";

for(x=166.5; x<1040; x+=177){
context.fillRect(x,658.5,68,36);
context.fillRect(x+68,640.5,60,18);
context.fillRect(x+67,676.5,60,18);
context.fillRect(x+68+59,640.5,50,36);
}

//barras horizontais
context.beginPath();
for(y=170.5; y<641; y+=18){
context.moveTo(37.5, y);
context.lineTo(1136.5, y);
}

for(y=640.5; y<698; y+=18){
context.moveTo(37.5, y);
context.lineTo(1136.5, y);
}

context.moveTo(37.5, 712.5);
context.lineTo(1051.5, 712.5);
context.moveTo(37.5, 730.5);
context.lineTo(1051.5, 730.5);
context.moveTo(166.5, 119.5);
context.lineTo(1051.5, 119.5);
context.moveTo(166.5, 137.5);
context.lineTo(1051.5, 137.5);

//barras verticais

context.moveTo(37.5, 101.5);
context.lineTo(37.5, 638.5);
context.moveTo(67.5, 101.5);
context.lineTo(67.5, 638.5);
context.moveTo(166.5, 101.5);
context.lineTo(166.5, 638.5);

for(x=166.5; x<1055; x+=177){
context.moveTo(x, 101.5);
context.lineTo(x, 638.5);
}

for(x=166.5; x<1055; x+=177){
context.moveTo(x, 640.5);
context.lineTo(x, 730.5);
}

context.moveTo(1136.5, 101.5);
context.lineTo(1136.5, 638.5);

context.moveTo(37.5, 640.5);
context.lineTo(37.5, 730.5);
context.moveTo(1136.5, 640.5);
context.lineTo(1136.5, 694.5);

context.strokeStyle="#535353";
context.stroke();

//barras verticais do meio
context.beginPath();
for(x=234.5; x<1055; x+=177){
context.moveTo(x, 137.5);
context.lineTo(x, 694.5);
}

for(x=293.5; x<1055; x+=177){
context.moveTo(x, 137.5);
context.lineTo(x, 694.5);
}

//Retangulos vazios
context.moveTo(26.5,36.5);
context.lineTo(26.5,791.5);
context.lineTo(1149.5,791.5);
context.lineTo(1149.5,36.5);
context.lineTo(26.5,36.5);

context.strokeStyle="#535353";

context.strokeRect(37.5,47.5,1099,46);
context.strokeRect(37.5,101.5,1099,52);
context.strokeRect(39.5,742.5,591,21);
context.stroke();

//retangulo sombra
context.fillStyle="rgb(219,219,219)";
context.fillRect(925.5,746.5,216,21);

context.fillStyle="rgb(255,255,255)";
context.fillRect(921.5,742.5,216,21);
context.strokeRect(921.5,742.5,216,21);

context.closePath();

//TEXTOS

l1 = 63;

context.fillStyle="rgb(0,0,0)";
context.font="italic 17px Times New Roman";
context.textAlign="left";
context.textBaseline="top";
context.fillText("CONTROLE\u0020DE\u0020CONTRIBUI\u00c7\u00d5ES\u0020DO\u0020GRUPO\u0020CASEIRO",43,l1);

context.font="normal 17px Times New Roman";
context.fillText("GC",495,l1);
context.fillText("AD\u0027S",639,l1);
context.fillText("M\u00eas",894,l1);
context.fillText("Ano",1001,l1);

l2 = 103;

context.font="bold 15px Times New Roman";
context.fillText("Primeira\u0020Semana",200,l2);
context.fillText("Segunda\u0020Semana",376,l2);
context.fillText("Terceira\u0020Semana",553,l2);
context.fillText("Quarta\u0020Semana",734,l2);
context.fillText("Quinta\u0020Semana",912,l2);

l3 = 121;

context.font="bold 14px Times New Roman";
context.fillText("Nr",44,l3);
context.fillText("Nome",98,l3);
context.fillText("Data",183,l3);
context.fillText("Data",359,l3);
context.fillText("Data",536,l3);
context.fillText("Data",711,l3);
context.fillText("Data",890,l3);
context.fillText("Total",1075,l3);

l4 = 139;

for(x=192.5; x<1044; x+=177){

context.font="bold 14px Times New Roman";
context.fillText("PV",x,l4);
context.fillText("OF",x+63,l4);
context.font="bold 13px Times New Roman";
context.fillText("Outros",x+106,l4);

}

context.font="bold 15px Times New Roman";
context.fillText("Total de Provis\u00e3o",44,642);
context.fillText("Total de Oferta",50,660);
context.fillText("Total de Outros",50,678);
context.fillText("Total da Semana",46,696);

context.font="bold 16px Times New Roman";
context.fillText("Ass. do l\u00edder",58,714);
context.fillText("Esta Planilha \u00e9 de uso exclusivo dos AD\u0027S e L\u00edderes do Grupo Caseiro",45,745);
context.fillText("Total Geral:",926,745);

context.font="bold 18px Times New Roman";
context.fillText("Lembrete:",40,769);

context.font="normal 16px Times New Roman";
context.fillText("Caro AD, ao final do encontro caseiro, preencha esta planilha e apresente ao l\u00edder do seu grupo juntamente com os envelopes, para a sua concord\u00e2ncia!",126,771);

//DADOS

context.fillStyle="rgb(70,70,70)";
context.font="normal 14px Monospace";
context.fillText("01",530,l1+1);
context.fillText("Dinho",685,l1+1);
context.fillText("<?php echo $nomeMes; ?>",938,l1+1);
context.fillText("<?php echo $ano; ?>",1041,l1+1);

//----DATAS

context.font="normal 12px Monospace";
for(x=0; x<=(dataLenght)-1; x++){
context.fillText(data[x],217+(x*177),l3+1);
}

//----NUMEROS

for(y=0; y<=lenghtPesquisa-1; y++){
context.fillText(y+1,45,156+(y*18));
}

//----NOMES

for(y=0; y<=lenghtPesquisa-1; y++){
context.fillText(eval('nome_'+y),72,156+(y*18));
}

//---------PV, OF, OUTROS ETC...

context.textAlign="center";

var somaPV1 = 0;
var somaPV2 = 0;
var somaPV3 = 0;
var somaPV4 = 0;
var somaPV5 = 0;

var somaOF1 = 0;
var somaOF2 = 0;
var somaOF3 = 0;
var somaOF4 = 0;
var somaOF5 = 0;

var somaOU1 = 0;
var somaOU2 = 0;
var somaOU3 = 0;
var somaOU4 = 0;
var somaOU5 = 0;

var somaInd = 0;
var somaTotal = 0;

//i é o id do nome
for(i=0; i<=lenghtPesquisa-1; i++){
	//d é o id da data
	for(d=0; d<=dataLenght-1; d++){
		//Verifica se tem igual
		for(y=0; y<=(eval('nome_'+i+'_lenght'))-1; y++){
			//Achou
			if(eval('nome_'+i+'_'+y) == data[d]){
			context.fillText(eval('nome_'+i+'_'+y+'_0'),200+(d*177),156+(i*18));
			context.fillText(eval('nome_'+i+'_'+y+'_1'),264+(d*177),156+(i*18));
			context.fillText(eval('nome_'+i+'_'+y+'_2'),318+(d*177),156+(i*18));
			
			//Armazena variaveis de soma
			somaInd = somaInd + parseFloat(eval('nome_'+i+'_'+y+'_0')) + parseFloat(eval('nome_'+i+'_'+y+'_1')) + parseFloat(eval('nome_'+i+'_'+y+'_2'));

			if(d == 0){somaPV1 = somaPV1 + parseFloat(eval('nome_'+i+'_'+y+'_0'));}
			if(d == 1){somaPV2 = somaPV2 + parseFloat(eval('nome_'+i+'_'+y+'_0'));}
			if(d == 2){somaPV3 = somaPV3 + parseFloat(eval('nome_'+i+'_'+y+'_0'));}
			if(d == 3){somaPV4 = somaPV4 + parseFloat(eval('nome_'+i+'_'+y+'_0'));}
			if(d == 4){somaPV5 = somaPV5 + parseFloat(eval('nome_'+i+'_'+y+'_0'));}

			if(d == 0){somaOF1 = somaOF1 + parseFloat(eval('nome_'+i+'_'+y+'_1'));}
			if(d == 1){somaOF2 = somaOF2 + parseFloat(eval('nome_'+i+'_'+y+'_1'));}
			if(d == 2){somaOF3 = somaOF3 + parseFloat(eval('nome_'+i+'_'+y+'_1'));}
			if(d == 3){somaOF4 = somaOF4 + parseFloat(eval('nome_'+i+'_'+y+'_1'));}
			if(d == 4){somaOF5 = somaOF5 + parseFloat(eval('nome_'+i+'_'+y+'_1'));}

			if(d == 0){somaOU1 = somaOU1 + parseFloat(eval('nome_'+i+'_'+y+'_2'));}
			if(d == 1){somaOU2 = somaOU2 + parseFloat(eval('nome_'+i+'_'+y+'_2'));}
			if(d == 2){somaOU3 = somaOU3 + parseFloat(eval('nome_'+i+'_'+y+'_2'));}
			if(d == 3){somaOU4 = somaOU4 + parseFloat(eval('nome_'+i+'_'+y+'_2'));}
			if(d == 4){somaOU5 = somaOU5 + parseFloat(eval('nome_'+i+'_'+y+'_2'));}
			break;
			}
		}
	}

context.fillText(somaInd.toFixed(2),1093,156+(i*18));
somaTotal += somaInd;
somaInd = 0;
}

l5 = 644;

context.fillText(somaPV1.toFixed(2),200+(0*177),l5);
context.fillText(somaPV2.toFixed(2),200+(1*177),l5);
context.fillText(somaPV3.toFixed(2),200+(2*177),l5);
context.fillText(somaPV4.toFixed(2),200+(3*177),l5);
context.fillText(somaPV5.toFixed(2),200+(4*177),l5);
context.fillText((somaPV1+somaPV2+somaPV3+somaPV4+somaPV5).toFixed(2),1093,l5);

l6 = 662;

context.fillText(somaOF1.toFixed(2),263+(0*177),l6);
context.fillText(somaOF2.toFixed(2),263+(1*177),l6);
context.fillText(somaOF3.toFixed(2),263+(2*177),l6);
context.fillText(somaOF4.toFixed(2),263+(3*177),l6);
context.fillText(somaOF5.toFixed(2),263+(4*177),l6);
context.fillText((somaOF1+somaOF2+somaOF3+somaOF4+somaOF5).toFixed(2),1093,l6);

l7 = 680;

context.fillText(somaOU1.toFixed(2),318+(0*177),l7);
context.fillText(somaOU2.toFixed(2),318+(1*177),l7);
context.fillText(somaOU3.toFixed(2),318+(2*177),l7);
context.fillText(somaOU4.toFixed(2),318+(3*177),l7);
context.fillText(somaOU5.toFixed(2),318+(4*177),l7);
context.fillText((somaOU1+somaOU2+somaOU3+somaOU4+somaOU5).toFixed(2),1093,l7);

for(z=1; z<=dataLenght; z++){
context.fillText((eval('somaPV'+z)+eval('somaOF'+z)+eval('somaOU'+z)).toFixed(2),254+((z-1)*177),697);
}

context.font="bold 13px Monospace";
var somaTotal2 = somaPV1+somaPV2+somaPV3+somaPV4+somaPV5+somaOF1+somaOF2+somaOF3+somaOF4+somaOF5+somaOU1+somaOU2+somaOU3+somaOU4+somaOU5;
context.fillText(somaTotal.toFixed(2) ,1093,746);


</script>

<?php
	}
}
?>
</body>
</html>
