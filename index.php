<!DOCTYPE html>
<html lang="br">
    <meta charset="utf-8"/>
    <head>
        <title>Recolhimento de Provisões</title>
        <meta name="description" content="Sistema de Gerenciamento do Recolhimento de Provisões e Ofertas da Igreja" />
        <meta name="mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="msapplication-TileColor" content="#000"/>
        <meta name="msapplication-TileImage" content="img/icon/win_196x196.png"/>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="apple-touch-icon" href="img/icon/196x196.png" sizes="196x196"/>
        <link rel="apple-touch-startup-image" href="img/starup.png" sizes="196x196"/>
        <link rel="shortcut icon" href="img/icon/196x196.png" sizes="196x196"/>
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        
        <link href="https://use.fontawesome.com/releases/v5.0.2/css/all.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if(!isset($_COOKIE["setorrs_pvof_senha"])) {
        ?>
        <div class="blackpage">
            <div class="carregando"></div>
        </div>
        <section id="senha_master">
            <input type="password" pattern="[0-9]*" inputmode="numeric" id="pass-id" class="senhaid" />
            <input type="password" pattern="[0-9]*" inputmode="numeric" maxlength="4" id="pass-number" class="senhanum" />
            <span id="mensagemsenha"></span>
        </section>
        <?php
        }else{
        ?>
        <script>
            var nomeusuario = "<?php echo $_COOKIE["setorrs_pvof_nome"] ?>";
        </script>
        
        <div class="totalblackpage">
            <span class="fechar off"></span>
            <div></div>
        </div>
        <div class="blackpage">
            <div class="carregando"></div>
        </div>
        <div id="prompt_envio">
        </div>
        <div id="itens_carregados">
        </div>
        <section id="senha_master" class="lider">
            <input type="password" pattern="[0-9]*" inputmode="numeric" id="pass-id" class="senhaid" />
            <input type="password" pattern="[0-9]*" inputmode="numeric" maxlength="4" id="pass-number-lider" class="senhanum" />
            <span id="mensagemsenha">Líderes ou diáconos</span>
        </section>
        <section id="aviso"><div><span>AVISO</span><button>Continuar</button></div></section>
        <section id="carregando"><div class="texto">Enviando...</div></section>
        
        <div id="teste"></div>
        
        <!-- FORMULARIO DE + PROVISAO -->
        
        <section id="pvofform">
            <div>
                <input type="hidden" id="id_usuario"/>
                <input type="number" id="provisao" placeholder="Provisão" step="any"/>
                <input type="number" id="oferta" placeholder="Oferta" step="any"/>
                <input type="number" id="mocambique" placeholder="Moçambique" step="any"/>
                <input type="number" id="missoes" placeholder="Missões" step="any"/>
                <button id="addEvento">Pronto</button>
            </div>
        </section>
        
        <!-- FORMULARIO DE + PESSOAS -->
        
        <section id="pessoaform">
            <input type="hidden" id="id_usuario" value="<?php echo $_COOKIE["setorrs_pvof_id"]; ?>"/>
            <input type="text" id="pessoaform_nome" placeholder="Nome da pessoa" required/>
            <input type="email" id="pessoaform_email" placeholder="Email da pessoa (opcional)"/>
            <input type="hidden" id="pessoaform_ic" placeholder="Número do grupo caseiro" value="<?php echo $_COOKIE["setorrs_pvof_ic"]; ?>" required/>
            <button id="addPessoaBt">Adicionar</button>
        </section>
        
        <!-- HEADER -->
        
        <header id="header_menu">
            <div class="menu mobile"></div>
            <div class="logo"><span class="fas fa-dollar-sign fa-md"></span></div>
            <nav>
                <ul>
                    <li id="addpessoa" class="link"><i class="fas fa-user-plus"></i> Adicionar Pessoa</li>
                    <!--<li id="aquemsomos" class="link">+ Setor</li>
                    <li id="aprodutos" class="link">+ Igreja Casa</li>
                    <li id="acontato" class="link">+ Líder</li>-->
                </ul>
            </nav>
        </header>
        
        <main>
            <section id="sec_1">
                <div class="cortina off"></div>
                <h2 class="passo"><span>1</span>Selecione seu Setor:</h2>
                <!--O navegador salva os dois mais usados, para o futuro. hint.-->
                <div class="hintbuttonbox">
                    <!--<button id="icasa">Nome do Setor 1</button>
                    <button id="icasa">Nome do Setor 1</button>-->
                    <div class="inputhint"><input type="text" name="setor" id="setor" placeholder="Nome do Setor"/>
                        <button id="verificasetor" class="inputok">OK</button>
                    <ul id="hintSetor" class="hint"></ul></div>
                </div>
            </section>
            
            <section id="sec_2">
                <div class="cortina"></div>
                <h2 class="passo"><span>2</span>Selecione a Igreja na Casa:</h2>
                <div class="carregando"></div>
                <!--Salva a mais usada. box 1 mais usada, 2 mais usada e campo de busca com hint.
                Só libera quando coloca o setor, carrega as opções.-->
                <select id="showics" class="showbt">
                    <option>Selecione uma Igreja na Casa</option>
                </select>                
            </section>
            
            <section id="sec_3">
                <div class="cortina"></div>
                <h2 class="passo"><span>3</span>Registros:</h2>
                <section class="part1">
                    <div class="showbt">
                        <button id="houveencontro" >HOUVE ENCONTRO</button>
                        <button id="naorecolhimento" class="red">NÃO houve RECOLHIMENTO</button>
                        <button id="naoencontro" class="red">NÃO houve ENCONTRO</button>
                    </div>
                </section>                
                <div class="carregando"></div>
                <section class="part2">
                    <!--O navegador salva os dois mais usados, para o futuro. hint.-->
                    <div class="hintbuttonbox">
                        <!--<button id="icasa">Nome do Setor 1</button>
                        <button id="icasa">Nome do Setor 1</button>-->
                        <div class="inputhint"><input type="text" name="pessoa" id="pessoa" placeholder="Nome da Pessoa"/>
                        <ul id="hintPessoa" class="hint"></ul></div>
                    </div>
                    <button id="envios_concluidos" disabled>Concluído</button>
                    <div class="carregando"></div>
                </section>
                <!--verifica se tem mesmo algo e prossegue-->
            </section>
            
            <section id="sec_4">
                <div class="cortina"></div>
                <h2 class="passo"><span>4</span>Envio.</h2>
                <div id="preview"></div>
                <div class="showbt">
                    <button id="venviar" class="off">VALIDAR e ENVIAR</button>
                    <button id="nvenviar" class="off red" disabled>Enviar SEM VALIDAR</button>
                </div>
                <span class="off small">Envie se validar quando o líder não estiver presente, será enviado um email para ele solictando sua confirmação.</span>
            </section>
            
            <section id="sobreaversao">
                <section>
                    <time pubdate datetime="2018-03-18"></time>
                    Versão 0.3
                    Correção de bugs, adição de funcionalidade, melhoramento de navegabilidade
                    <ul>
                        <li>Correção de bug:Todas as páginas corrigidas o erro de desaparecimento dos nomes ao fazer o cadastro</li>
                        <li>PHPMailer atualizado e mensagens agora são enviadas com sucesso, em todos os locais: envio de recolhimento, ...</li>
                        <li>Agora pode-se enviar email tanto quando não há encontro quanto quando não há recolhimento</li>
                        <li>Os emails agora são também recebidos por gmail, pois as imagens foram colocadas em anexo</li>
                    </ul>
                </section>
                <section>
                    <time pubdate datetime="2017-12-26"></time>
                    Versão 0.2
                    Correção de bugs, otimização e melhoria de visual
                    <ul>
                        <li>Correção de "Olá null" em alguns dispositivos</li>
                        <li>Correção de bug: ao adicionar uma nova pessoa ela não é cadastrada no json e portanto não aparece na fase de correção</li>
                        <li>PHPMailer atualizado e mensagens agora são enviadas com sucesso</li>
                        <li>Otimização da aba de adicionar pessoas com menos campos mais objetivos para preencher</li>
                        <li>Melhoria de visual do campo de email, marcado como opcional. Mais simples e objetivo</li>
                        <li>Novas fontes e novos ícones</li>
                    </ul>
                </section>
                <section>
                    Versão 0.1
                    Funcionalidades básicas
                    <ul>
                        <li>Apenas em Salvador</li>
                        <li>Apenas na Ribeira</li>
                        <li>Apenas envios validados pelo líder</li>
                        <li>Recursos apenas online</li>
                        <li>Sistema de registro de provisões e ofertas via email</li>
                        <li>CANVAS HTML5 papeis em anexo</li>
                        <li>Apenas campos com hints</li>
                    </ul>
                    Previsões:
                    <ul>
                        <li>Salvar os mais usados IC e Setor</li>
                        <li>Consulta</li>
                        <li>Gráficos</li>
                        <li>Painel de controle AD</li>
                        <li>App offline. Validação por email quando encontrar rede.</li>
                        <li>Menos cliques</li>
                        <li>Reduzir botões vermelhos, para menor chance de clique sem querer</li>
                        <li>Barra de carregamento mostrando envio mais ou menos, tempo médio de envio</li>
                    </ul>
                </section>
            </section>
        </main>
        <?php
        }
        ?>
        <footer>
            Desenvolvido por <a href="http://filipe3d.com.br">Filipe Lopes</a>.
        </footer>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/jquery.transit.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>