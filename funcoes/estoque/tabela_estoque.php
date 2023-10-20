<?php include_once '../../conexao.php';

function tempoEstoque($data){
    $dataEntrega = new DateTime($data);
    $dataNow = new DateTime(date('Y-m-d'));

    // $dataEntrega = $dataEntrega->format('Y-m-d'); 
    // $dataNow = $dataNow->format('Y-m-d');

    $diferença = $dataEntrega->diff($dataNow); 
    $dias = $diferença->days;

    return $dias;
}

function updateTempoEstoque($id, $dias){
    require '../../conexao.php';

    $sql = "UPDATE estoque set tempo_estoque = '$dias' where id = $id";
    mysqli_query($conexao, $sql);

}


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
<?php 
if(isset($_POST["query"]))
    {
        $search = mysqli_real_escape_string($conexao, $_POST["query"]);
        $sql = "SELECT e.id, e.quantidade, e.tempo_estoque, e.compra_id, e.local, c.nome, c.partnumber, 
            (SELECT nome FROM categoria WHERE id = 
                (SELECT categoria_id from compras where id = e.compra_id) LIMIT 1) AS categoria,
            (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
            FROM estoque e inner join compras c on c.id = e.compra_id where (c.nome LIKE '%$search%')
            order BY (SELECT data_compra FROM compras WHERE id = e.compra_id) desc limit $inicio, $quantidade_por_pagina";
    }
    else
    {
        $sql = "SELECT e.id, e.quantidade, e.tempo_estoque, e.compra_id, e.local,
        (SELECT nome from compras where id = e.compra_id) AS nome,
        (SELECT partnumber from compras where id = e.compra_id) AS partnumber,
        (SELECT nome FROM categoria WHERE id = 
            (SELECT categoria_id from compras where id = e.compra_id)
        LIMIT 1) AS categoria,
        (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
        FROM estoque e
        order BY (SELECT data_compra FROM compras WHERE id = e.compra_id) desc limit $inicio, $quantidade_por_pagina ";
    }
    
    $query = mysqli_query($conexao, $sql);


    ?>



<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">data table</h3>
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <div class="form-header">
                    <input class="au-input au-input--xl" type="text" name="search" id="searchEstoque" placeholder="Procure uma compra" />
                    <button class="au-btn--submit" id="buttonClear">
                        <i class="zmdi zmdi-close"></i>
                    </button>
                </div>
            </div>
            <div class="table-data__tool-right">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                    <i class="zmdi zmdi-open-in-new"></i>EXPORTAR PARA EXCEL
                </button>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>produto</th>
                        <th>partnumber</th>
                        <th>categoria</th>
                        <th>tempo estoque</th>
                        <th>local</th>
                        <th></th>
                    </tr>
                </thead>

                
                <tbody>
                <?php 

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
                    updateTempoEstoque($id, $dias);
                    $tempo_estoque = $array['tempo_estoque'];

                    echo "<tr class='tr-shadow'>
                        <td>$nome</td>
                        <td>
                            <span class='block-email'>$partnumber</span>
                        </td>
                        <td class='desc'>$categoria</td>
                        <td>$tempo_estoque</td>
                        <td>$local</td>
                        <td>
                            <div class='table-data-feature'>
                                <button class='item' data-toggle='tooltip' data-placement='top' title='Send'>
                                    <i class='zmdi zmdi-mail-send'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class='spacer'></tr>";
                }    
                ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- caso queira escrever algo -->
    </div>
</div>