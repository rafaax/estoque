<?php
include_once '../../conexao.php';
include '../../get_dados.php';

function buscaBanco($id){

    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "SELECT * from categoria where id = $id";
    $query = mysqli_query($conexao, $sql);
    $count = mysqli_num_rows($query);

    if($count > 0){
        return true;
    }else{
        return false;
    }
}

function buscaRegistro($id){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');

    $sql = "SELECT * from compras where categoria_id = $id";
    $query = mysqli_query($conexao, $sql);
    $count = mysqli_num_rows($query);
    
    if($count == 0 ){
        return true;
    }else{
        return false;
    }
}


function logBanco($user, $id){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Delete Categoria', '$id' )";
    mysqli_query($conexao, $sql);
}

$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);

if(isset($dados['id'])){
    $id = $dados['id'];

    if(buscaBanco($id)){
        
        if(buscaRegistro($id)){
            $sql = "DELETE from categoria where id = $id";
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
                'msg' => 'Categoria não pode ser deletada pois existem registros atrelados a ela!'
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

