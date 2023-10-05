<?php 
include_once '../../conexao.php';
include_once '../../get_dados.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // substitui o $_POST[''] :))
    $json = json_encode($dados);
    file_put_contents('dados.json', $json);
    if(@$json){
        $nome_produto = $dados['nome_produto'];
        echo $nome_produto;
    }
}


