<?php

include_once '../../conexao.php';
include '../../get_dados.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$json = json_encode($dados);

$idCompra =  $_GET['id'];
$arquivo = $_FILES['file-input'];

function validaRegistro($id){
    require '../../conexao.php';

    $sql = "SELECT id from notas_fiscais where compra_id = $id";
    $query = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($query) < 1){
        return false;
    }else{
        return true;
    }

}

function getPath($compra_id){
    require '../../conexao.php';

    $sql = "select path from notas_fiscais where compra_id = $compra_id";
    $query = mysqli_query($conexao, $sql);
    $array = mysqli_fetch_array($query);

    return $array['path'];
}

function delPath($path){
    if(file_exists('../../' .$path)){
        unlink('../../'.$path);
    }
}
// file_put_contents('contentlenght.txt', $_SERVER['CONTENT_LENGTH']);

if($_SERVER['CONTENT_LENGTH'] > 84313071){
    echo json_encode(
        array(
            'erro'=> true,
            'msg' => 'content_length'
        )
    );
    exit();
}
if(isset($_FILES['file-input'])){
    
    if($arquivo['error'])
    {
        echo json_encode(array(
            'erro'=> true,
            'msg' => 'erro generico'
        ));
        exit();
    }else if($arquivo['size'] > 2097152){
        echo json_encode(array(
            'erro'=> true,
            'msg' => 'size'
        ));
        exit();
    }

    $pasta = "notas/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "pdf" && $extensao != "xls" && $extensao != "xlsx"){
        echo json_encode(array(
            'erro'=> true,
            'msg' => 'tipo'
        ));
        exit();
    }
    
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    

    if(validaRegistro($idCompra)){
        
        $atualpath = getPath($idCompra);
        delPath($atualpath);

        $sql = "UPDATE notas_fiscais set path = '$path' where compra_id = $idCompra";
        $query = mysqli_query($conexao, $sql);

    }else{
        $sql = "INSERT INTO notas_fiscais(path, compra_id)  values ('$path','$idCompra')";
        $query = mysqli_query($conexao, $sql);
    }

    if($query){
        move_uploaded_file($arquivo["tmp_name"], '../../'.$path);
        echo json_encode(array(
            'erro'=> false
        ));
        
    }else{
         echo json_encode(array(
            'erro'=> true,
            'msg' => 'query'
        ));
        exit();
    }
}