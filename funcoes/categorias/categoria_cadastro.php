<?php
include_once '../../conexao.php';
include '../../get_dados.php';

function logBanco($user, $id){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Create Categoria', '$id' )";
    mysqli_query($conexao, $sql);
}


$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);
if(isset($dados['categoria'])){
    $categoria = $dados['categoria'];
    $sql = "SELECT * from categoria where nome = '$categoria'";
    $query = mysqli_query($conexao, $sql);
    $count = mysqli_num_rows($query);

    if($count >= 1){
        echo json_encode(array(
            'erro' => true,
            'msg' => 'Registro ja existe!'
        ));
        exit();
    }else{
        $sql = "INSERT INTO categoria(nome) values ('$categoria')";
        $query = mysqli_query($conexao, $sql);

        if($query){
            echo json_encode(array(
                'erro' => false
            ));

            logBanco($userSession, $categoria);
            exit();
        }else{
            echo json_encode(array(
                'erro' => true,
                'msg' => 'Erro na query!'
            ));
            exit();
        }
    }
}