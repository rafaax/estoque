<?php

include_once '../../conexao.php';
include_once '../../get_dados.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $json = json_encode($dados);

    if(@$json){
        $id = $dados['id'];
        $sql = "select * from recebidos where id = $id";
        $query = mysqli_query($conexao, $sql);
        
    }
}

?>