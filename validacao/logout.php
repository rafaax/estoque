<?php 
require_once '../conexao.php';
require_once '../get_dados.php';

$sql = "UPDATE usuario SET auth_token = NULL where id = $userSession";
$query = mysqli_query($conexao, $sql);

if($query){
    $sqllog = "INSERT INTO logs(mensagem, usuario) values ('Logout', $userSession)";
    $querylog = mysqli_query($conexao, $sqllog);
    session_destroy();
    unset($_COOKIE['auth_token']);
    setcookie('auth_token', null, -1, '/');
    header("Location: ../login.php");
}
