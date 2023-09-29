<?php include_once '../../conexao.php';?>
<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Procure uma compra" />
                    <button class="au-btn--submit" type="submit">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
            </div>
            <div class="table-data__tool-right">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                    <i class="zmdi zmdi-plus"></i>adicionar uma compra</button>
            </div>
        </div>
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead style="position: sticky; top: 0;">
                    <tr>
                        <th>Nome</th>
                        <th>PartNumber</th>
                        <th>Data da Compra</th>
                        <th>Status</th>
                        <th>Preço total</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php 
                    
                    $sql = "SELECT 
                            e.id, e.nome, e.valor_unitario, e.frete, e.imposto, e.parcelas, e.quantidade, 
                            e.site, e.descricao, e.data_compra, e.previsao_entrega, e.partnumber, 
                            (SELECT nome FROM pagamentos WHERE id = e.pagamento_id ) AS pagamento_id, 
                            (SELECT nome FROM categoria WHERE id = e.categoria_id) AS categoria_id, 
                            (SELECT nome FROM fornecedor WHERE id = e.fornecedor_id) AS fornecedor_id, 
                            (SELECT nome FROM integrantes WHERE id = e.solicitante_id) AS solicitante_id, 
                            (SELECT nome FROM integrantes WHERE id = e.recebido_id) AS recebido_id,
                            IFNULL((SELECT data_entrega FROM recebidos WHERE compra_id = e.id), 0) AS ifnullresult
                            
                            FROM compras e ";
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
                        
                        if(strtotime(date('Y-m-d')) > strtotime($previsao_entrega) && $entregue == 0){
                            $status = 'Atrasado';
                        }else{
                            $status = 'Recebido';
                        }
                        
                        echo "<tr class='table-row' data-toggle='modal' data-target='#myModal-$id'>";
                            echo "<td> $nome </td>";
                            echo "<td> $partnumber </td>";
                            echo "<td> $data_compra </td>";
                            echo "<td> $status </td>";
                            echo '<td> R$'. number_format($preco_total, 2, ',', '.').'</td>';
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
                                            <?php echo date('d/m/Y',strtotime($data_compra))?>
                                        </div>
                                        <div class="event-info">
                                            <label class="col-sm-2 col-form-label"><strong>Previsão Entrega:</strong></label>
                                            <?php echo date('d/m/Y',strtotime($previsao_entrega))?>
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
                                            <?=$recebido?>
                                        </div>
                                        <div class="event-info">
                                            <label class="col-sm-2 col-form-label"><strong>Descrição:</strong></label>
                                            <?=$descricao?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button class="btn btn-warning btn-vis-edit">Editar</button> -->
                                        <button class="btn btn-danger btn-delete" onclick="deletaCompra('<?=$id?>', '<?=$nome?>')">Deletar</button>
                                        <button class="btn btn-warning btn-vis-edit" onclick="editaCompra('<?=$id?>')">Editar</button>
                                        <button type="button" class="btn btn-primary btn-canc-edit" data-dismiss="modal">Cancelar</button>
                                        
                                        <!-- <button type="button" class="btn btn-primary">Confirm</button> -->
                                    </div>
                                </div>
                            </div>
                        </div> <?php 
                    }
                ?>
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>