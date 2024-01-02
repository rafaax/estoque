<?php include_once '../../conexao.php';

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);
if($pagina == null){
    $pagina = 1;
}
$quantidade_por_pagina = 10;
$inicio = ($pagina * $quantidade_por_pagina) - $quantidade_por_pagina;

?>

<style>

.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}

.center {
  text-align: center;
}

</style>
<div class="table-responsive m-b-40"> 
    <table class="table table-borderless table-data3" id="tabela_compras" >
        <thead style="position: sticky; top: 0;">
            <tr>
                <th>Nome</th>
                <th>PartNumber</th>
                <th>Data da Compra</th>
                <th>Preço total</th>
                <th></th>
            </tr>
        </thead> 
        <tbody>
            <?php 
            
            if(isset($_POST["query"]))
            {
                $search = mysqli_real_escape_string($conexao, $_POST["query"]);
                $sql = "SELECT 
                    e.id, e.nome, e.valor_unitario, e.frete, e.imposto, e.parcelas, e.quantidade, 
                    e.site, e.descricao, e.data_compra, e.previsao_entrega, e.partnumber, 
                    (SELECT nome FROM pagamentos WHERE id = e.pagamento_id ) AS pagamento_id, 
                    (SELECT nome FROM categoria WHERE id = e.categoria_id) AS categoria_id, 
                    (SELECT nome FROM fornecedor WHERE id = e.fornecedor_id) AS fornecedor_id, 
                    (SELECT nome FROM integrantes WHERE id = e.solicitante_id) AS solicitante_id, 
                    (SELECT nome FROM integrantes WHERE id = e.recebido_id) AS recebido_id,
                    IFNULL((SELECT data_entrega FROM recebidos WHERE compra_id = e.id), 0) AS ifnullresult
                    FROM compras e
                    WHERE engeline = 1 
                    and  (categoria_id = (SELECT id FROM categoria WHERE nome LIKE '%$search%' LIMIT 1)
                    or  nome LIKE '%$search%' 
                    OR partnumber LIKE '%$search%') order by data_compra desc
                ";
            }else if(isset($_POST["filter"])){
                
                list($ano, $mes) = explode('-', $_POST['filter']);

                $sql = "SELECT 
                    e.id, e.nome, e.valor_unitario, e.frete, e.imposto, e.parcelas, e.quantidade, 
                    e.site, e.descricao, e.data_compra, e.previsao_entrega, e.partnumber, 
                    (SELECT nome FROM pagamentos WHERE id = e.pagamento_id ) AS pagamento_id, 
                    (SELECT nome FROM categoria WHERE id = e.categoria_id) AS categoria_id, 
                    (SELECT nome FROM fornecedor WHERE id = e.fornecedor_id) AS fornecedor_id, 
                    (SELECT nome FROM integrantes WHERE id = e.solicitante_id) AS solicitante_id, 
                    (SELECT nome FROM integrantes WHERE id = e.recebido_id) AS recebido_id,
                    IFNULL((SELECT data_entrega FROM recebidos WHERE compra_id = e.id), 0) AS ifnullresult
                    FROM compras e where engeline = 1 and (year(data_compra) = '$ano' and month(data_compra) = '$mes')
                    order by data_compra desc limit $inicio, $quantidade_por_pagina ";

            }
            else
            {
                $sql = "SELECT 
                    e.id, e.nome, e.valor_unitario, e.frete, e.imposto, e.parcelas, e.quantidade, 
                    e.site, e.descricao, e.data_compra, e.previsao_entrega, e.partnumber, 
                    (SELECT nome FROM pagamentos WHERE id = e.pagamento_id ) AS pagamento_id, 
                    (SELECT nome FROM categoria WHERE id = e.categoria_id) AS categoria_id, 
                    (SELECT nome FROM fornecedor WHERE id = e.fornecedor_id) AS fornecedor_id, 
                    (SELECT nome FROM integrantes WHERE id = e.solicitante_id) AS solicitante_id, 
                    (SELECT nome FROM integrantes WHERE id = e.recebido_id) AS recebido_id,
                    IFNULL((SELECT data_entrega FROM recebidos WHERE compra_id = e.id), 0) AS ifnullresult
                    FROM compras e where engeline = 1 order by data_compra desc limit $inicio, $quantidade_por_pagina ";
            }

            $query = mysqli_query($conexao, $sql);

            while ($array = mysqli_fetch_array($query)) {
                
                $id = $array['id'];
                $nome = $array['nome'];
                $partnumber = $array['partnumber']; 
                $data_compra = $array['data_compra'];
                $data_compra = date('d/m/Y',strtotime($data_compra));
                $recebido = $array['recebido_id'];
                $previsao_entrega = $array['previsao_entrega'];
                $parcelas = $array['parcelas'];
                $frete = $array['frete'];
                $valor_un = $array['valor_unitario'];
                $imposto = $array['imposto'];
                $quantidade = $array['quantidade'];
                $entregue = $array['ifnullresult'];
                $descricao = $array['descricao'];
                $fornecedor = $array['fornecedor_id'];
                $categoria = $array['categoria_id'];
                $pagamento = $array['pagamento_id'];
                $solicitante =$array['solicitante_id'];
                $recebido = $array['recebido_id'];

                $preco_total = ($valor_un * $quantidade) + $frete + $imposto;
                
                if($previsao_entrega != '0000-00-00'){
                    if(strtotime(date('Y-m-d')) > strtotime($previsao_entrega) && $entregue == 0){
                        $status = 'Atrasado';
                    }else if(strtotime(date('Y-m-d')) < strtotime($previsao_entrega) && $entregue == 0){
                        $status = 'Ainda não entregue';
                    }else{
                        $status = 'Recebido';
                    }
                }else{
                    if($entregue == 0){
                        $status = 'Ainda não entregue';
                    }else{
                        $status = 'Recebido';    
                    }
                }
                
                echo "<tr class='table-row'>";
                    echo "<td data-toggle='modal' data-target='#myModal-$id'> $nome </td>";
                    echo "<td data-toggle='modal' data-target='#myModal-$id'> $partnumber </td>";
                    echo "<td data-toggle='modal' data-target='#myModal-$id'> $data_compra </td>";
                    echo '<td> R$'. number_format($preco_total, 2, ',', '.').'</td>';
                    ?><td>
                            <div class="table-data-feature">

                                
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Enviar compra para vetorian"
                                onclick="redirecionarCompra('<?=$id?>', '<?=trim($nome)?>')">
                                    <i class="zmdi zmdi-mail-reply"></i>
                                </button>

                                <a href="compras?edit=<?=$id?>"> 
                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="zmdi zmdi-edit"></i>
                                    </button>
                                </a>

                                <a href="compras?nota=<?=$id?>">
                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Inserir nota fiscal">
                                        <i class="zmdi zmdi-archive"></i>
                                    </button>
                                </a>

                                <button class="item" data-toggle="tooltip" data-placement="top" 
                                onclick="deletaCompra('<?=$id?>', '<?=trim($nome)?>')" title="Delete">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </div>
                        </td>
                        <?php 
                echo "</tr>";

                ?>
                <div class="modal fade" id="myModal-<?=$id?>" role="dialog" data-bs-focus="false" aria-labelledby="myModalLabel-<?=$id?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">  
                                <h5 class="modal-title" id="myModalLabel-<?=$id?>">Informações da Compra</h5>
                            </div>
                            <div class="modal-body">
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Nome:</strong></label>
                                    <?=$nome?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>PartNumber:</strong></label>
                                    <?=$partnumber?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Data da Compra:</strong></label>
                                    <?php echo $data_compra?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Previsão Entrega:</strong></label>
                                    <?php
                                    
                                    if($previsao_entrega == '0000-00-00' || $previsao_entrega == NULL){
                                        echo 'Não foi inserido uma previsão de entrega';
                                    }else{
                                        echo date('d/m/Y',strtotime($previsao_entrega));
                                    } ?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Forma de Pagamento:</strong></label>
                                    <?=$pagamento?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Fornecedor:</strong></label>
                                    <?=$fornecedor?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Solicitante:</strong></label>
                                    <?=$solicitante?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Recebido:</strong></label>
                                    <?php
                                    
                                    if($recebido == NULL){
                                        echo 'Produto ainda não foi recebido';
                                    }else{
                                        echo $recebido;
                                    }
                                    
                                    ?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Descrição:</strong></label>
                                    <?php 
                                    if($descricao == NULL){
                                        echo 'Não foi inserido descrição para esta compra.';
                                    }else{
                                        echo $descricao;
                                    }
                                    ?>
                                </div>
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Nota Fiscal:</strong></label>
                                    <?php 
                                    $sqlNota = "SELECT path from notas_fiscais where compra_id = $id ";
                                    $queryNota = mysqli_query($conexao, $sqlNota);
                                    $resultNota = mysqli_fetch_assoc($queryNota);
                                    $resultNotaQnt = mysqli_num_rows($queryNota);
                                    
                                    if($resultNotaQnt >= 1 ){
                                        $path_nota = $resultNota['path'];
                                        echo '<a target="_blank" href="'. $path_nota. '">
                                        <input type="submit" value="NF" onclick="valida('.$path_nota. ');">
                                        </a>';
                                    }else{
                                        $path_nota = '';
                                        echo "<input type='submit' value='NF' onclick='valida($path_nota)'>";
                                    }?>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <!-- <button class="btn btn-warning btn-vis-edit">Editar</button> -->
                                <button type="button" class="btn btn-primary btn-canc-edit" data-dismiss="modal">Voltar</button>
                                <!-- <button type="button" class="btn btn-primary">Confirm</button> -->
                            </div>
                        </div>
                    </div>
                </div> <?php 
            }
        ?>
        </tbody>
    </table>
    <?php
    
    $query_pg = "SELECT COUNT(id) AS num_result FROM compras where engeline = 1";
    $result_pg = mysqli_query($conexao, $query_pg);
    $row_pg = mysqli_fetch_assoc($result_pg);

    $quantidade_pg = ceil($row_pg['num_result'] / $quantidade_por_pagina);
    $max_links = 2;
    ?>

    <div class="center">
        <div class="pagination">
            
            <a href="#" class="page-link" onclick="listarUsuarios(1)">&laquo;</a>
            <?php 
            for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
                if($pag_ant >= 1){
                    echo "<a class='page-link' href='#' onclick='listarUsuarios($pag_ant)' >$pag_ant</a>";
                }        
            }
            echo "<a class='page-link active' href='#'>$pagina</a>";

            for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
                if($pag_dep <= $quantidade_pg){
                    echo "<a class='page-link' href='#' onclick='listarUsuarios($pag_dep)'>$pag_dep</a>";
                }        
            }
            echo "<a href='#' class='page-link' onclick='listarUsuarios($quantidade_pg)'>&raquo;</a>";
        
        ?>
        </div>
    </div>
</div>