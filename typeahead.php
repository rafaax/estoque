<?php 


include_once 'conexao.php';


$request = mysqli_real_escape_string($conexao, $_POST["query"]);


$sqlquery = "SELECT PartNumber from estoque WHERE PartNumber LIKE '%". $request . "%'";

$result = mysqli_query($conexao, $sqlquery);

$retorno = array();

if(mysqli_num_rows($result) > 0)
{
    while($banco = mysqli_fetch_assoc($result))
    {
        $retorno[] = $banco["PartNumber"];
    }
    echo json_encode($retorno);
}