<?php 

function postCurl_chip($data){
    // echo $data;
    
    $url = "127.0.0.1/estoque_git/funcoes/emails/email_falta_chip.php";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));

    $response = curl_exec($ch);

    curl_close($ch);
   
}

function updateRotina_chip($quantidade, $tipo){
    $conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
    $data_agora = date("Y-m-d H:i:s");
    $sql = "UPDATE rotinas set quantidade = '$quantidade', last_time = '$data_agora' where type = '$tipo'";
    mysqli_query($conexao, $sql);
}

$conexao = mysqli_connect('localhost', 'root', '', 'vetorsys');
// rotina st310 
$sql = "select sum(e.quantidade) as quantidade_total, c.partnumber from estoque e inner join compras c on c.id = e.compra_id where c.partnumber in ('CPM20MB', 'CPM10MB')";
$query = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($query);

$quantidade_estoque = $array['quantidade_total'];

$sql = "select * from rotinas where type = 'Chip'";
$query = mysqli_query($conexao, $sql);
$array = mysqli_fetch_array($query);

if($array['quantidade'] != $quantidade_estoque){
    if($quantidade_estoque < 5){
        $post = array(
            'valor' => $quantidade_estoque,
            'tolerancia' => $array['tolerancia']
        );
        $json = json_encode($post);
        postCurl($json);
        updateRotina($quantidade_estoque, 'Chip');
    }else{
        // exit();
    }
}else{
    // exit();
}