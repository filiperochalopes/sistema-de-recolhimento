var cidade = "salvador",
    ic = 0,
    recolhimentos = [],
    r_index = 0;

datahoje = new Date();
var meshoje = datahoje.getMonth() + 1; //months from 1-12
if (meshoje < 10) { meshoje = '0' + meshoje; }
var diahoje = datahoje.getDate();
var anohoje = datahoje.getFullYear();
var dataPADRAOhoje = anohoje+"-"+meshoje+"-"+diahoje;

$(document).ready( function(){
    
    /* ---------------------- SENHA ---------------------- */
    
    $("#pass-number").keyup( function(){
        if($(this).val().length == 4){
            $.ajax({
                type: "POST",
                url: "php/verificasenha.php",
                data: { 'id': $(this).parent().find("#pass-id").val(), 'num': $(this).val() },
                beforeSend: function(){
                    $(".blackpage").fadeIn(100).find(".carregando").addClass("on");
                },
                success: function(result){
                    $(".blackpage").fadeOut(50).find(".carregando").removeClass("on");
                    if(result.indexOf('Senha') > -1){
                        $("#mensagemsenha").html(result);
                    }else{
                        sessionStorage.setItem("setorrs_pvof_nome", result);
                        location.reload();
                    }
                }
            });
        }
    });
    
    /* ---------------------- ABERTURA ---------------------- */
    
    $(".totalblackpage").find("div").html("Olá "+nomeusuario).addClass("anim");
    $(".totalblackpage").delay(1200).fadeOut(300);
    /*$(".totalblackpage").hide();
    $("#teste").append("Olá "+nomeusuario);*/
    
    /* ---------------------- MENU MOBILE ---------------------- */
    
    $("#header_menu .menu").click( function(){
        if($(this).hasClass("open")){
           $(this).css({backgroundPosition: "-20px 50%"});
           $(this).parent().css({ width: "200px"}).find("nav ul").delay(300).hide();
           $(this).parent().find($("nav ul li").get().reverse()).each(function( i ) {
               $(this).stop().delay(50*i).transition({
                    transform: 'translateX(-100%)'
                });
            });
            $(this).removeClass("open");
       }else{
           $(this).css({backgroundPosition: "50% 50%"});
           $(this).parent().css({ width: "95%"}).find("nav ul").css({display: "block"});
           $(this).parent().find("nav ul li").css({transform: "translateX(-100%)"});
           $(this).parent().find("nav ul li").each(function( i ) {
               $(this).stop().delay(100*i).transition({
                    transform: 'translateX(0px)'
                });
            });
           $(this).addClass("open");
       }
    });
    
    /* --------------------- AVISO --------------------- */
    
    var intervaloaviso;
    
    function aviso(type, text, interval){
        //type append or text or html
        clearInterval(intervaloaviso);
        $("#prompt_envio").show();
        
        if(type == "text"){
            $("#prompt_envio").text(text);
        }else if(type == "html"){
            $("#prompt_envio").html(text);   
        }
        
        if(interval == true){
            intervaloaviso = setInterval(function(){ $("#prompt_envio").hide() }, 3000);
        }
    }
    
    var intervaloreload;
    function reloadpage(time){
        clearInterval(intervaloreload);
        intervaloreload = setInterval(function(){ location.reload(); }, time);       
    }
    
    /* --------------------- HINT --------------------- */
    
    function showHint(str, id, id_input) {
        
        document.getElementById(id).style.display="block";
        $("#"+id).html("<div class='carregando on'></div>");
        
        if (str.length == 0) {
            document.getElementById(id).innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(id).innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "php/ajax_hint.php?q="+str+"&id_input="+id_input+"&id_change="+id, true);
            xmlhttp.send();
        }
        
    }
    
    $("#setor").keyup( function(){
        showHint($("#setor").val(), "hintSetor", "setor");
    }).blur( function(){
        setTimeout(function(){ $("#verificasetor").click() }, 50);
    });
    
    $("#pessoa").keyup( function(){
        showHint($("#pessoa").val(), "hintPessoa", "pessoa");
    }).blur( function(){
        setTimeout(function(){ $("#verificapessoa").click() }, 50);
    });
    
    /* --------------------- 2. MOSTRA ICs --------------------- */
    
    function showICs(setor){
        $.ajax({ url: "php/ajax_ics.php?setor="+setor,
                beforeSend: function(){
                    $("#showics").parent().find(".carregando").addClass("on");
                },
                success: function(result){
                    if(result.indexOf('ERR001') > -1){
                        $("#hintSetor").html("Este setor não existe");
                        $("#showics").parent().find(".carregando").removeClass("on");
                    }else{
                        $("#setor").parent().parent().parent().find(".cortina").fadeIn(100);
                        $.ajax({ url: "php/ajax_ics.php?setor="+setor+"&ics=1",
                                beforeSend: function(){
                                    $("#sec_2 .cortina").fadeOut(50);
                                    $("#hintSetor").html("");
                                    $("#sec_2 .carregando").addClass("on");
                                    ancora("sec_2");
                                },
                                success: function(result1){
                                    $("#showics").html(result1);
                                    $("#showics").parent().find(".carregando").removeClass("on");
                                    $("#showics").fadeIn(200);
                                }
                               });
                    }
                }
               });
    }
    
    $("#verificasetor").click( function(){
        showICs($(this).parent().find("input").val());
    });
    
    /* --------------------- 3. MOSTRA REGISTRO --------------------- */
    
    function showPVOF(usu){
        $.ajax({
            url: "php/ajax_procurausuario.php?usuario="+usu,
            beforeSend: function(){
                $(".blackpage").fadeIn(100).find(".carregando").addClass("on");
            },
            success: function(result){
                $(".blackpage").fadeIn(100).find(".carregando").removeClass("on");
                $("#pvofform input").val("");
                $("#id_usuario").val(result);
                $("#pvofform").fadeIn(150);
            }
        });
    }
    
    function arrayRecJS(num, pv, of, moc, mis){
        if(pv == ""){pv = 0}
        if(of == ""){of = 0}
        if(moc == ""){moc = 0}
        if(mis == ""){mis = 0}
        recolhimentos[r_index] = [num, parseFloat(pv).toFixed(2), parseFloat(of).toFixed(2), parseFloat(moc).toFixed(2), parseFloat(mis).toFixed(2)];
        console.log(recolhimentos);
        $(".blackpage").fadeOut(100).find(".carregando").removeClass("on");
        $("#pvofform").fadeOut(100);
        $("#envios_concluidos").prop('disabled', false);
        $("#pessoa").val("");
        r_index++;
    }
    
    function saveRecPHP(){
        $.ajax({
            type: "POST",
            url: "php/ajax_add_json.php",
            data: { 'array': JSON.stringify(recolhimentos) },
            beforeSend: function(){
                $("#pvofform").fadeOut(100);
                $("#envios_concluidos").parent().find(".carregando").addClass("on");
            },
            success: function(){
                $("#envios_concluidos").parent().find(".carregando").removeClass("on");
                $("#sec_4").val("");
                $("#sec_3 .cortina").fadeIn(100);
                $("#sec_4 .cortina").fadeOut(50);
                $("#sec_4 .off").fadeIn(100);
                $("#sec_4 span.small").css({display: 'inline-block'});
                ancora("sec_4");
                
                $.getJSON( "js/"+sessionStorage.getItem("setorrs_ic")+".json", function( data ) {
                    var tabela = "<table><tr><td>NOME</td><td>PROV</td><td>OFER</td><td>MCBQ</td><td>MISS</td></tr>";
                    $.each(data, function( index, value ) {
                        tabela += "<tr>";
                        $.each(value, function( index1, value1 ) {
                            if(index1 == 0){
                                $.ajax({
                                    dataType: "json",
                                    url: "js/pessoas.json",
                                    async: false,
                                    success: function(data2){
                                        nome_pessoa = data2[0][value1];
                                        tabela += "<td>"+nome_pessoa.substr(0, 12)+"</td>"; 
                                    }
                                });
                            }else{
                                tabela += "<td>"+value[index1]+"</td>";  
                            }
                        });
                        tabela += "</tr>";
                    });
                    tabela += "</table>";
                    $("#preview").html(tabela);
                });
            }
        });
    }
    
    $("#showics").change( function(){
        ic = $(this).val();
        $("#sec_2").find(".cortina").fadeIn(100);
        $("#sec_3 .cortina").fadeOut(50);
        $("#sec_3").delay(70).find(".part1").fadeIn(200);
        ancora("sec_3");
        console.log(ic);
        document.cookie = "setorrs_ic="+ic;
        sessionStorage.setItem('setorrs_ic', ic);
    });
    
    $("#houveencontro").click( function(){      
        $("#sec_3").delay(70).find(".part1").fadeOut(50).delay(50).parent().find(".part2").fadeIn(100);
    });
    
    $("#naoencontro").click( function(){
        console.log("naoencontro");
        $.ajax({
            type: "POST",
            url: "php/naohouveencontro.php", //faz imagem
            data: { 'ic': sessionStorage.getItem('setorrs_ic'), 'cidade': cidade, 'setor': $("#setor").val() },
            beforeSend: function(){
                aviso("html", "<i class='fas fa-spinner spinner'></i>", false);
            },
            success: function(data){
                aviso("text", "Eles foram avisados de que não houve encontro. Obrigado!", true);
            }
        });
    });
    
    $("#naorecolhimento").click( function(){
        console.log("naorecolhimento");
        $.ajax({
            type: "POST",
            url: "php/naohouverecolhimento.php", //faz imagem
            data: { 'ic': sessionStorage.getItem('setorrs_ic'), 'cidade': cidade, 'setor': $("#setor").val() },
            beforeSend: function(){
                aviso("html", "<i class='fas fa-spinner spinner'></i>", false);
            },
            success: function(data){
                aviso("text", "Eles foram avisados de que não houve recolhimento. Obrigado!", true);
                reloadpage(3000);
            }
        });
    });
    
    
    
    $("#hintPessoa").click(function(){
        showPVOF($(this).parent().find("input").val());
    });
    
    $("#addEvento").click( function(){
        form = $(this).parent();
        arrayRecJS(form.find("#id_usuario").val(), form.find("#provisao").val(), form.find("#oferta").val(), form.find("#mocambique").val(), form.find("#missoes").val());
    });
    
    $("#envios_concluidos").click(function(){
        saveRecPHP();
    });
    
    /* --------------------- 4. ENVIO --------------------- */
    
    function senhalider(){
        $.ajax({
            type: "POST",
            url: "php/ajax_add_json.php",
            data: { 'array': JSON.stringify(recolhimentos) },
            beforeSend: function(){
                $("#pvofform").fadeOut(100);
                $("#envios_concluidos").parent().find(".carregando").addClass("on");
            },
            success: function(){
                $("#envios_concluidos").parent().find(".carregando").removeClass("on");
                $("#sec_4").val("");
                $("#sec_3 .cortina").fadeIn(100);
                $("#sec_4 .cortina").fadeOut(50);
                $("#sec_4 .off").fadeIn(100);
                $("#sec_4 span.small").css({display: 'inline-block'});
                ancora("sec_4");
                
                $.getJSON( "js/"+sessionStorage.getItem("setorrs_ic")+".json", function( data ) {
                    var tabela = "<table><tr><td>NOME</td><td>PROV</td><td>OFER</td><td>MCBQ</td><td>MISS</td></tr>";
                    $.each(data, function( index, value ) {
                        tabela += "<tr>";
                        $.each(value, function( index1, value1 ) {
                            if(index1 == 0){
                                $.ajax({
                                    dataType: "json",
                                    url: "js/pessoas.json",
                                    async: false,
                                    success: function(data2){
                                        nome_pessoa = data2[0][value1];
                                        console.log(nome_pessoa);
                                        console.log("PRIMEIRO");
                                        tabela += "<td>"+nome_pessoa.substr(0, 12)+"</td>"; 
                                    }
                                });
                            }else{
                                tabela += "<td>"+value[index1]+"</td>";
                                console.log("depois"+index1);    
                            }
                        });
                        tabela += "</tr>";
                    });
                    tabela += "</table>";
                    console.log(data, tabela);
                    $("#preview").html(tabela);
                });
            }
        });
    }
    
    $("#pass-number-lider").keyup( function(){
        if($(this).val().length == 4){
            $.ajax({
                type: "POST",
                url: "php/verificasenhalider.php", //responde senha confirmada... Enviando.
                data: { 'id': $(this).parent().find("#pass-id").val(), 'num': $(this).val() },
                beforeSend: function(){
                    $(".blackpage").fadeIn(100).find(".carregando").addClass("on");
                },
                success: function(result){
                    $(".blackpage").fadeOut(50).find(".carregando").removeClass("on");
                    if(result.indexOf('ERR004') > -1){ //se der errado
                        $("#mensagemsenha").removeClass("small").html(result);
                    }else{//se der certo
                        $("#senha_master.lider").fadeOut(100);
                        $(".totalblackpage div").html(result).removeClass("anim");
                        //ESTAVA DANDO ERRO setTimeout($(".totalblackpage div").addClass("anim").append("<br><br><br><br><div class='carregando on'></div>") ,50);
                        
                        //agora salva as coisas
                        saveall();
                    }
                }
            });
        }
    });
    
    function saveall(){
        console.log(recolhimentos);
        console.log("Salvando tudo.");
        $("#prompt_envio").fadeIn().html("").append("Salvando tudo...<br>");
        $("#itens_carregados").fadeIn();
        
        $.ajax({
            type: "POST",
            url: "php/saveall.php",
            data: { 'dados': JSON.stringify(recolhimentos) },
            success: function(result){
                $("#prompt_envio").fadeIn().append("Gerando ficha do dia<br>");
                console.log("Gerando ficha do dia");
                if(result.indexOf('ERR005') > -1){ //se der errado
                    $("#mensagemsenha").removeClass("small").html(result);
                }else{//se der certo continua
                    $("#itens_carregados").html(result);
                    $(".totalblackpage div").html("Gerando ficha do dia...");
                }
            }
        });
        
        $.ajax({
            type: "POST",
            url: "php/ficha_dia.php",
            data: { 'dataic': dataPADRAOhoje, 'setor': 'ribeira', 'ic': sessionStorage.getItem('setorrs_ic') },
            success: function(result3){
                $("#prompt_envio").append("Gerando tabela do mês<br>");
                console.log("Gerando tabela do mês");
                $("#itens_carregados").html(result3);
                $(".totalblackpage div").html("Gerando tabela mensal...");
            }
        });
        
        $.ajax({
            type: "POST",
            url: "php/tabela_mes.php", //faz imagem
            data: { 'mes': new Date().getMonth()+1, 'ano': new Date().getFullYear(), 'ic': sessionStorage.getItem('setorrs_ic') },
            success: function(result1){
                $("#prompt_envio").append("Enviando email...<br>");
                console.log("Enviando email");
                if(result1.indexOf('ERR006') > -1){ //se der errado
                    $("#mensagemsenha").removeClass("small").html(result1);
                }else{//se der certo
                    $("#itens_carregados").html(result1);
                    $(".totalblackpage div").html("Enviando email...");
                }
            }
        });
        
        var verificaimagens = setInterval(function(){ 
            
            if (sessionStorage.getItem("setorrs_ficha_dia") === null || sessionStorage.getItem("setorrs_tabela_mes") === null)    {
                console.log("Carregando imagens...");
            }else{
                clearInterval(verificaimagens);
                $.ajax({
                    type: "POST",
                    url: "php/enviarrecolhimento.php", //faz imagem
                    data: { 'ic': sessionStorage.getItem('setorrs_ic'), 'cidade': 'salvador', 'setor': 'ribeira', 'img_tabela_mes': sessionStorage.getItem('setorrs_tabela_mes'), 'img_ficha_dia': sessionStorage.getItem('setorrs_ficha_dia')},
                    success: function(result2){
                        $("#prompt_envio").append("Tudo OK. Enviado.<br>");
                        $(".blackpage").fadeOut(50).find(".carregando").removeClass("on");
                        if(result2.indexOf('ERR006') > -1){ //se der errado
                            $("#mensagemsenha").removeClass("small").html(result2);
                        }else{//se der certo
                            sessionStorage.removeItem('setorrs_ficha_dia');
                            sessionStorage.removeItem('setorrs_tabela_mes');
                            sessionStorage.removeItem('setorrs_ic');
                            $(".totalblackpage div").html(result2).removeClass("anim");
                            //DEU ERRO PRA QUE ISSO? setTimeout($(".totalblackpage div").addClass("anim") ,50);
                        }
                    }
                });
            }
                                                     
        }, 1000)
    }
    
    $("#venviar").click(function(){
        $(".totalblackpage").fadeIn(100).find("div").html("");
        $(".totalblackpage .fechar").removeClass("off");
        $("#senha_master.lider").css({display: "block", position: "fixed"});
    });
    
    $("#nvenviar").click(function(){
        $.post( "php/enviarrecolhimento.php", { ic: sessionStorage.getItem('setorrs_ic'), cidade: cidade, setor: $("#setor").val()} ).done( function(data){
            console.log(data);
        });
    });
    
    $(".totalblackpage .fechar").click(function(){
        $(this).parent().fadeOut(50);
        $("#pessoaform").fadeOut(50);
    });
    
    /* --------------------- ADICIONAR PESSOA --------------------- */
    
    $("#addpessoa").click( function(){
        $(".totalblackpage").fadeIn(100);
        $(".totalblackpage .fechar").removeClass("off");
        $("#pessoaform").fadeIn(150);
    });
    
    $("#addPessoaBt").click( function(){
        pic = $("#pessoaform #pessoaform_ic").val();
        pemail = $("#pessoaform #pessoaform_email").val();
        pnome = $("#pessoaform #pessoaform_nome").val();
        parent = $("#pessoaform #id_usuario").val();
        console.log(pic, pemail, pnome);
        $.post( "php/addpessoa.php", {'ic': pic, 'email': pemail, 'nome': pnome, 'parent': parent } ).done( function( result ) {
          $( "#prompt_envio" ).fadeIn(20).html("Cadastro realizado"+result ).delay(4000).fadeOut(200);
        });
        
        $("#pessoaform").find("input[type=text], input[type=email]").val("");
        
    });
    
    /* --------------------- ROLAGEM DE PAGINA --------------------- */
    
    function ancora(id){
        var rolagem = $("#"+id).offset().top;
        $("html, body").animate({ scrollTop: ((parseInt(rolagem))-(0.2*parseInt($(window).innerHeight())))+"px" }, 250)
    }
    
    
    
});