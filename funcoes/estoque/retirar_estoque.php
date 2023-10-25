<style>
    .div-parcelas{
        display: none;
    }

    .ifpagamento_remoto{
        display: none;
    }
</style>
<?php
require '../../get_dados.php';  
require '../../conexao.php';  

function tempoEstoque($data){
    $dataEntrega = new DateTime($data);
    $dataNow = new DateTime(date('Y-m-d'));

    $diferença = $dataEntrega->diff($dataNow); 
    $dias = $diferença->days;

    return $dias;
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
    $id =  $_POST['id']; 
    if(isset($id)){
        $sql = "SELECT (SELECT partnumber from compras WHERE id = c.compra_id ) AS partnumber
            from estoque c where quantidade > 0 and id = $id";  
        $query = mysqli_query($conexao, $sql);

        $res = mysqli_fetch_array($query);
        $partnumber = $res['partnumber'];
        $sql = "SELECT c.id FROM compras c INNER JOIN estoque e ON c.id = e.compra_id WHERE c.partnumber = '$partnumber'";
        $query = mysqli_query($conexao, $sql);
        $count = mysqli_num_rows($query);

        if($count > 1){
            $sql = "SELECT e.id, e.quantidade, e.tempo_estoque, e.compra_id, e.local,
            (SELECT nome from compras where id = e.compra_id) AS nome,
            (SELECT partnumber from compras where id = e.compra_id) AS partnumber,
            (SELECT nome FROM categoria WHERE id = 
                (SELECT categoria_id from compras where id = e.compra_id)
            LIMIT 1) AS categoria,
            (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
            FROM estoque e where (e.quantidade > 0) and (SELECT partnumber from compras where id = e.compra_id) = '$partnumber'
            order BY (SELECT data_compra FROM compras WHERE id = e.compra_id) desc";
            $query = mysqli_query($conexao, $sql);
        ?>
        <div class="title-1">Escolha um dos produtos para executar a retirada </div>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>produto</th>
                        <th>partnumber</th>
                        <th>tempo estoque</th>
                        <th>quantidade</th>
                        <th>local</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php 
                if (mysqli_num_rows($query) > 0) {
                    while ($array = mysqli_fetch_array($query)) {

                        $id = $array['id'];
                        $partnumber = $array['partnumber'];
                        $compra_id = $array['compra_id'];
                        $quantidade = $array['quantidade'];
                        $data_entrega = $array['data_entrega'];
                        $nome = $array['nome'];
                        $categoria = $array['categoria'];
                        $local = $array['local'];

                        $dias = tempoEstoque($data_entrega);
                        $tempo_estoque = $array['tempo_estoque'];

                        echo "<tr class='tr-shadow'>
                            <td>$nome</td>
                            <td>
                                <span class='block-email'>$partnumber</span>
                            </td>
                            <td class='desc'>$tempo_estoque dias</td>
                            <td>$quantidade</td>
                            <td>$local</td>
                            <td>
                                <div class='table-data-feature'>
                                    <button class='item' data-toggle='tooltip' data-placement='top' title='Retirar' onclick='retirada($id)'>
                                        <i class='zmdi zmdi-mail-send'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class='spacer'></tr>";
                    }
                }else{
                    echo "<tr class='tr-shadow'>
                    <td>Sem resultados...</td>
                    <td>Sem resultados...</td>
                    <td>Sem resultados...</td>
                    <td>Sem resultados...</td>
                    <td>Sem resultados...</td>
                    <td>Sem resultados...</td>
                    </tr>
                    <tr class='spacer'></tr>";
                }
                ?>
                    
                </tbody>
            </table>
        </div>

            <?php 
        }else{
            $id = $_POST['id'];
            $sql = "SELECT e.quantidade, c.partnumber, c.nome, e.tempo_estoque FROM estoque e 
	            INNER JOIN compras c ON e.compra_id = c.id WHERE e.id = $id LIMIT 1 ";
            $query = mysqli_query($conexao, $sql);
            $array = mysqli_fetch_array($query);
            ?>  
                
                <div class="card">
                    <div class="card-header">Retirada</div>
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center">Você está retirando o produto: <?=$array['nome']?></h3>
                        </div>
                        <hr>
                        <form id="form_retirada_no_validation" method="post">
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
                                        <input id="nome_produto" name="nome_produto" class="form-control" disabled
                                        type="text" aria-required="true" aria-invalid="false" placeholder="Nome do produto" value="<?=$array['nome']?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="partnumber_produto" class="control-label mb-1">PartNumber</label>
                                        <input id="partnumber_produto" name="partnumber_produto" type="text" class="form-control" disabled
                                        aria-required="true" aria-invalid="false" placeholder="PartNumber do produto" value="<?=$array['partnumber']?>"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="quantidade" class="control-label mb-1">Quantidade em estoque</label>
                                        <input id="quantidade" name="quantidade" type="text" class="form-control" disabled
                                        aria-invalid="false" value="<?=$array['quantidade']?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="tempo_estoque" class="control-label mb-1">Tempo em estoque</label>
                                        <input id='tempo_estoque' name='tempo_estoque' type='text' class='form-control' value='<?=$array['tempo_estoque']?> dias' disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="retirado_por" class="control-label mb-1">Quem retirou?</label>
                                        <?php 
                                        $sql = "SELECT * from integrantes order by nome asc";
                                        $query = mysqli_query($conexao, $sql);
                                        ?>
                                        <select name="retirado_por" id="retirado_por" class="form-control" aria-required="true">
                                            <?php 
                                            while($array = mysqli_fetch_assoc($query)){
                                                $retirado = $array["nome"];
                                                echo "<option>$retirado</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="data_retirada" class="control-label mb-1">Data da retirada</label>
                                        <input id="data_retirada" name="data_retirada" type="date" class="form-control" aria-required="true" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="quantidade_retirada" class="control-label mb-1">Quantidade retirada</label>
                                        <input id="quantidade_retirada" name="quantidade_retirada" type="number" class="form-control"
                                        aria-required="true" aria-invalid="false" placeholder="Quantidade a ser retirada" onchange='comparacao(this.value)' required min="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="motivo_retirada" class="control-label mb-1">Motivo</label>
                                        <input id='motivo_retirada' name='motivo_retirada' type='text' class='form-control' 
                                        placeholder="Motivo da retirada" aria-required="true" required>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span>Retirar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php 
        }
    }
}else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['res']) && $_POST['res'] == true && isset($_POST['value'])){
    ?>

    <?php
}

?>

<script>
function retirada(id){
    Swal.fire({
        title: 'Alerta',
        text: "Você deseja ir para a tela de retirada?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
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
        }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(function() {
                window.location.href = "estoque?res=true&value=" + id;
            }, 200)
            
        }
    })
}

function comparacao(qt){
    var quantidade = document.getElementById('quantidade');
    var quantidaderetirada = document.getElementById('quantidade_retirada');

    if(parseInt(quantidaderetirada.value)  > parseInt(quantidade.value) ){
        quantidaderetirada.value = null;
        Swal.fire
        ({
            title: 'Erro!',
            text: 'Valor inserido maior que a  quantidade em estoque',
            icon: 'error',
            confirmButtonText: 'Ok :)'
        })
    }

    if(parseInt(quantidaderetirada.value) <= 0){
        quantidaderetirada.value = null;
        Swal.fire
        ({
            title: 'Erro!',
            text: 'Insira um valor maior que 0.',
            icon: 'error',
            confirmButtonText: 'Entendi'
        })
    } 

}
$(document).ready(function(){
    $('#form_retirada_no_validation').on("submit", function(event){
            event.preventDefault();

            $.ajax({
                method: "POST",
                url: "funcoes/estoque/backend_retirar.php",
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

                    if(json.erro === false){
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: json.msg,
                        })
                    }else if(json.erro === true){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: json.msg,
                        })
                    }
                    
                }
            })
        });
    });
</script>
