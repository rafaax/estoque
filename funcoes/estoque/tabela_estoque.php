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
$quantidade_por_pagina = 20;
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
if(isset($_POST["query"])){
    $search = mysqli_real_escape_string($conexao, $_POST["query"]);
    $sql = "SELECT e.id, SUM(e.quantidade) as quantidade, e.tempo_estoque, e.compra_id, e.local, c.nome, c.partnumber, 
        (SELECT nome FROM categoria WHERE id = 
            (SELECT categoria_id from compras where id = e.compra_id) LIMIT 1) AS categoria,
        (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
        FROM estoque e inner join compras c on c.id = e.compra_id where (c.nome LIKE '%$search%') and (e.quantidade > 0) GROUP BY partnumber
        order BY (SELECT data_compra FROM compras WHERE id = e.compra_id) desc limit $inicio, $quantidade_por_pagina";
}else if(isset($_POST['filter'])){
    // file_put_contents('logfilter.txt', $_POST['filter']);
    if($_POST['filter'] == 'qntmaior'){

        $sql = "SELECT e.id, SUM(e.quantidade) as quantidade, e.tempo_estoque, e.compra_id, e.local,
        (SELECT nome from compras where id = e.compra_id) AS nome,
        (SELECT partnumber from compras where id = e.compra_id) AS partnumber,
        (SELECT nome FROM categoria WHERE id = 
            (SELECT categoria_id from compras where id = e.compra_id)
        LIMIT 1) AS categoria,
        (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
        FROM estoque e where (e.quantidade > 0) GROUP BY partnumber
        order BY e.quantidade desc limit $inicio, $quantidade_por_pagina ";

    }else if($_POST['filter'] == 'qntmenor'){

        $sql = "SELECT e.id, SUM(e.quantidade) as quantidade, e.tempo_estoque, e.compra_id, e.local,
        (SELECT nome from compras where id = e.compra_id) AS nome,
        (SELECT partnumber from compras where id = e.compra_id) AS partnumber,
        (SELECT nome FROM categoria WHERE id = 
            (SELECT categoria_id from compras where id = e.compra_id)
        LIMIT 1) AS categoria,
        (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
        FROM estoque e where (e.quantidade > 0) GROUP BY partnumber
        order BY e.quantidade asc limit $inicio, $quantidade_por_pagina ";
    
    }else if($_POST['filter'] == 'old'){

        $sql = "SELECT e.id, SUM(e.quantidade) as quantidade, e.tempo_estoque, e.compra_id, e.local,
        (SELECT nome from compras where id = e.compra_id) AS nome,
        (SELECT partnumber from compras where id = e.compra_id) AS partnumber,
        (SELECT nome FROM categoria WHERE id = 
            (SELECT categoria_id from compras where id = e.compra_id)
        LIMIT 1) AS categoria,
        (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
        FROM estoque e where (e.quantidade > 0) GROUP BY partnumber
        order BY e.tempo_estoque desc limit $inicio, $quantidade_por_pagina ";
    }
}
else{
    $sql = "SELECT e.id, SUM(e.quantidade) as quantidade, e.tempo_estoque, e.compra_id, e.local,
    (SELECT nome from compras where id = e.compra_id) AS nome,
    (SELECT partnumber from compras where id = e.compra_id) AS partnumber,
    (SELECT nome FROM categoria WHERE id = 
        (SELECT categoria_id from compras where id = e.compra_id)
    LIMIT 1) AS categoria,
    (SELECT data_entrega FROM recebidos WHERE compra_id = e.compra_id) AS data_entrega
    FROM estoque e where (e.quantidade > 0) GROUP BY partnumber
    order BY (SELECT data_compra FROM compras WHERE id = e.compra_id) desc limit $inicio, $quantidade_por_pagina ";
}  
$query = mysqli_query($conexao, $sql);

?>

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
                updateTempoEstoque($id, $dias);
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
                        <a href='estoque?retirado=$id'>
                            <button class='item' data-toggle='tooltip' data-placement='top' title='Retirar'>
                                <i class='zmdi zmdi-mail-send'></i>
                            </button>
                        </a>
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
    <?php
    
    $query_pg = "SELECT COUNT(id) AS num_result FROM compras";
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