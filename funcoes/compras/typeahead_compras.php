<?php 

include_once '../../conexao.php';
$request = mysqli_real_escape_string($conexao, $_POST["query"]);
$sql = "SELECT partnumber from compras WHERE partnumber LIKE '%$request%' group by partnumber";

$query = mysqli_query($conexao, $sql);

$retorno = array();

if(mysqli_num_rows($query) > 0)
{
    while($array = mysqli_fetch_assoc($query))
    {
        $retorno[] = $array["partnumber"];
    }
    echo json_encode($retorno);
}