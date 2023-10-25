<?php 

include_once '../../conexao.php';
include_once '../../get_dados.php';

function buscaIntegranteId($nome){
    require '../../conexao.php';

    $sql = "select id from integrantes where nome = '$nome' limit 1";
    $query = mysqli_query($conexao, $sql);
    
    if($query){
        $array = mysqli_fetch_assoc($query);
        return $array['id'];
    }else{
        return false;
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $json = json_encode($dados);
    file_put_contents('dados_retirada.json', $json);

    if(@$json){

        $id_produto = $dados['id_produto'];
        $retirado = $dados['retirado_por'];
        $data_compra = $dados['data_compra'];
        $quantidade_retirada = $dados['quantidade_retirada'];
        $motivo_retirada = $dados['motivo_retirada'];
        $retirado_id = buscaIntegranteId($retirado);

        echo $retirado_id;

        

        // $sql = "";
        // $query = mysqli_query($conexao, $sql);

    }
}