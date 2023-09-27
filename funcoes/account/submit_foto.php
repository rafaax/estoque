<?php
include_once '../../conexao.php';
include '../../get_dados.php';


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$json = json_encode($dados);
$arquivo = $_FILES['file-input'];
// var_dump($arquivo);

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

    $pasta = "fotos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg"){
        echo json_encode(array(
            'erro'=> true,
            'msg' => 'tipo'
        ));
        exit();
    }
    
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    

    $sql = "UPDATE usuario SET img = '$path' WHERE id = $userSession";
    $query = mysqli_query($conexao, $sql);

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