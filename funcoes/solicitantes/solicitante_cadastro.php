<?php
include_once '../../conexao.php';
include '../../get_dados.php';


function logBanco($user, $id){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Create Solicitante', '$id' )";
    mysqli_query($conexao, $sql);
}


$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);
if(isset($dados['nome'])){
    $nome = $dados['nome'];
    $sql = "SELECT * from integrantes where nome = '$nome'";
    $query = mysqli_query($conexao, $sql);
    $count = mysqli_num_rows($query);

    if($count >= 1){
        echo json_encode(array(
            'erro' => true,
            'msg' => 'Registro ja existe!'
        ));
        exit();
    }else{
        $sql = "INSERT INTO integrantes(nome, status) values ('$nome', 'Ativo')";
        $query = mysqli_query($conexao, $sql);

        if($query){
            echo json_encode(array(
                'erro' => false
            ));

            logBanco($userSession, $nome);
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
