<?php include_once '../../conexao.php';?>

        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead style="position: sticky; top: 0;">
                    <tr>
                        <th>Nome</th>
                        <th>PartNumber</th>
                        <th>Data da Compra</th>
                        <th>Status</th>
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
                            WHERE categoria_id = (SELECT id FROM categoria WHERE nome LIKE '%$search%' LIMIT 1)
                            or  nome LIKE '%$search%' 
                            OR partnumber LIKE '%$search%' order by data_compra desc
                        ";
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
                            
                            FROM compras e order by data_compra desc ";
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
                        
                        if(strtotime(date('Y-m-d')) > strtotime($previsao_entrega) && $entregue == 0){
                            $status = 'Atrasado';
                        }else{
                            $status = 'Recebido';
                        }
                        
                        echo "<tr class='table-row'>";
                            echo "<td data-toggle='modal' data-target='#myModal-$id'> $nome </td>";
                            echo "<td data-toggle='modal' data-target='#myModal-$id'> $partnumber </td>";
                            echo "<td data-toggle='modal' data-target='#myModal-$id'> $data_compra </td>";
                            echo "<td data-toggle='modal' data-target='#myModal-$id'> $status </td>";
                            echo '<td> R$'. number_format($preco_total, 2, ',', '.').'</td>';
                            echo '<td>
                                    <div class="table-data-feature">
                                        <a href="compras?edit='.$id.'"> 
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>';
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
        </div>
        <!-- END DATA TABLE-->


<script>

    $('.au-btn--small').on("click", function(){
        Swal.fire({
            title: 'Alerta',
            text: "Você deseja ir para o cadastro de compra?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
            }).then((result) => {
            if (result.isConfirmed) {
                setTimeout(function() {
                    window.location.href = "compras?cadastro";
                }, 200)
                
            }
            })
    });

</script>