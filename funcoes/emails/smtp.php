<?php 


$smtp_charset = "UTF-8";
$smtp_debug = 0;
$smtp_debugoutput = "html" ;
$smtp_host = 'smtp.vetorian.com';
$smtp_auth =  true; // esse campo precisa ser true
$smtp_username = 'vetorian@vetorian.com';
$smtp_password = 'V3t0r14n!';
$smtp_secure = 'auto';
$smtp_port = 587;
$smtp_options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

?>