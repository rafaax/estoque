<?php 

include_once '../../conexao.php';
include_once '../../get_dados.php';


function getCategoria($categoria){
    require '../../conexao.php';

    $sql = "select id from categoria where nome = '$categoria' limit 1";
    $query = mysqli_query($conexao, $sql);    
    $result = mysqli_fetch_assoc($query);
    
    return $result['id'];

}

function getPagamento($pagamento){
    require '../../conexao.php';

    $sql = "select id from pagamentos where nome = '$pagamento' limit 1";
    $query = mysqli_query($conexao, $sql);    
    $result = mysqli_fetch_assoc($query);

    return $result['id'];
    
}

function getFornecedor($fornecedor){
    require '../../conexao.php';

    $sql = "select id from fornecedor where nome = '$fornecedor' limit 1";
    $query = mysqli_query($conexao, $sql);    
    $result = mysqli_fetch_assoc($query);

    return $result['id'];

}

function getSolicitante($solicitante){
    require '../../conexao.php';

    $sql = "select id from integrantes where nome = '$solicitante' limit 1";
    $query = mysqli_query($conexao, $sql);    
    $result = mysqli_fetch_assoc($query);
    
    return $result['id'];

}

function getUnidade($unidade){
    require '../../conexao.php';

    $sql = "select id from unidade where nome = '$unidade' limit 1";
    $query = mysqli_query($conexao, $sql);    
    $result = mysqli_fetch_assoc($query);
    
    return $result['id'];
}

function update($id, $nome, $partnumber, $quantidade, $unidade, $solicitante, $fornecedor,
$categoria, $pagamento, $parcelas, $preco_unitario, $frete, $imposto, $site, $descricao, $data_compra, $previsao_entrega ){
    require '../../conexao.php';

    $sqlupdate = "UPDATE compras set nome = '$nome', partnumber = '$partnumber', quantidade =  '$quantidade', site = '$site', 
    valor_unitario = '$preco_unitario', frete = '$frete', imposto = '$imposto', parcelas = '$parcelas', descricao = '$descricao',
    data_compra = '$data_compra', previsao_entrega = '$previsao_entrega', pagamento_id = '$pagamento', categoria_id = '$categoria', 
    fornecedor_id = '$fornecedor', solicitante_id = '$solicitante', unidade_id = '$unidade' where id = $id";

    $query = mysqli_query($conexao, $sqlupdate);

    $res  = $query ? true : false; 
    
    return $res;
    
}

function logEdit($user,$target){
    require '../../conexao.php';

    $sql = "insert into logs(usuario, mensagem, target) values('$user', 'Edit Compras', '$target')";
    $query = mysqli_query($conexao, $sql);

    return $query ? true : false;
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



if($_SERVER['REQUEST_METHOD'] == 'POST' ){

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // substitui o $_POST[''] :))
    $json = json_encode($dados);
    // file_put_contents('dados_edit.json', $json);

    if(@$json){
        
        $id_produto = $dados['id_produto'];
        $nome = $dados['nome_produto'];
        $partnumber = $dados['partnumber_produto'];
        $quantidade = $dados['quantidade']; 
        $unidade = $dados['unidade'];
        $solicitante =$dados['solicitante'];
        $fornecedor = $dados['fornecedor'];
        $categoria =$dados['categoria'];
        $pagamento = $dados['pagamento'];
        $parcelas = $dados['parcelas'];
        $preco_unitario = str_replace(',', '.', $dados['preco_unitario']); 
        $frete = str_replace(',', '.', $dados['frete']);
        $imposto = str_replace(',', '.', $dados['imposto']);
        $site = $dados['site'];
        $descricao = $dados['descricao'];
        $data_compra = $dados['data_compra'];
        $previsao_entrega = $dados['previsao_entrega'];
        
        $unidade_id = getUnidade($unidade);
        $solicitante_id = getSolicitante($solicitante);
        $pagamento_id = getPagamento($pagamento);
        $fornecedor_id = getFornecedor($fornecedor);
        $categoria_id = getCategoria($categoria);

        
        if(update($id_produto, $nome, $partnumber, $quantidade, $unidade_id, $solicitante_id, $fornecedor_id, $categoria_id,$pagamento_id, $parcelas,$preco_unitario ,$frete, $imposto, $site, $descricao, $data_compra, $previsao_entrega)){
            logEdit($userSession, $nome);
            jsonEcho('Atualizado com sucesso!');
            exit();
        }else{
            jsonEchoErro('Erro na inserção dos dados');
            exit();
        }
    }
}