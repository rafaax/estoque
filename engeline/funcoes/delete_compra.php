<?php
include_once '../../conexao.php';
include '../../get_dados.php';

function logBanco($user, $id){
    require '../../conexao.php';
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Delete Compra', '$id' )";
    mysqli_query($conexao, $sql);
}

function logBanco2($user, $id){
    require '../../conexao.php';
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Delete Recebimento', '$id' )";
    mysqli_query($conexao, $sql);
}

function buscaRecebidos($id){
    require '../../conexao.php';
    $sql = "select id from recebidos where compra_id = $id limit 1 ";
    $query = mysqli_query($conexao, $sql);
    
    $array = mysqli_fetch_array($query);

    return $array['id'];
}

$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);

if(isset($dados['id'])){
    $id = $dados['id'];

    $sqlEstoque = "SELECT * from estoque where compra_id = '$id'";
    $queryEstoque = mysqli_query($conexao, $sqlEstoque);

    if(mysqli_num_rows($queryEstoque) == 0){
        $sql = "DELETE from compras where id = $id";
        $query = mysqli_query($conexao, $sql);

        $id_recebido = buscaRecebidos($id);
        
        $sql2 = "DELETE FROM recebidos where id = $id_recebido";
        $query2 = mysqli_query($conexao, $sql2);
    
        if($query && $query2){
            echo json_encode(array(
                'erro' => false
            ));
        
            logBanco($userSession, $id);
            logBanco2($userSession, $id_recebido);

            exit(); 
        }else{
            echo json_encode(array(
                'erro' => true,
                'msg' => 'Erro na query!'
            ));
            exit();
        }   
    }else if(mysqli_num_rows($queryEstoque) > 0){
        echo json_encode(array(
                'erro' => true,
                'msg' => 'Você não pode deletar o registro que ja foi recebido!'
            ));
        exit();
    }  
}

