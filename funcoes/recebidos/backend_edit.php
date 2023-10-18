<?php 

include_once '../../conexao.php';
include_once '../../get_dados.php';

function buscaRecebido($nome){
    require '../../conexao.php';

    $sql = "SELECT id from integrantes where nome = '$nome'";
    $query = mysqli_query($conexao, $sql);
    $array = mysqli_fetch_array($query);

    return $array['id'];

}

function logBanco($user,$target){
    require '../../conexao.php';

    $sql = "insert into logs(usuario, mensagem, target) values('$user', 'Cadastro Recebimento', '$target')";
    $query = mysqli_query($conexao, $sql);

    return $query ? true : false;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $json = json_encode($dados);
    // file_put_contents('dados_edit.json', $json);

    if(@$json){
    
        if(isset($dados['recebido']) && isset($dados['data_entrega'])){

            $data_hoje = date("Y-m-d");
            if($data_hoje < $dados['data_entrega']){
                echo json_encode(array(
                        'erro' => 'data',
                        'msg' => 'Data da entrega não pode ser maior que a data de hoje!'
                    ));
                    // parar o arquivo após o print
                    die();
            }
            
            $recebido = $dados['recebido'];
            $data_entrega = $dados['data_entrega'];
            $id_produto = $dados['id_produto'];

            $recebido_id = buscaRecebido($recebido) ;

            $sql = "SELECT data_entrega, recebido_id from recebidos where id = $id_produto ";
            $query = mysqli_query($conexao, $sql); 
            $array = mysqli_fetch_array($query);

            $db_data_entrega = $array['data_entrega'];
            $db_recebido_id = $array['recebido_id'];

            if($db_data_entrega == null && $db_recebido_id == null){

                $sql = "UPDATE recebidos set data_entrega = '$data_entrega', recebido_id ='$recebido_id' where id = $id_produto";
                $query = mysqli_query($conexao, $sql);
                
                
                if($query){
                    echo json_encode(array(
                        'erro' => false,
                        'msg' => 'Compra recebida com sucesso!'
                    ));
                }else{
                    echo json_encode(array(
                        'erro' => true,
                        'msg' => 'Ocorreu algum erro...'
                    ));
                }
            }else {

                $sql = "UPDATE recebidos set data_entrega = '$data_entrega', recebido_id ='$recebido_id' where id = $id_produto";
                $query = mysqli_query($conexao, $sql);
              

                if($query){
                    if(logBanco($userSession, $id_produto)){
                        echo json_encode(array(
                            'erro' => false,
                            'msg' => 'Recebimento atualizado com sucesso!'
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

            }

        }
    }
}