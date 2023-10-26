<?php

include_once '../../conexao.php';
include_once '../../get_dados.php';

function jsonEcho($msg){
    echo json_encode(array(
        'erro' => false,
        'msg' => $msg
    ));    
}

function jsonEchoErr($msg){
    echo json_encode(array(
        'erro' => true,
        'msg' => $msg
    ));
}

if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    $dados = json_decode(file_get_contents('php://input'), true);
    $json = json_encode($dados);
    if(@$json){

        $id = $dados['id'];
        $quantidade = $dados['qt'];

        $sql = "SELECT e.id as id_estoque, e.quantidade, r.quantidade_retirada, r.quantidade_devolvida from estoque e 
            inner join retirada r on e.id = r.estoque_id where r.id = $id";
        $query = mysqli_query($conexao, $sql);

        $array = mysqli_fetch_array($query);
        $id_estoque = $array['id_estoque'];
        $quantidade_estoque = $array['quantidade'];
        $quantidade_retirada = $array['quantidade_retirada'];
        $quantidade_devolvida = $array['quantidade_devolvida'];

        if($quantidade > $quantidade_retirada ){
            jsonEchoErr('Quantidade devolvida não pode ser maior que a quantidade retirada');
            exit();
        }

        $quantidade_update = $quantidade + $quantidade_devolvida;

        if($quantidade_update > $quantidade_retirada){
            jsonEchoErr('Quantidade devolvida não pode ser maior que a quantidade retirada');
            exit();
        }

        $sql = "update retirada set quantidade_devolvida = $quantidade_update where id = $id";
        $query = mysqli_query($conexao, $sql);

        if($query){
            $update = $quantidade_estoque + $quantidade_devolvida;
            $sql = "update estoque set quantidade = $update where id = $id_estoque";
            $query = mysqli_query($conexao, $sql);
            if($query){
                jsonEcho('Quantidade devolvida com sucesso!');
            }
        }else{
            jsonEchoErr('Ocorreu algum erro...');
        }
    }
}