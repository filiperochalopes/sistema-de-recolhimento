<!DOCTYPE html>
<html lang="br">
    <head>
        <title><?php echo $_SERVER['SERVER_ADDR']; ?></title>
        <meta charset="ISO-8859-1"/> 	
    </head>
    <body>

<?php

include "dbconfig.php";

$conndb->query('SET character_set_connection=utf8');
$conndb->query('SET character_set_client=utf8');
$conndb->query('SET character_set_results=utf8');

$mes = $_REQUEST["mes"]; //colocar POST depois
$ano = $_REQUEST["ano"];
$ic = $_REQUEST["ic"];

$query1 = $conndb->query("SELECT * FROM pessoas WHERE ic = $ic ORDER BY nome ASC")or die($hint = "Não identificado pessoas desse grupo caseiro");
$linhasPesquisa = $query1->num_rows;

echo "<script> var lenghtPesquisa = $linhasPesquisa;</script>\n\n";

switch ($mes) {
        case "1":    $nomeMes = "Jan";   break;
        case "2":    $nomeMes = "Fev";   break;
        case "3":    $nomeMes = "Mar";   break;
        case "4":    $nomeMes = "Abr";   break;
        case "5":    $nomeMes = "Mai";   break;
        case "6":    $nomeMes = "Jun";   break;
        case "7":    $nomeMes = "Jul";   break;
        case "8":    $nomeMes = "Ago";   break;
        case "9":    $nomeMes = "Set";   break;
        case "10":   $nomeMes = "Out";   break;
        case "11":   $nomeMes = "Nov";   break;
        case "12":   $nomeMes = "Dez";   break; 
 }

if ($linhasPesquisa !== 0){
    while ($row = $query1->fetch_assoc()){
        $nome[] = [$row['id'], $row['nome']];
    }
}

echo "<script>\n";

if (intval($mes) < 10){
    $mes = "0".$mes;
}

echo "pessoas = {};\n";

for ($i = 0; $i <= $linhasPesquisa-1; $i++) {

//Array nome

    echo "pessoas.pessoa_$i = {};\n";
    echo "pessoas.pessoa_$i.nome = '".$nome[$i][1]."';\n";
    echo "pessoas.pessoa_$i.recolhimento = [];\n";

//----Array data

$query2 = $conndb->query("SELECT * FROM envios_pessoa WHERE datahora LIKE '$ano-$mes-%' AND pessoa = '".$nome[$i][0]."' ORDER BY datahora ASC")or die($hint = "SELECT * FROM envios_pessoa WHERE datahora LIKE '$ano-$mes-%' AND nome = '".$nome[$i]."' ORDER BY datahora ASC");
$linPesquisa2 = $query2->num_rows;
echo "\n\nvar nome_".$i."_lenght = $linPesquisa2;\n";
$x = 0;

		while ($row2 = $query2->fetch_assoc()){
			$data = $row2['datahora'];
			echo "pessoas.pessoa_$i.recolhimento[$x] = [];\n";
			echo "pessoas.pessoa_$i.recolhimento[$x].push('".substr($data, 8, 2)."-".substr($data, 5, 2)."-".substr($data, 0, 4)."');\n";

//--------Array pv-of-o

	$query3 = $conndb->query("SELECT * FROM envios_pessoa WHERE datahora LIKE '$data%' AND pessoa = '".$nome[$i][0]."' ORDER BY datahora ASC");
	$linPesquisa3 = $query3->num_rows;
		while ($row3 = $query3->fetch_assoc()){
			$pv = $row3['provisao'];
			echo "pessoas.pessoa_$i.recolhimento[$x].push(".number_format($pv, 2, ".", "").");\n";
			$of = $row3['oferta'];
			echo "pessoas.pessoa_$i.recolhimento[$x].push(".number_format($of, 2, ".", "").");\n";
			$ou = $row3['missoes']+$row3['mocambique'];
			echo "pessoas.pessoa_$i.recolhimento[$x].push(".number_format($ou, 2, ".", "").");\n";
		}


			$x ++;

		}

	if($i == $linhasPesquisa-1){

$query4 = $conndb->query("SELECT DISTINCT dataic FROM envios_pessoa WHERE datahora LIKE '$ano-$mes-%' ORDER BY dataic ASC");
$linPesquisa4 = $query4->num_rows;
echo "\n\nvar dataLenght = $linPesquisa4;\n";
$d = 0;
echo "\n\nvar data = [];\n";

	while ($row4 = $query4->fetch_assoc()){
		$dataVar = $row4['dataic'];
		echo "data[$d] = '".substr($dataVar, 8, 2)."-".substr($dataVar, 5, 2)."-".substr($dataVar, 0, 4)."';\n";
		$d++;
	}


		echo "</script>";


?>
<style>
    #tabela_mes{
        width:100%;    
    }        
</style>
<canvas id="tabela_mes" width="3508px" height="2480px"></canvas>
<script>

var printCanvas = document.getElementById("tabela_mes");
var context = printCanvas.getContext("2d");

context.lineWidth=3;

//Preenchimento
context.fillStyle="rgb(255,255,255)";
context.fillRect(0,0,3508,2480);

//Contorno
context.beginPath();
context.moveTo(0,0);
context.lineTo(0,2480);
context.lineTo(3508,2480);
context.lineTo(3508,0);
context.lineTo(0,0);

context.strokeStyle="#eee";
context.stroke();

//retangulos none
context.fillStyle="rgb(153,153,153)";

for(x=489; x<2700; x+=533){
context.fillRect(x,1992,206,110);
context.fillRect(x+207,1938,178,57);
context.fillRect(x+207,2047,178,57);
context.fillRect(x+207+176,1938,147,109);
}

//barras horizontais 36
context.beginPath();
for(y=464; y<1938; y+=56){
    context.moveTo(108, y);
    context.lineTo(3406, y);
}

for(y=1938; y<2111; y+=56){
    context.moveTo(108, y);
    context.lineTo(3406, y);
}

context.moveTo(108, 2155);
context.lineTo(3145, 2155);
context.moveTo(108, 2215);
context.lineTo(3145, 2215);
context.moveTo(492, 364);
context.lineTo(3145, 364);
context.moveTo(492, 413);
context.lineTo(3145, 413);

//barras verticais

context.moveTo(109, 310);
context.lineTo(109, 1936);
context.moveTo(197, 310);
context.lineTo(197, 1936);

for(x=492; x<3200; x+=529){
context.moveTo(x, 310);
context.lineTo(x, 1933);
context.moveTo(x, 1940);
context.lineTo(x, 2216);
}

context.moveTo(3405, 300);
context.lineTo(3405, 1925);
context.moveTo(3405, 1929);
context.lineTo(3405, 2093);

context.moveTo(113, 1938);
context.lineTo(113, 2217);

context.strokeStyle="#535353";
context.stroke();

//barras verticais do meio
context.beginPath();
for(x=697; x<3048; x+=531){
context.moveTo(x, 414.5);
context.lineTo(x, 2103);
context.moveTo(x+177, 414.5);
context.lineTo(x+177, 2103);
}

//Retangulos vazios
context.moveTo(76,116);
context.lineTo(76,2383);
context.lineTo(3448,2383);
context.lineTo(3448,116);
context.lineTo(76,116);

context.strokeStyle="#535353";

context.strokeRect(109,150,3298,138);
context.strokeRect(109,310,3296,143);
context.strokeRect(122,2238,1767,61);
context.stroke();

//retangulo sombra
context.fillStyle="rgb(219,219,219)";
context.fillRect(2764+15,2229+15,647,57);

context.fillStyle="rgb(255,255,255)";
context.fillRect(2764,2229,647,57);
context.strokeRect(2764,2229,647,57);

context.closePath();

//TEXTOS

l1 = 190;

context.fillStyle="rgb(0,0,0)";
context.font="italic 50px Times New Roman";
context.textAlign="left";
context.textBaseline="top";
context.fillText("CONTROLE\u0020DE\u0020CONTRIBUI\u00c7\u00d5ES\u0020DO\u0020GRUPO\u0020CASEIRO",126,l1);

context.font="normal 40px Times New Roman";
context.fillText("GC",1450,l1);
context.fillText("AD\u0027S",1830,l1);
context.fillText("M\u00eas",2496,l1);
context.fillText("Ano",2898,l1);

l2 = 322;

context.font="bold 40px Times New Roman";
context.fillText("Primeira\u0020Semana",586,l2);
context.fillText("Segunda\u0020Semana",1120,l2);
context.fillText("Terceira\u0020Semana",1650,l2);
context.fillText("Quarta\u0020Semana",2191,l2);
context.fillText("Quinta\u0020Semana",2724,l2);

l3 = 380;

context.font="bold 35px Times New Roman";
context.fillText("Nr",126,l3);
context.fillText("Nome",287,l3);
context.fillText("Data",541,l3);
context.fillText("Data",1071,l3);
context.fillText("Data",1601,l3);
context.fillText("Data",2131,l3);
context.fillText("Data",2662,l3);
context.fillText("Total",3222,l3);
1075
l4 = 425;

for(x=568; x<2866; x+=531){

context.font="bold 35px Times New Roman";
context.fillText("PV",x,l4);
context.fillText("OF",x+191,l4);
context.font="bold 30px Times New Roman";
context.fillText("Outros",x+325,l4);

}

context.font="bold 35px Times New Roman";
context.fillText("Total de Provis\u00e3o",132,1952);
context.fillText("Total de Oferta",151,2007);
context.fillText("Total de Outros",151,2062);
context.fillText("Total da Semana",141,2117);

context.font="bold 35px Times New Roman";
context.fillText("Ass. do l\u00edder",159,2170);
context.fillText("Esta Planilha \u00e9 de uso exclusivo dos AD\u0027S e L\u00edderes do Grupo Caseiro",136,2252);
context.fillText("Total Geral:",2781,2245);

context.font="bold 50px Times New Roman";
context.fillText("Lembrete:",115,2318);

context.font="normal 40px Times New Roman";
context.fillText("Caro AD, ao final do encontro caseiro, preencha esta planilha e apresente ao l\u00edder do seu grupo juntamente com os envelopes, para a sua concord\u00e2ncia!",406,2325);

//DADOS

context.fillStyle="rgb(70,70,70)";
context.font="normal 35px Monospace";
context.fillText(<?php echo $ic; ?>,1566,l1+1);
context.fillText("Dinho",2049,l1+1);
context.fillText("<?php echo $nomeMes; ?>",2650,l1+1);
context.fillText("<?php echo $ano; ?>",3050,l1+1);

//----DATAS

context.font="normal 40px Monospace";
for(x=0; x<=(dataLenght)-1; x++){
context.fillText(data[x],647+(x*532),l3+1);
}

//----NUMEROS

for(y=0; y<=lenghtPesquisa-1; y++){
context.fillText(y+1,153,490+(y*55));
}

//----NOMES

for(y=0; y<=lenghtPesquisa-1; y++){
context.fillText(eval('pessoas.pessoa_'+y+'.nome'),209,491+(y*55));
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
		for(y=0; y<=(eval('pessoas.pessoa_'+i+'.recolhimento.length'))-1; y++){
			//Achou
			if(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][0]') == data[d]){
                if(typeof eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]') === 'undefined'){
                    eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]') = 0;
                }
                if(typeof eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]') === 'undefined'){
                    eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]') = 0;
                }
                if(typeof eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]') === 'undefined'){
                    eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]') = 0;
                }
			context.fillText(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]').toFixed(2),535+(d*557),480+(i*55));
			context.fillText(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]').toFixed(2),728+(d*557),480+(i*55));
			context.fillText(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]').toFixed(2),902+(d*557),480+(i*55));
			
			//Armazena variaveis de soma
			somaInd = somaInd + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]')) + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]')) + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]'));

			if(d == 0){somaPV1 = somaPV1 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]'));}
			if(d == 1){somaPV2 = somaPV2 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]'));}
			if(d == 2){somaPV3 = somaPV3 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]'));}
			if(d == 3){somaPV4 = somaPV4 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]'));}
			if(d == 4){somaPV5 = somaPV5 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][1]'));}

			if(d == 0){somaOF1 = somaOF1 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]'));}
			if(d == 1){somaOF2 = somaOF2 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]'));}
			if(d == 2){somaOF3 = somaOF3 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]'));}
			if(d == 3){somaOF4 = somaOF4 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]'));}
			if(d == 4){somaOF5 = somaOF5 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][2]'));}

			if(d == 0){somaOU1 = somaOU1 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]'));}
			if(d == 1){somaOU2 = somaOU2 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]'));}
			if(d == 2){somaOU3 = somaOU3 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]'));}
			if(d == 3){somaOU4 = somaOU4 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]'));}
			if(d == 4){somaOU5 = somaOU5 + parseFloat(eval('pessoas.pessoa_'+i+'.recolhimento['+y+'][3]'));}
			break;
			}else{
                context.fillText('-     -             -',535+(d*557),480+(i*55));
            }
		}
	}

context.fillText(somaInd.toFixed(2),3191,483+(i*55));
somaTotal += somaInd;
somaInd = 0;
}

l5 = 1964;

context.fillText(somaPV1.toFixed(2),517+(0*530),l5);
context.fillText(somaPV2.toFixed(2),517+(1*530),l5);
context.fillText(somaPV3.toFixed(2),517+(2*530),l5);
context.fillText(somaPV4.toFixed(2),517+(3*530),l5);
context.fillText(somaPV5.toFixed(2),517+(4*530),l5);
context.fillText((somaPV1+somaPV2+somaPV3+somaPV4+somaPV5).toFixed(2),3169,l5);

l6 = 2021;

context.fillText(somaOF1.toFixed(2),731+(0*530),l6);
context.fillText(somaOF2.toFixed(2),731+(1*530),l6);
context.fillText(somaOF3.toFixed(2),731+(2*530),l6);
context.fillText(somaOF4.toFixed(2),731+(3*530),l6);
context.fillText(somaOF5.toFixed(2),731+(4*530),l6);
context.fillText((somaOF1+somaOF2+somaOF3+somaOF4+somaOF5).toFixed(2),3169,l6);

l7 = 2078;

context.fillText(somaOU1.toFixed(2),909+(0*530),l7);
context.fillText(somaOU2.toFixed(2),909+(1*530),l7);
context.fillText(somaOU3.toFixed(2),909+(2*530),l7);
context.fillText(somaOU4.toFixed(2),909+(3*530),l7);
context.fillText(somaOU5.toFixed(2),909+(4*530),l7);
context.fillText((somaOU1+somaOU2+somaOU3+somaOU4+somaOU5).toFixed(2),3169,l7);

for(z=1; z<=dataLenght; z++){
context.fillText((eval('somaPV'+z)+eval('somaOF'+z)+eval('somaOU'+z)).toFixed(2),582+((z-1)*530),2118);
}

context.font="bold 43px Monospace";
var somaTotal2 = somaPV1+somaPV2+somaPV3+somaPV4+somaPV5+somaOF1+somaOF2+somaOF3+somaOF4+somaOF5+somaOU1+somaOU2+somaOU3+somaOU4+somaOU5;
context.fillText(somaTotal.toFixed(2) ,3070,2238);

console.log(pessoas);
    
var image = printCanvas.toDataURL('image/jpeg', 0.8);  // here is the most important part because if you dont replace you will get a DOM 18 exception.

    sessionStorage.setItem('setorrs_tabela_mes', image);
    
</script>

<?php
	}
}
?>
</body>
</html>
