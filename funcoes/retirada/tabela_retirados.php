<?php
include_once '../../conexao.php';

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
  <table class="table table-borderless table-data3" id="tabela_retirada" >
    <thead style="position: sticky; top: 0;">
      <tr>
        <th>nome</th>
        <th>partnumber</th>
        <th>data retirada</th>
        <th>quantidade retirada</th>
        <th>retirado por</th>
        <th>motivo</th>
        <th></th>
      </tr>
    </thead> 
    <tbody>
    <?php 
    if(isset($_POST["query"])){
      $search = mysqli_real_escape_string($conexao, $_POST["query"]);
      $sql = "SELECT r.motivo, c.nome, c.partnumber, r.data_retirada, r.quantidade_retirada,
        (SELECT nome FROM integrantes WHERE id = r.integrante_id LIMIT 1) AS retirado_por
        from retirada r 
        INNER JOIN compras c ON r.compra_id = c.id where (c.nome LIKE '%$search%') ORDER BY r.data_retirada DESC";
    }else{
      $sql = "SELECT r.motivo, c.nome, c.partnumber, r.data_retirada, r.quantidade_retirada,
        (SELECT nome FROM integrantes WHERE id = r.integrante_id LIMIT 1) AS retirado_por
        from retirada r 
        INNER JOIN compras c ON r.compra_id = c.id ORDER BY r.data_retirada desc limit $inicio, $quantidade_por_pagina";
    }

    $query = mysqli_query($conexao, $sql);
    while ($array = mysqli_fetch_array($query)) {
      $nome = $array['nome'];
      $partnumber = $array['partnumber'];
      $motivo = $array['motivo'];
      $data_retirada = $array['data_retirada'];
      $qt_retirada = $array['quantidade_retirada'];
      $retirado_por = $array['retirado_por']; 
      ?>
      <tr class='table-row'>
        <td> <?=$nome?></td>
        <td> <?=$partnumber?></td>
        <td> <?=$data_retirada?> </td>
        <td> <?=$qt_retirada?> </td>
        <td> <?=$retirado_por?> </td>
        <td><?= $motivo?> </td>
        <td>
          <div class="table-data-feature">
            <a href="recebidos?edit=<?=$id?>"> 
              <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                <i class="zmdi zmdi-edit"></i>
              </button>
            </a>
          </div>
        </td>
      </tr>
        <?php 
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
            <a href="#" class="page-link" onclick="listarRegistros(1)">&laquo;</a>
            <?php 
            for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
                if($pag_ant >= 1){
                    echo "<a class='page-link' href='#' onclick='listarRegistros($pag_ant)' >$pag_ant</a>";
                }        
            }
            echo "<a class='page-link active' href='#'>$pagina</a>";

            for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
                if($pag_dep <= $quantidade_pg){
                    echo "<a class='page-link' href='#' onclick='listarRegistros($pag_dep)'>$pag_dep</a>";
                }        
            }
            ?>
            <a href='#' class='page-link' onclick='listarRegistros(<?=$quantidade_pg?>)'>&raquo;</a>
        </div>
    </div>
</div>
