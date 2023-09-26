<?php
session_start();
include_once '../conexao.php';

$_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$json = json_encode($_POST);

$user = $_POST['user'];
$pass = $_POST['pass'];

if($user == null){
    echo json_encode(array(
        'erro'=>'empty'
    ));
    die();
}

$sql = "SELECT * FROM usuario WHERE `email` = '$user' OR `login` = '$user'  AND status = 1 limit 1";
$query = mysqli_query($conexao,$sql);
$count = mysqli_num_rows($query);

if($count == 0){
    echo json_encode(array(
        'erro'=>true
    ));
    exit();
}

if($count == 1){
    $array = mysqli_fetch_assoc($query);
    $pass_db = $array['password'];

    if($pass == $pass_db){
        $id_db = $array['id'];
        $_SESSION['usuario'] = $array["id"];
        $token = md5(uniqid(rand(), true));
        setcookie('auth_token', $token, time() + (30 * 24 * 60 * 60), '/'); // Cookie válido por 30 dias
        $sql = "UPDATE usuario SET auth_token = '$token' where id = $id_db";
        $query = mysqli_query($conexao, $sql);

        if($query){
            $sqllog = "INSERT INTO logs(usuario, mensagem) values ($id_db,'Login')";
            $querylog = mysqli_query($conexao, $sqllog);
        }

        echo json_encode(array(
            'erro'=>false
        ));
    } else{
        echo json_encode(array(
            'erro'=>true
        ));
    }
    
}

?>