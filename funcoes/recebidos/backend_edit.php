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

function updateCompras($recebido_id, $compra_id){
    require '../../conexao.php';

    $sql = "UPDATE compras set recebido_id = '$recebido_id' where id = $compra_id ";
    $query = mysqli_query($conexao, $sql);

    return $query ? true : false;
}

function insertEstoque($compra_id){
    require '../../conexao.php';

    $sql = "SELECT id from estoque where compra_id = $compra_id limit 1";
    $query = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($query) < 1){
        
        $sql = "SELECT quantidade from compras where id = $compra_id";
        $query = mysqli_query($conexao, $sql);
        $array = mysqli_fetch_array($query);
        $quantidade = $array['quantidade'];
        
        $sql = "INSERT INTO estoque(quantidade, compra_id) values ('$quantidade', '$compra_id')";
        mysqli_query($conexao, $sql);
        
    }
    
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
                die();
            }

            $recebido = $dados['recebido'];
            $data_entrega = $dados['data_entrega'];
            $id_produto = $dados['id_produto'];

            $recebido_id = buscaRecebido($recebido) ;

            $sql = "SELECT data_entrega, recebido_id, compra_id,
            (select data_compra from compras where id = r.compra_id) as data_compra from recebidos r  where id = $id_produto ";
            $query = mysqli_query($conexao, $sql); 
            $array = mysqli_fetch_array($query);

            $db_data_entrega = $array['data_entrega'];
            $db_recebido_id = $array['recebido_id'];
            $db_data_compra = $array['data_compra'];
            $db_compra_id = $array['compra_id'];

            if($dados['data_entrega'] < $db_data_compra){
                echo json_encode(array(
                    'erro' => 'data',
                    'msg' => 'Data da entrega não pode ser anterior à data da compra!'
                ));
                die();
            }

            if($db_data_entrega == null && $db_recebido_id == null){

                $sql = "UPDATE recebidos set data_entrega = '$data_entrega', recebido_id ='$recebido_id' where id = $id_produto";
                $query = mysqli_query($conexao, $sql);
                
                
                if($query){
                    insertEstoque($db_compra_id);
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
                        updateCompras($recebido_id, $db_compra_id);
                        insertEstoque($db_compra_id);
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