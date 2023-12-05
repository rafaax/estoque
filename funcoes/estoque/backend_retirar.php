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

function buscaCompraId($id){
    require '../../conexao.php';

    $sql = "select compra_id from estoque where id = $id";
    $query = mysqli_query($conexao, $sql);
    
    if($query){
        $array = mysqli_fetch_assoc($query);
        return $array['compra_id'];
    }else{
        return false;
    }
}

function jsonEcho($msg){
    echo json_encode(array(
        'erro' => false,
        'msg' => $msg
    ));
}

function jsonEchoErro($msg){
    echo json_encode(array(
        'erro' => true,
        'msg' => $msg
    ));
}

function logRetirada($user, $target){
    require '../../conexao.php';

    $sql = "insert into logs(usuario, mensagem, target) values('$user', 'Retirada', '$target')";
    $query = mysqli_query($conexao, $sql);

    return $query ? true : false;
}

function retiraEstoque($id, $quantidade_retirada){
    require '../../conexao.php';

    $sql = "select quantidade from estoque where id = $id limit 1";
    $query = mysqli_query($conexao, $sql);
    $array = mysqli_fetch_array($query);
    $quantidade_atual = $array['quantidade'];
    $quantidade_update = $quantidade_atual - $quantidade_retirada;

    $sql = "update estoque set quantidade = '$quantidade_update' where id = $id ";
    $query = mysqli_query($conexao, $sql);
}


if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $json = json_encode($dados);
    file_put_contents('dados_retirada.json', $json);

    if(@$json){

        $id_produto = $dados['id_produto'];
        $retirado = $dados['retirado_por'];
        $data_retirada = $dados['data_retirada'];
        $quantidade_retirada = $dados['quantidade_retirada'];
        $motivo_retirada = $dados['motivo_retirada'];
        
        $retirado_id = buscaIntegranteId($retirado);
        $compra_id = buscaCompraId($id_produto);

        $sql = "SELECT data_entrega from recebidos where compra_id = $compra_id limit 1";
        $query = mysqli_query($conexao, $sql);
        $array = mysqli_fetch_array($query);

        $data_hoje = date('Y-m-d');
        $data_entrega = $array['data_entrega'];

        if($data_hoje < $data_retirada){
            jsonEchoErro('Data de retirada não pode ser maior que a data de hoje.');
            exit();
        }else if($data_retirada < $data_entrega){
            jsonEchoErro('Data de retirada não pode ser menor que a data da entrega!');
            exit();
        }

        $sql = "SELECT quantidade from estoque where id = $id_produto";
        $query = mysqli_query($conexao, $sql);
        $array = mysqli_fetch_array($query);
        if($array['quantidade'] <= 0){
            jsonEchoErro('Não existe mais este produto no estoque ');
            die();
        }


        if($retirado_id != false && $compra_id != false ){
            $sql = "INSERT INTO retirada(integrante_id, compra_id, estoque_id, quantidade_retirada, motivo, data_retirada) 
                values ('$retirado_id', '$compra_id', '$id_produto', '$quantidade_retirada', '$motivo_retirada', '$data_retirada')";
            $query = mysqli_query($conexao, $sql);

            if($query){
                logRetirada($userSession, $id_produto);
                retiraEstoque($id_produto, $quantidade_retirada);
                jsonEcho('Retirado com sucesso!');
                include_once '../rotinas/rotina_chip.php';
                include_once '../rotinas/rotina_rastreador.php';
            }else{
                jsonEchoErro('Ocorreu algum erro...');
            }
        }else{
            jsonEchoErro('Ocorreu algum erro...');
        }
    }
}