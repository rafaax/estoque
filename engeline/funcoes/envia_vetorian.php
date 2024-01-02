<?php
include_once '../../conexao.php';
include '../../get_dados.php';

function logBanco($user, $id){
    require '../../conexao.php';
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Enviou compra para Vetorian', '$id' )";
    mysqli_query($conexao, $sql);
}


$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);

if(isset($dados['id'])){
    $id = $dados['id'];
    $sql = "UPDATE compras set engeline = 0 where id = $id";
    $query = mysqli_query($conexao, $sql);

    if($query){
        echo json_encode(array(
            'erro' => false
        ));
    
        logBanco($userSession, $id);

        exit(); 
    }else{
        echo json_encode(array(
            'erro' => true,
            'msg' => 'Erro na query!'
        ));
        exit();
    }   
}