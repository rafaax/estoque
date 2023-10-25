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

