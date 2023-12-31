<?php 
require '../../get_dados.php';
require '../../conexao.php';
?>

<style>
    .div-parcelas{
        display: none;
    }

    .ifpagamento_remoto{
        display: none;
    }
</style>
<div class="card">
    <div class="card-header">Cadastro de Compra</div>
    <div class="card-body">
        <form id="form_cadastro" method="post">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="nome_produto" class="control-label mb-1">Nome Produto</label>
                        <input id="nome_produto" name="nome_produto" class="form-control"
                        type="text" aria-required="true" aria-invalid="false" placeholder="Nome do produto" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="partnumber_produto" class="control-label mb-1">PartNumber</label>
                        <input id="partnumber_produto" name="partnumber_produto" type="text" class="form-control"
                        aria-required="true" aria-invalid="false" placeholder="PartNumber do produto" required> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="quantidade" class="control-label mb-1">Quantidade</label>
                        <input id="quantidade" name="quantidade" class="form-control"
                        type="number" aria-required="true" aria-invalid="false" min="1" placeholder="Quantidade" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="unidade" class="control-label mb-1">Unidade</label>
                        <?php 
                        $sql = "SELECT * from unidade order by id asc ";
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
                        $sql = "SELECT * from integrantes order by nome asc";
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
                        $sql = "SELECT id, nome from fornecedor order by nome asc ";
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
                        $sql = "SELECT * from categoria order by nome asc";
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
                        $sql = "SELECT id, nome from pagamentos order by nome asc ";
                        $query = mysqli_query($conexao, $sql);
                        ?>
                        <select name="pagamento" id="pagamento" class="form-control">
                            <?php 
                            while($array = mysqli_fetch_assoc($query)){
                                $pagamento = $array["nome"];
                                echo "<option>$pagamento</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group div-parcelas" id="div-parcelas">
                <label for="parcelas" class="control-label mb-1">Parcelas</label>
                <input id="parcelas" name="parcelas" type="number" class="form-control" 
                placeholder="Digite o total de parcelas da compra" min="1" max="24">
            </div>

            <div class="form-group">
                <label for="pagamento_formato" class="control-label mb-1">Pagamento</label>
                <select name="pagamento_formato" id="pagamento_formato" class="form-control">
                    <option value="pagamento_presencial">Presencial</option>
                    <option value="pagamento_remoto">Internet</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="preco_unitario" class="control-label mb-1">Preço unitário</label>
                <input id="preco_unitario" name="preco_unitario" type="text" class="form-control" min="0"
                placeholder="Digite o preço unitário do produto" required>
            </div>


            <div id="div-frete-imposto" class="ifpagamento_remoto">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="frete" class="control-label mb-1">Frete</label>
                            <input id="frete" name="frete" type="text" class="form-control" min="0"
                            placeholder="Digite o valor do frete">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="imposto" class="control-label mb-1">Imposto</label>
                            <input id="imposto" name="imposto" type="text" class="form-control"  min="0"
                            placeholder="Digite o valor do imposto">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="site" class="control-label mb-1">Site</label>
                    <input id="site" name="site" type="text" class="form-control"
                    aria-required="true" aria-invalid="false" placeholder="Site que foi comprado"> 
                </div>
            </div>
            <div class="form-group">
                <label for="descricao" class=" form-control-label">Descrição</label>
                <textarea name="descricao" id="descricao" rows="5" placeholder="Descricao do produto..." class="form-control"></textarea>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="data_compra" class="control-label mb-1">Data de Compra</label>
                        <input id="data_compra" name="data_compra" type="date" class="form-control" required>
                    </div>
                </div>
                    <div class="col-6">
                        <div id="previsao-entrega" class="ifpagamento_remoto">
                            <div class="form-group">
                                <label for="previsao_entrega" class="control-label mb-1">Previsão de entrega</label>
                                <input id="previsao_entrega" name="previsao_entrega" type="date" class="form-control">
                            </div>
                        </div>
                    </div>
            </div>
            
            <div>
                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                    <span>Cadastrar</span>
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
        var valor = this.value;
        // console.log(valor);
        if(valor == 'Cartão crédito'){
            y.style.display = 'block';
        }else{
            y.style.display = 'none';
        }
    });

    $('#pagamento_formato').on('change', function() {
        var y = document.getElementById('div-frete-imposto');
        var x = document.getElementById('previsao-entrega');
        var valor = this.value;
        console.log(valor);
        if(valor == 'pagamento_remoto'){
            y.style.display = 'block';
            x.style.display = 'block';
        }else{
            y.style.display = 'none';
            x.style.display = 'none';
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

    $('#form_cadastro').on("submit", function(event){
        event.preventDefault();

        $.ajax({
            method: "POST",
            url: "funcoes/compras/backend_cadastro.php",
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: function () {
                Swal.fire({
                    title: 'Aguarde...',
                    text: 'Cadastrando evento...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (result) {
                console.log(result);
                var json = JSON.parse(result);
                Swal.close();
                if(json.erro == false){
                    Swal.fire({
                        title: 'Compra cadastrada!',
                        html: 'A página se auto-reiniciará em 3 segundos.',
                        icon: 'success',
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    })
                    setTimeout(function() {
                        window.location.href = "http://127.0.0.1/estoque_git/compras"
                    }, 3000)
                }else if(json.erro == true){
                    Swal.fire({
                        title: json.msg,
                        icon: 'error',
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
    });

})
</script>