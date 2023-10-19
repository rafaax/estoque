<?php

include_once '../../conexao.php';
include_once '../../get_dados.php';


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
                    echo json_encode(array(
                        'erro' => false,
                        'msg' => 'Recebimento foi excluído com sucesso.'
                    ));
                }else{
                    echo json_encode(array(
                        'erro' => true,
                        'msg' => 'Ocorreu algum erro...'
                    ));
                }
            }else{
                echo json_encode(array(
                    'erro' => true,
                    'msg' => 'Ocorreu algum erro...'
                ));
            }
        }else{
            echo json_encode(array(
                'erro' => true,
                'msg' => 'Ocorreu algum erro...'
            ));
        }
    }
}

?>