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



if($_SERVER['REQUEST_METHOD'] == 'POST' ){

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // substitui o $_POST[''] :))
    $json = json_encode($dados);
    if(file_put_contents('dados_edit.json', $json)){
        echo 'arquivo escrito';
    }else{
        echo 'arquivo nao foi escrito';
    }

    if(@$json){
        
        $nome = $dados['nome_produto'];
        $partnumber = $dados['partnumber_produto'];
        $quantidade = $dados['quantidade']; 
        $unidade = $dados['unidade'];
        $solicitante =$dados['solicitante'] ;
        $fornecedor = $dados['fornecedor'];
        $categoria =$dados['categoria'] ;
        $pagamento = $dados['pagamento'];
        $parcelas = $dados['parcelas'];
        $preco_unitario = $dados['preco_unitario']; 
        $frete = $dados['frete'];
        $imposto = $dados['imposto']; 
        $site = $dados['site'];
        $descricao = $dados['descricao'];
        $data_compra = $dados['data_compra'];
        $previsao_entrega = $dados['previsao_entrega'];
        

        $unidade_id = getUnidade($unidade);
        $solicitante_id = getSolicitante($solicitante);
        $pagamento_id = getPagamento($pagamento);
        $fornecedor_id = getFornecedor($fornecedor);

        echo "Unidade id: $unidade_id ";
        echo "Solicitante id: $solicitante_id ";
        echo "Pagamento id: $pagamento_id ";
        echo "Fornecedor id: $fornecedor_id ";

        
        

    }

    



}