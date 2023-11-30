<?php

function postCurl($data){

    $url = "../emails/email_falta_rast.php";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));

    curl_exec($ch);
    curl_close($ch);
}

$conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
// rotina st310 
$sql = "select sum(e.quantidade) as quantidade_total, c.partnumber from estoque e inner join compras c on c.id = e.compra_id where c.partnumber in ('ST310UC2')";
$query = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($query);

$quantidade_estoque = $array['quantidade_total'];


$sql = "select * from rotinas where type = 'Rastreador'";
$query = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($query);

if($array['quantidade'] != $quantidade_estoque){
    if($quantidade_estoque <= 5){
        $post = array(
            'valor' => $quantidade_estoque,
            'tolerancia' => $array['e.tolerancia']
        );
        $json = json_encode($post);
        postCurl($json);
    }else{
        exit();
    }
}else{
    exit();
}