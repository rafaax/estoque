<?php
include_once '../../conexao.php';
include '../../get_dados.php';


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$json = json_encode($dados);

$senha_antiga = $dados['password_atual'];
$senha_nova = $dados['new_password'];

if($senha_antiga != $senha_nova){
    $sql = "UPDATE usuario set password = '$senha_nova' where id = $userSession";
    $query = mysqli_query($conexao, $sql);

    if($query){
        echo json_encode(array(
            'erro'=> false
        ));
    }else{
        echo json_encode(array(
            'erro'=> true
        ));
    }
}