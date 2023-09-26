<?php
include_once '../../conexao.php';
include '../../get_dados.php';


function logBanco($user, $id){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $sql = "INSERT INTO logs(usuario, mensagem, target) values ('$user','Create Pagamento', '$id' )";
    mysqli_query($conexao, $sql);
}

$dados = json_decode(file_get_contents('php://input'), true);
$json = json_encode($dados);
// echo $json;
if(isset($dados['pagamento'])){
    $nome = $dados['pagamento'];
    $sql = "SELECT * from pagamentos where nome = '$nome'";
    $query = mysqli_query($conexao, $sql);
    $count = mysqli_num_rows($query);

    if($count >= 1){
        echo json_encode(array(
            'erro' => true,
            'msg' => 'Registro ja existe!'
        ));
        exit();
    }else{
        $sql = "INSERT INTO pagamentos(nome) values ('$nome')";
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
}else{
    print 'nao existem dados';
}
