<?php
include_once '../../conexao.php';
include '../../get_dados.php';

function buscaBanco($id){

    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "SELECT * from integrantes where id = $id";
    $query = mysqli_query($conexao, $sql);
    $count = mysqli_num_rows($query);

    if($count > 0){
        return true;
    }else{
        return false;
    }
}

function logBanco($user, $id){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Solicitante Inativo', '$id' )";
    mysqli_query($conexao, $sql);
}

$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);

if(isset($dados['id'])){
    $id = $dados['id'];

    if(buscaBanco($id)){
        
        $sql = "UPDATE integrantes set status = 'Inativo' where id = $id";
        $query = mysqli_query($conexao, $sql);

        if($query){
            echo json_encode(array(
                'erro' => false
            ));

            logBanco($userSession, $id);
            die();
        }else{
            echo json_encode(array(
                'erro' => true,
                'msg' => 'Erro na query!'
            ));
            exit();
        }   
        
    }else{
        echo json_encode(array(
                'erro' => true,
                'msg' => 'Registro não existe!'
            ));
            exit();
    }
    
}

