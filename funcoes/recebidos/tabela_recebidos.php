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
    <table class="table table-borderless table-data3" id="tabela_compras" >
        <thead style="position: sticky; top: 0;">
            <tr>
                <th>Nome</th>
                <th>Data Compra</th>
                <th>Data Recebimento</th>
                <th>Recebido por</th>
                <th></th>
            </tr>
        </thead> 
        <tbody>
            <?php 
            
            if(isset($_POST["query"]))
            {
                $search = mysqli_real_escape_string($conexao, $_POST["query"]);
                $sql = "SELECT r.id,r.partnumber, c.nome, c.data_compra , r.data_entrega, 
                  (SELECT nome FROM integrantes where id = r.recebido_id) AS recebido
                  FROM recebidos r INNER JOIN compras c  ON c.id = r.compra_id where (c.nome LIKE '%$search%') ORDER BY c.data_compra DESC";
            }
            else{
                $sql = "SELECT r.id,r.partnumber, c.nome, c.data_compra , r.data_entrega, 
                (SELECT nome FROM integrantes where id = r.recebido_id) AS recebido
                FROM recebidos r 
                  INNER JOIN compras c 
                    ON c.id = r.compra_id 
                ORDER BY c.data_compra DESC limit $inicio, $quantidade_por_pagina ";
            }
                        
            
            $query = mysqli_query($conexao, $sql);

            while ($array = mysqli_fetch_array($query)) {

              $id = $array['id'];
              $nome = $array['nome'];
              $partnumber = $array['partnumber'];
              
              $data_compra = date('d/m/Y',strtotime($array['data_compra']));
              if($array['data_entrega'] != NULL){
                $data_recebimento = date('d/m/y', strtotime($array['data_entrega']));
                $recebido_id = $array['recebido'];
              }else{
                $data_recebimento = 'Não foi recebido ainda'; 
                $recebido_id = 'Não foi recebido ainda';
              }
              
                
              echo "<tr class='table-row'>";
                  echo "<td> $nome </td>";
                  echo "<td> $data_compra </td>";
                  echo "<td> $data_recebimento </td>";
                  echo "<td> $recebido_id </td>";
                  ?>
                  <td>
                      <div class="table-data-feature">
                          <a href="recebidos?edit=<?=$id?>"> 
                              <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                  <i class="zmdi zmdi-edit"></i>
                              </button>
                          </a>
                      </div>
                    </td>
                    <?php 
                echo "</tr>";

                ?>
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
            echo "<a href='#' class='page-link' onclick='listarRegistros($quantidade_pg)'>&raquo;</a>";
        
        ?>
        </div>
    </div>
</div>