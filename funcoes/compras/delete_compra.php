<?php
include_once '../../conexao.php';
include '../../get_dados.php';

function logBanco($user, $id){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Delete Compra', '$id' )";
    mysqli_query($conexao, $sql);
}

$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);

if(isset($dados['id'])){
    $id = $dados['id'];

    $sql = "DELETE from compras where id = $id";
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

