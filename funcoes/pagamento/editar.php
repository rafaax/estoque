<?php
include_once '../../conexao.php';
include '../../get_dados.php';

function buscaBanco($id){

    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "SELECT * from pagamentos where id = $id";
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
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Edit Pagamento', '$id' )";
    mysqli_query($conexao, $sql);
}


$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);

if(isset($dados['pagamento']) && isset($dados['id'])){
    $pagamento = $dados['pagamento'];
    $id = $dados['id'];

    if(buscaBanco($id)){
        $sql = "UPDATE pagamentos set nome = '$pagamento' where id = $id";
        $query = mysqli_query($conexao, $sql);

        if($query){
            echo json_encode(array(
                'erro' => false
            ));

            logBanco($userSession, $pagamento);

            die();
        }else{
            echo json_encode(array(
                'erro' => true,
                'msg' => 'Erro na query!'
            ));
        }
    }else{
        echo json_encode(array(
                'erro' => true,
                'msg' => 'Registro não existe!'
            ));
            exit();
    }   
}