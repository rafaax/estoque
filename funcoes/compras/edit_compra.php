<?php 
require '../../get_dados.php';
require '../../conexao.php';

$id =  $_POST['id'];
?>
<style>
    .div-parcelas{
        display: none;
    }

    .ifpagamento_remoto{
        display: none;
    }
</style>
<?php 
    $sql = "SELECT * FROM compras  WHERE id = $id limit 1";
    $query = mysqli_query($conexao,$sql);
    $array = mysqli_fetch_assoc($query);

    $unidade = $array['unidade_id'];
    $solicitante = $array['solicitante_id'];
    $fornecedor = $array['fornecedor_id'];
    $pagamento = $array['pagamento_id'];
    $categoria = $array['categoria_id'];
    $pagamento_remoto = $array['pagamento_remoto'];
    $parcelas = $array['parcelas'];
    $descricao = $array['descricao'];
    $imposto = $array['imposto']; 
    $frete = $array['frete'];
    $valor_unitario = $array['valor_unitario'];
    $site = $array['site'];
    $data_compra = $array['data_compra'];
    $previsao_entrega = $array['previsao_entrega'];


?>
<div class="card">
    <div class="card-header">Editar a compra</div>
    <div class="card-body">
        <div class="card-title">
            <h3 class="text-center"><?=$array['nome']?></h3>
        </div>
        <hr>
        <form id="form_edit" method="post">
            <div class="row">
                <div style="display: none;">
                    <div class="form-group">
                        <label for="id_produto" class="control-label mb-1">Id Produto</label>
                        <input id="id_produto" name="id_produto" class="form-control"
                        type="text" value="<?=$id?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="nome_produto" class="control-label mb-1">Nome Produto</label>
                        <input id="nome_produto" name="nome_produto" class="form-control"
                        type="text" aria-required="true" aria-invalid="false" placeholder="Nome do produto" value="<?=$array['nome']?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="partnumber_produto" class="control-label mb-1">PartNumber</label>
                        <input id="partnumber_produto" name="partnumber_produto" type="text" class="form-control"
                        aria-required="true" aria-invalid="false" placeholder="PartNumber do produto" value="<?=$array['partnumber']?>"> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="quantidade" class="control-label mb-1">Quantidade</label>
                        <input id="quantidade" name="quantidade" class="form-control"
                        type="number" aria-required="true" aria-invalid="false" min="1" placeholder="Quantidade" value="<?=$array['quantidade']?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="unidade" class="control-label mb-1">Unidade</label>
                        <?php 
                        
                        $sql = "SELECT * from unidade order by FIND_IN_SET(id, '$unidade') desc, nome asc ";
                        $query = mysqli_query($conexao, $sql);
                        ?>
                        <select name="unidade" id="unidade" class="form-control">
                            <?php 
                            while($array = mysqli_fetch_assoc($query)){
                                $unidade = $array["nome"];
                                echo "<option>$unidade</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="solicitante" class="control-label mb-1">Solicitante</label>
                        <?php 
                        $sql = "SELECT * from integrantes order by FIND_IN_SET(id, '$solicitante')desc, nome asc";
                        $query = mysqli_query($conexao, $sql);
                        ?>
                        <select name="solicitante" id="solicitante" class="form-control">
                            <?php 
                            while($array = mysqli_fetch_assoc($query)){
                                $solicitante = $array["nome"];
                                echo "<option>$solicitante</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="fornecedor" class="control-label mb-1">Fornecedor</label>
                        <?php 
                        $sql = "SELECT id, nome from fornecedor order by FIND_IN_SET(id, '$fornecedor')desc, nome asc";
                        $query = mysqli_query($conexao, $sql);
                        ?>
                        <select name="fornecedor" id="fornecedor" class="form-control">
                            <?php 
                            while($array = mysqli_fetch_assoc($query)){
                                $fornecedor = $array["nome"];
                                echo "<option>$fornecedor</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="categoria" class="control-label mb-1">Categoria</label>
                        <?php 
                        $sql = "SELECT * from categoria order by FIND_IN_SET(id, '$categoria')desc, nome asc";
                        $query = mysqli_query($conexao, $sql);
                        ?>
                        <select name="categoria" id="categoria" class="form-control">
                            <?php 
                            while($array = mysqli_fetch_assoc($query)){
                                $categoria = $array["nome"];
                                echo "<option>$categoria</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="pagamento" class="control-label mb-1">Forma de Pagamento</label>
                        <?php 
                        $sql = "SELECT id, nome from pagamentos order by FIND_IN_SET(id, '$pagamento')desc, nome asc";
                        $query = mysqli_query($conexao, $sql);
                        ?>
                        <select name="pagamento" id="pagamento" class="form-control">
                            <?php 
                            while($array = mysqli_fetch_assoc($query)){
                                $pagamento_tipo = $array["nome"];
                                echo "<option>$pagamento_tipo</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php
                if($pagamento == 1){
                    ?>
                        <label for="parcelas" class="control-label mb-1">Parcelas</label>
                        <input id="parcelas" name="parcelas" type="number" class="form-control" 
                        placeholder="Digite o total de parcelas da compra" min="1" max="24" value="<?=$parcelas?>">
                <?php }else{
                    ?>
                    <div class="form-group div-parcelas" id="div-parcelas">
                        <label for="parcelas" class="control-label mb-1">Parcelas</label>
                        <input id="parcelas" name="parcelas" type="number" class="form-control" 
                        placeholder="Digite o total de parcelas da compra" min="1" max="24">
                    </div>    
                <?php } ?>
            

            <div class="form-group">
                <label for="pagamento_formato" class="control-label mb-1">Pagamento</label>
                <select name="pagamento_formato" id="pagamento_formato" disabled="" class="form-control">
                    <option value="pagamento_presencial">Presencial</option>
                    <?php 
                    if($pagamento_remoto == 1){
                        echo '<option value="pagamento_remoto" selected="selected">Internet</option>';
                    }else{
                        echo '<option value="pagamento_remoto">Internet</option>';
                    }
                    ?>
                    
                    
                </select>
            </div>
            
            <div class="form-group">
                <label for="preco_unitario" class="control-label mb-1">Preço unitário</label>
                <input id="preco_unitario" name="preco_unitario" type="text" class="form-control" min="0"
                placeholder="Digite o preço unitário do produto" value="<?=$valor_unitario?>">
            </div>


            <?php 

            if($pagamento_remoto == 1){
                ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="frete" class="control-label mb-1">Frete</label>
                            <input id="frete" name="frete" type="text" class="form-control" min="0"
                            placeholder="Digite o valor do frete" value="<?=$frete?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="imposto" class="control-label mb-1">Imposto</label>
                            <input id="imposto" name="imposto" type="text" class="form-control"  min="0"
                            placeholder="Digite o valor do imposto" value="<?=$imposto?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="site" class="control-label mb-1">Site</label>
                    <input id="site" name="site" type="text" class="form-control"
                    aria-required="true" aria-invalid="false" placeholder="Site que foi comprado" value="<?=$site?>"> 
                </div>
            <?php }?>

            <div class="form-group">
                <label for="descricao" class=" form-control-label">Descrição</label>
                <textarea name="descricao" id="descricao" rows="5" placeholder="Descricao do produto..." class="form-control" 
                value="<?=$descricao?>"></textarea>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="data_compra" class="control-label mb-1">Data de Compra</label>
                        <input id="data_compra" name="data_compra" type="date" class="form-control" value="<?=$data_compra?>">
                    </div>
                </div>
                
                <div class="col-6">
                    <?php if($pagamento_remoto == 1){ ?>
                    <div class="form-group">
                        <label for="previsao_entrega" class="control-label mb-1">Previsão de entrega</label>
                        <?php 
                        if($previsao_entrega != '0000-00-00'){
                            echo "<input id='previsao_entrega' name='previsao_entrega' type='date' class='form-control' value='$previsao_entrega'>";
                        }else{
                            echo "<input id='previsao_entrega' name='previsao_entrega' type='date' class='form-control'>";
                        }
                        ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            
            <div>
                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                    <span>Editar</span>
                    <i class="zmdi zmdi-check"></i>&nbsp;
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#partnumber_produto').typeahead({
        source: function(query, result)
        {
            $.ajax({
                url: "funcoes/compras/typeahead_compras.php",
                method: "POST",
                data:{query:query},
                dataType:"json",
                success:function(data){
                    result($.map(data, function(item){

                        return item;
                    }));
                }
            })
        }
    });

    $('#pagamento').on('change', function() {
        var y = document.getElementById('div-parcelas');
        var x = document.getElementById('parcelas');
        var valor = this.value;

        if(valor == 'Cartão crédito'){
            y.style.display = 'block';
        }else{
            x.value = '';
            y.style.display = 'none';
        }
    });

    $('#pagamento_formato').on('change', function() {
        var y = document.getElementById('div-frete-imposto');
        var valor = this.value;

        if(valor == 'pagamento_remoto'){
            y.style.display = 'block';
        }else{
            y.style.display = 'none';
        }
    });

    $('#preco_unitario').on('input', function(){

        var text = $(this).val();
        var newText = text.replace(/[^0-9,]/g, '');

        
        $(this).val(newText);

    })
    
    $('#frete').on('input', function(){

        var text = $(this).val();
        var newText = text.replace(/[^0-9,]/g, '');

        
        $(this).val(newText);

    })

    $('#imposto').on('input', function(){

        var text = $(this).val();
        var newText = text.replace(/[^0-9,]/g, '');

        
        $(this).val(newText);

    })

    $('#form_edit').on("submit", function(event){
        event.preventDefault();
        Swal.fire({
            title: 'Alerta',
            text: "Você deseja editar a compra? Os dados pré-edição serão perdidos!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        url: "funcoes/compras/backend_edit.php",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Aguarde...',
                                text: 'Editando evento...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function (result) {
                            Swal.close();
                            var json = JSON.parse(result);
                            if(json.erro == false){
                                let timerInterval
                                Swal.fire({
                                icon: 'success',                                    
                                title: 'Compra Atualizada!',
                                html: 'Fechando em <b></b>  milisegundos',
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                            window.location.href = "http://127.0.0.1/estoque_git/compras"
                                    }
                                })
                            }else if(json.erro == true){
                                Swal.fire({
                                    title: json.msg,
                                    allowOutsideClick: () => {
                                        const popup = Swal.getPopup()
                                        popup.classList.remove('swal2-show')
                                        setTimeout(() => {
                                        popup.classList.add('animate__animated', 'animate__headShake')
                                        })
                                        setTimeout(() => {
                                        popup.classList.remove('animate__animated', 'animate__headShake')
                                        }, 500)
                                        return false
                                    }
                                })

                            }
                        }
                    })
                }
            })
    });

})
</script>