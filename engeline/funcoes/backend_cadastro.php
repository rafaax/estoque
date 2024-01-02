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

function insertRecebidos($partnumber, $compra_id){
    require '../../conexao.php';
    
    $sql = "insert into recebidos(partnumber, compra_id) values('$partnumber', '$compra_id')";
    $query = mysqli_query($conexao, $sql);
    
    return $query ? true : false;

}

function logCadastro($user,$target){
    require '../../conexao.php';

    $sql = "insert into logs(usuario, mensagem, target) values('$user', 'Cadastro Compras', '$target')";
    $query = mysqli_query($conexao, $sql);

    return $query ? true : false;
}

function jsonEcho($msg){
    return json_encode(array(
        'erro' => true,
        'msg' => $msg
    ));
}

function validaFormato($tipo){
    if($tipo == 'pagamento_presencial'){
        return 0;
    }else if($tipo == 'pagamento_remoto'){
        return 1;
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST' ){

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $json = json_encode($dados);
    // file_put_contents('dados.json', $json);
    
    if(@$json){
        
        $nome_produto = $dados['nome_produto']; 
        $partnumber_produto = $dados['partnumber_produto'];
        $quantidade = $dados['quantidade'];
        $unidade = $dados['unidade'];
        $solicitante = $dados['solicitante']; 
        $fornecedor = $dados['fornecedor'];
        $categoria = $dados['categoria']; 
        $pagamento = $dados['pagamento'];
        $parcelas = $dados['parcelas']; 
        $pagamento_formato = $dados['pagamento_formato'];
        $preco_unitario = str_replace(',', '.', $dados['preco_unitario']); 
        $frete = str_replace(',', '.', $dados['frete']);
        $imposto = str_replace(',', '.', $dados['imposto']); 
        $site = $dados['site']; 
        $descricao = $dados['descricao']; 
        $data_compra = $dados['data_compra']; 
        $previsao_entrega = $dados['previsao_entrega'];
        $data_hoje = date('Y-m-d');
        if($data_hoje < $data_compra ){
            echo json_encode(array(
                'erro' => true,
                'msg' => 'Data da compra não pode ser maior que a data de hoje!'
            ));
            die();
        }

        $pagamento_formato = validaFormato($pagamento_formato);

        $id_categoria = getCategoria($categoria);
        $id_fornecedor = getFornecedor($fornecedor);
        $id_pagamento = getPagamento($pagamento);
        $id_solicitante = getSolicitante($solicitante);
        $id_unidade = getUnidade($unidade);

        
        // inserir na tabela compras    
        $sql = 
        "insert into compras(nome, partnumber, quantidade, site, valor_unitario, frete, imposto, parcelas, descricao, 
        data_compra, previsao_entrega, pagamento_remoto, pagamento_id, categoria_id, fornecedor_id, solicitante_id, unidade_id, engeline)
        values
        ('$nome_produto','$partnumber_produto', '$quantidade', '$site', '$preco_unitario', '$frete', '$imposto', '$parcelas',
        '$descricao', '$data_compra', '$previsao_entrega', '$pagamento_formato', '$id_pagamento', '$id_categoria','$id_fornecedor',
        '$id_solicitante', '$id_unidade', 1)";
        
        $query = mysqli_query($conexao, $sql); 
        $last_id = mysqli_insert_id($conexao);

        // inserir na tabela recebido para tratar posteriormente
        if($query){
            $insert = insertRecebidos($partnumber_produto, $last_id);
            if($insert){
                logCadastro($userSession, $nome_produto);
                echo json_encode(array(
                    'erro' => false,
                ));
                exit();
            }else{
                jsonEcho('erro na insert na tabela recebido');
            }
        }else{
            jsonEcho('query não executada');
        }
        
    }
}


