<!DOCTYPE html>
<!--<html lang="br" manifest="demo.appcache">-->
    <meta charset="utf-8"/>
    <head>
        <title>Filipe 3D - Rollpage</title>
        <meta name="description" content="Filipe 3D - Site em Construção" />
        <meta name="mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="msapplication-TileColor" content="#000"/>
        <meta name="msapplication-TileImage" content="img/icon/win_196x196.png"/>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="apple-touch-icon" href="img/icon/196x196.png" sizes="196x196"/>
        <link rel="apple-touch-startup-image" href="img/starup.png" sizes="196x196"/>
        <link rel="shortcut icon" href="img/icon/196x196.png" sizes="196x196"/>
        <link rel="stylesheet" href="css/normalize.css" type="text/css"/>
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />

        <title>Provis&atilde;o e Oferta</title>
        <meta charset="uft-8"/>
        <link rel="stylesheet" href="css/main.css" type="text/css"/>
        <script src="js/modernizr.min.js"></script>
	<script>
	function showHint(stri) {
    if (stri.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "parts/ajax_query_hint.php?q=" + stri, true);
        xmlhttp.send();
    }

}

	function showButton(str) {
    if (str.length == 0) {
        document.getElementById("button").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("button").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "parts/ajax_query_cadastro.php?qu=" + str, true);
        xmlhttp.send();
    }
}
	
	function pag_poupup(nome){
document.getElementById("nome_pag").value=nome;
document.getElementById("pv_of").style.display = "block";
document.getElementById("txtHint").style.display = "none";
}

	function changeClassM(obj){
document.getElementsByClassName("m_selected")[0].className = "m";
obj.className = "m_selected";
}

	function changeClassA(obj){
document.getElementsByClassName("a_selected")[0].className = "m";
obj.className = "a_selected";
}

</script>
    </head>
    <body>
<?php

$add = $_GET["add"];
$edit = $_GET["edit"];
$pag = $_GET["pag"];
$cad = $_GET["cad"];

$name_new = $_POST["name_new"];

$nome_pag = $_POST["nome_pag"];
$provisao_pag = $_POST["provisao_pag"];
$oferta_pag = $_POST["oferta_pag"];
$outros_pag = $_POST["outros_pag"];

if($add=="y"){
#Função de adicionar pessoa
}


if($edit=="y"){
#Função de editar alguem
}


if($pag=="y"){

$data = date('Y-m-d');

require 'parts/config.php';

$provisao_pag = number_format($provisao_pag, 2, ".", "");
$oferta_pag = number_format($oferta_pag, 2, ".", "");
$outros_pag = number_format($outros_pag, 2, ".", "");

$query1 = mysql_query("INSERT INTO provisao_oferta (data, nome, provisao, oferta, outros) VALUES ('$data', '$nome_pag', '$provisao_pag', '$oferta_pag', '$outros_pag');")or die("Error");
echo "<center><p style='color:#66c766; margin:20px; text-shadow:none;'>Registro efetuado com sucesso</p></center>";
$pag = "";

}

if($cad=="y"){

require 'parts/config.php';
$query1 = mysql_query("INSERT INTO nomes_pv_of (nome) VALUES ('$name_new');")or die("Error");
echo "<center><p style='color:#66c766; margin:20px; text-shadow:none;'>Cadastro efetuado com sucesso</p></center>";

}

?>

<section id="pv_of_nome">
<header>
<h1>Provis&atilde;o e Oferta:</h1>
</header>

<form name="pv_of_nome" method="post" action="index.php?add=y">

<div><span>Nome:</span><input type="text" name="nome1_pag" class="input_text" onkeyup="showHint(this.value)"/></div>

</form>
<ul id="txtHint"></ul>

<section id="pv_of">
<form name="pv_of" method="post" action="index.php?pag=y">

<div><span>Nome:</span><input type="text" id="nome_pag" name="nome_pag" class="input_text" style="display:none"/></div>
<div><span>Provis&atilde;o:</span><input type="text" name="provisao_pag" class="input_text"/></div>
<div><span>Oferta:</span><input type="text" name="oferta_pag" class="input_text"/></div>
<div><span>Outros:</span><input type="text" name="outros_pag" class="input_text"/></div>
<input type="submit" value="Pagar"><br/>

</form>
</section>

</section>

<section id="cadastro">
<header>
<h1>Cadastrar pessoas:</h1>
</header>

<form name="cadastrar_pessoa" method="post" action="index.php?cad=y">

<div><span>Nome:</span><input type="text" name="name_new" class="input_text" onkeyup="showButton(this.value)"/></div>
<div id="button"><input type="submit" value="Cadastrar" disabled /><br/></div>

</form>

</section>

<section id="edit">
<header>
<h1>Editar cadastro:</h1>
</header>

<form name="editar_cadastro" method="post" action="index.php?edit=y">

</form>
</section>

<section>
<header>
<h1>Consulta:</h1>
</header>


<form name="consulta" action="print.php" method="POST">
<input type="text" id="mesC" name="mes" class="input_text" style="display:none" value="<?php echo date(n); ?>"/>
<input type="text" id="anoC" name="ano" class="input_text" style="display:none" value="<?php echo date(Y); ?>"/>
<?php

echo "<div style='margin:5%'>";
for($a=1; $a<=12; $a++){
if($a == date(n)){
echo "<div id='m$a' class='m_selected' onClick='document.getElementById(\"mesC\").value=\"$a\"; changeClassM(this)'>$a</div>\n";
}else{
echo "<div id='m$a' class='m' onClick='document.getElementById(\"mesC\").value=\"$a\"; changeClassM(this)'>$a</div>\n";
}
}
echo "<br/><br/><br/><br/><br/><br/></div>";

echo "<div style='margin:5%'>";
for($a=date(Y)-3; $a<=date(Y); $a++){
if($a == date(Y)){
echo "<div id='a$a' class='a_selected' onClick='document.getElementById(\"anoC\").value=\"$a\"; changeClassA(this)'>$a</div>\n";
}else{
echo "<div id='a$a' class='a' onClick='document.getElementById(\"anoC\").value=\"$a\"; changeClassA(this)'>$a</div>\n";
}
}
echo "<br/><br/><br/><br/></div>";

?>
<div>
<span onClick="document.consulta.submit()" class="full_span_link">Consultar</span>
<br/><br/>
</div>
</form>

</section>

    </body>
    
</html>
