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
            ?>  
                
                <div class="card">
                    <div class="card-header">Retirada</div>
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
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="recebido" class="control-label mb-1">Recebido por</label>
                                        <?php
                                        
                                        if($recebido_id == ''){
                                            $sql = "SELECT * from integrantes order by nome asc";
                                        }else{
                                            $sql = "SELECT * from integrantes order by FIND_IN_SET(id, '$recebido_id') desc";
                                        }
                                        
                                        $query = mysqli_query($conexao, $sql);
                                        ?>
                                        <select name="recebido" id="recebido" class="form-control">
                                            <?php 
                                            while($array = mysqli_fetch_assoc($query)){
                                                $recebido = $array["nome"];
                                                echo "<option>$recebido</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="data_compra" class="control-label mb-1">Data da compra</label>
                                        <input id='data_compra' name='data_compra' type='date' class='form-control' value='<?=$data_compra?>' disabled>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="data_entrega" class="control-label mb-1">Data da entrega</label>
                                        <?php
                                        if($data_entrega == ''){
                                            echo '<input id="data_entrega" name="data_entrega" type="date" aria-required="true" class="form-control">';
                                        }else{
                                            echo "<input id='data_entrega' name='data_entrega' type='date'  aria-required='true' class='form-control' value='$data_entrega'>";    
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>            
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span>Editar</span>
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

    <div class="card">
                    <div class="card-header">Retirada</div>
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
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="recebido" class="control-label mb-1">Recebido por</label>
                                        <?php
                                        
                                        if($recebido_id == ''){
                                            $sql = "SELECT * from integrantes order by nome asc";
                                        }else{
                                            $sql = "SELECT * from integrantes order by FIND_IN_SET(id, '$recebido_id') desc";
                                        }
                                        
                                        $query = mysqli_query($conexao, $sql);
                                        ?>
                                        <select name="recebido" id="recebido" class="form-control">
                                            <?php 
                                            while($array = mysqli_fetch_assoc($query)){
                                                $recebido = $array["nome"];
                                                echo "<option>$recebido</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="data_compra" class="control-label mb-1">Data da compra</label>
                                        <input id='data_compra' name='data_compra' type='date' class='form-control' value='<?=$data_compra?>' disabled>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="data_entrega" class="control-label mb-1">Data da entrega</label>
                                        <?php
                                        if($data_entrega == ''){
                                            echo '<input id="data_entrega" name="data_entrega" type="date" aria-required="true" class="form-control">';
                                        }else{
                                            echo "<input id='data_entrega' name='data_entrega' type='date'  aria-required='true' class='form-control' value='$data_entrega'>";    
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>            
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span>Editar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

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
</script>
