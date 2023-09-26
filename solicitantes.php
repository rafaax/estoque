<?php require_once 'get_dados.php';?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Solicitantes</title>

    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
	<link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
	<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
	<link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
	<link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
	<link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php include_once 'subtelas/header-mobile.php';?>
        <?php include_once 'subtelas/sidebar.php';?>
        <div class="page-container">
            <?php include_once 'subtelas/header.php';?>
            <div class="main-content">
                
                <div class="section__content section__content--p30">
                    
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-9">
                                <div id="tabela_solicitantes"></div>
                            </div>
                            
                            <div class="table-data__tool">
                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>adicionar solicitante
                                    </button>
                                        
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    
	<script src="vendor/jquery-3.2.1.min.js"></script>
	<script src="vendor/bootstrap-4.1/popper.min.js"></script>
	<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/animsition/animsition.min.js"></script>
	<script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
<script>
$(document).ready(function(){
	load_data();
	function load_data(query)
        {
            $.ajax({
                url:"funcoes/solicitantes/render_solicitantes.php",
                method:"post",
                data:{query:query},
                success:function(data)
                {
                    // renderizar a tabela e os elementos
                    $('#tabela_solicitantes').html(data); 
                    //
                }
            });
        }

    $('.au-btn--small').on("click", function(){
       Swal.fire({
                title: 'Digite o nome do novo solicitante',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                showLoaderOnConfirm: true,
                preConfirm: (text) => {
                    const arrayPost = {
                        nome: text
                    };

                    const requestOptions = {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(arrayPost),
                        };

                    return fetch('funcoes/solicitantes/solicitante_cadastro.php', requestOptions)
                    .then(response => {
                        // Verificar se a resposta da solicitação é bem-sucedida (código de status 200)
                        if (!response.ok) {
                        throw new Error('A solicitação não foi bem-sucedida');
                        }
                        // Parse a resposta JSON
                        return response.json();
                    })
                    .then(data => {
                        // Manipular os dados da resposta
                        if(data.erro == false){
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Registro adicionado com sucesso!',
                            })
                            setTimeout(function() {
                                location.reload();
                            }, 1000)
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: data.msg,
                            })
                        }
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
    });

   
});

</script>