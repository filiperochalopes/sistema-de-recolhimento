<?php

//require('php/dbconf.php'); sempre chamar antes de chamar functions se necessario

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

function enviaremail($destinatario, $assunto, $mensagem, $anexo){
    
    $email_envio = "nao-responda@setorrs.com.br";
    $email_ad = "aniltonsantos7@gmail.com";
    $Subject = $assunto;
    $Message = $mensagem;

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    // inicia a classe PHPMailer habilitando o disparo de exceções
    $mail = new PHPMailer(true);
    try
    {
        // habilita o debug
        // 0 = em mensagens de debug
        // 1 = mensagens do cliente SMTP
        // 2 = mensagens do cliente e do servidor SMTP
        // 3 = igual o 2, incluindo detalhes da conexão
        // 4 = igual o 3, inlcuindo mensagens de debug baixo-nível
        $mail->SMTPDebug = 4;

        // utilizar SMTP
        $mail->isSMTP();

        // habilita autenticação SMTP
        $mail->SMTPAuth = true;

        // servidor SMTP
        //$mail->Host = 'mail.hostgator.com.br';
        $mail->Host = 'br458.hostgator.com.br';

        // usuário, senha e porta do SMTP
        $mail->Username = 'nao-responda@setorrs.com.br';
        $mail->Password = '@nilton7';
        $mail->Port = 587;

        // tipo de criptografia: "tls" ou "ssl"
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAutoTLS = true;

        // email e nome do remetente
        $mail->setFrom($email_ad, 'Setor R·S Recolhimento');

        // Email e nome do(s) destinatário(s)
        // você pode chamar addAddress quantas vezes quiser, para
        // incluir diversos destinatários
        $mail->addAddress('provisao_oferta@setorrs.com.br', 'Setor R·S');
        $mail->addAddress('aniltonsantos7@gmail.com', 'Anilton');
        $mail->addAddress('filiperocklopes@gmail.com', 'Filipe Lopes');
        if($destinatario != ""){
            $mail->addAddress($destinatario, 'Destinatário especial');
        }

        // endereço que receberá as respostas
        $mail->addReplyTo($email_ad, 'AD');

        // com cópia (CC) e com cópia oculta (BCC)
        //$mail->addCC('copia@site.com');
        //$mail->addBCC('copia_oculta@site.com');
      

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        // define o formato como HTML
        $mail->isHTML(true);

        // codificação UTF-8
        $mail->CharSet = 'UTF-8';

        // assunto do email
        $mail->Subject = $Subject;

        // corpo do email em HTML
        $mail->Body = $Message;

        // corpo do email em texto
        $mail->AltBody = 'Mensagem em HTML não bem sucedida';
        
        if($anexo != ""){
            
            foreach ($anexo as $valor) {
                $mail->AddAttachment('../tmp/'.$valor);
            }

        }

        // envia o email
        $mail->send();

        //echo 'Mensagem enviada com sucesso!' . PHP_EOL;
    }
    catch (Exception $e)
    {
        echo 'Falha ao enviar email.' . PHP_EOL;
        echo 'Erro: ' . $mail->ErrorInfo . PHP_EOL;
    }
    
}

function criarJSON(){
    global $conndb;
    $query1 = $conndb->query("SELECT * FROM pessoas")or die("[ERR002] nadajson");
    $objarray = [];
    while($row1 = $query1->fetch_assoc()){
        
        $objarray[$row1["id"]] = $row1["nome"];

    }
    
    $object = (object)$objarray;
    
    $array = [];
    array_push($array, $object);
    
    $file = fopen("../js/pessoas.json", "w+");

    fwrite($file, json_encode($array, JSON_PRETTY_PRINT));

    fclose($file);
}

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 
}

function random_img_name() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 15; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}



?>