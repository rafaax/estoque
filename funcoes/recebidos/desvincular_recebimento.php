<?php

include_once '../../conexao.php';
include_once '../../get_dados.php';

function logRetirarRecebimento($user, $target){
    require '../../conexao.php';

    $sql = "insert into logs(usuario, mensagem, target) values('$user', 'Delete Recebimento da compra: ', '$target')";
    $query = mysqli_query($conexao, $sql);

    return $query ? true : false;

}

function logErro(){
    echo json_encode(array(
        'erro' => true,
        'msg' => 'Ocorreu algum erro...'
    ));
}

if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $json = json_encode($dados);

    if(@$json){
        $id = $_POST['id'];
        $sql = "SELECT * from recebidos where id = $id limit 1";
        $query = mysqli_query($conexao, $sql);
        $array = mysqli_fetch_array($query);

        $compra_id = $array['compra_id'];
        $recebido_id = $array['recebido_id'];
        $data_entrega = $array['data_entrega']; 
        
        $sql = "UPDATE recebidos set data_entrega = NULL, recebido_id = NULL where id = $id";
        $query = mysqli_query($conexao, $sql);

        if($query){
            $sql = "UPDATE compras set recebido_id = NULL where id = $compra_id ";
            $query = mysqli_query($conexao, $sql);
            if($query){
                $sql = "DELETE from estoque where compra_id = '$compra_id'";
                $query = mysqli_query($conexao, $sql);
                if($query){
                    if(logRetirarRecebimento($userSession, $compra_id)){
                        echo json_encode(array(
                            'erro' => false,
                            'msg' => 'Recebimento foi excluído com sucesso.'
                        ));
                    }else{
                        logErro();
                    }
                }else{
                    logErro();
                }
            }else{
                logErro();
            }
        }else{
            logErro();
        }
    }
}

?>