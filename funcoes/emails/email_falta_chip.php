<?php

require '../../conexao.php';
require '../../vendor/autoload.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

date_default_timezone_set('America/Sao_Paulo');
use PHPMailer\PHPMailer\PHPMailer;

if(getenv('REQUEST_METHOD') == 'POST') {
    
    require 'smtp.php';

    $client_data = file_get_contents("php://input");
    $json = json_decode($client_data);
    file_put_contents('post_chip.json', json_encode($json));

    $valor = $json->valor;
    $tolerancia = $json->tolerancia;
    
    $sql = "select * from usuario where nivel = 1";
    $query = mysqli_query($conexao, $sql);
    $users = array();
    while($array = mysqli_fetch_array($query)){ 
        $email = $array['email'];
        $nome = $array['nome'];
        $sobrenome = $array['sobrenome'];
        array_push($users, array(
            'email' => $email,
            'nome' =>$nome,
            'sobrenome'=>$sobrenome
        ));
    }

    $mail = new PHPMailer();

    $mail->CharSet = $smtp_charset;
    $mail->SMTPDebug = $smtp_debug;                                 // Enable verbose debug output
    $mail->Debugoutput = $smtp_debugoutput;
    $mail->isSMTP();
    $mail->Host = $smtp_host;
    $mail->SMTPAuth = $smtp_auth;
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = $smtp_secure;
    $mail->Port = $smtp_port;
    $mail->SMTPOptions = $smtp_options;

    foreach($users as $user){

        $mail->addCC($user['email'], $user['nome'] .' ' .  $sobrenome);
        $mail->setFrom('vetorian@vetorian.com');
        $mail->addAddress($user['email']);
        $mail->setLanguage('pt_br', '/optional/path/to/language/directory/');
        $mail->isHTML(true);
        $mail->Subject = 'Estoque Vetorian';
        $conexao = mysqli_connect('engedoc.com.br', 'engedoc', '3Ng3d0c!', 'calendario');

        $sql = "SELECT html from email_template where tipo = 'FALTA_CHIP'";
        $query = mysqli_query($conexao, $sql);
        $array = mysqli_fetch_assoc($query);
        $body = $array['html'];
        

        $arrayHtml = array(
                    "%content%" => "Chips no estoque: <strong> $valor </strong>",
                    "%content2%" => "Mínimo recomendado no estoque: <strong>$tolerancia</strong>",
                );

        $mail->Body = strtr($body,$arrayHtml);
    }

    if(!$mail->send()) {
        echo 'Não foi possível enviar a mensagem.<br>';
        echo 'Erro: ' . $mail->ErrorInfo;
    } else {
        echo 'Mensagem enviada.';
    }

}
?>