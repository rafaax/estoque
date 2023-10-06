<?php require_once 'get_dados.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Compras</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php require 'subtelas/header-mobile.php';
        require 'subtelas/sidebar.php';?>
        <div class="page-container">
        <?php require 'subtelas/header.php';

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cadastro'])) {
        echo '

            <div class="main-content">
                <div class="section__content section__content--p30">    
                    <div class="container-fluid">
                        <div class="row">    
                            <div class="col-lg-9">
                                <div id="cadastro_compras"></div>
                            </div>
                        </div>
                    </div>
                </div>';
        }else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit'])) {
            $id = $_GET['edit'];
            echo $id;
            echo '
            
            <div class="main-content">
                <div class="section__content section__content--p30">    
                    <div class="container-fluid">
                        <div class="row">    
                            <div class="col-lg-9">
                                <div id="edit_compra"></div>
                            </div>
                        </div>
                    </div>
                </div>';

        }else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            echo '
                <div class="main-content">
                    <div class="section__content section__content--p30">    
                        <div class="container-fluid">
                            <div class="row">    
                                <div class="col-lg-12">
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <div class="table-data__tool">
                                                <div class="table-data__tool-left">
                                                    <div class="form-header">
                                                        <input class="au-input au-input--xl" type="text" name="search" id="searchCompras" placeholder="Procure uma compra" />
                                                        <button class="au-btn--submit" id="buttonClear">
                                                            <i class="zmdi zmdi-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="table-data__tool-right">
                                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                                        <i class="zmdi zmdi-plus"></i>adicionar uma compra</button>
                                                </div>
                                            </div>
                                            <div id="tabela_compras"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        } ?>
        </div>
    </div>
</body>
<script src="vendor/jquery-3.2.1.min.js"></script>
<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
<script src="vendor/slick/slick.min.js">
</script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  

<script type="text/javascript">
    $(document).ready(function(){
	
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cadastro'])){
            ?> load_cadastro();<?php
        }
        else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit'])){
            ?> load_edit(<?=$_GET['edit']?>);<?php    
        }else if($_SERVER['REQUEST_METHOD'] === 'GET'){
            ?> load_compras();<?php 
        }?>
        
        function load_cadastro(query)
        {
            $.ajax(
                {
                    url:"funcoes/compras/cadastro_compras.php",
                    method:"post",
                    data:{query:query},
                    success:function(data)
                    {
                        // renderizar a tabela e os elementos
                        $('#cadastro_compras').html(data); 
                        //
                    }
                }
            );
        }
    

        function load_compras(query)
        {
            $.ajax(
                {
                    url:"funcoes/compras/tabela_compras.php",
                    method:"post",
                    data:{query:query},
                    success:function(data)
                    {
                        // renderizar a tabela e os elementos
                        $('#tabela_compras').html(data); 
                        //
                    }
                }
            );
        }
    
        function load_edit(query)
            {
                console.log(query);
                $.ajax(
                    {
                        url:"funcoes/compras/edit_compra.php",
                        method:"post",
                        data:{id:query},
                        success:function(data)
                        {
                            // renderizar a tabela e os elementos
                            $('#edit_compra').html(data); 
                            //
                        }
                    }
                );
            }

            $('.au-input--xl').on('keyup', function() {
                var search = $(this).val();
                
                if(search != '')
                {
                    load_compras(search);
                }
                else
                {
                    load_compras();			
                }
                
            });

            $('#buttonClear').on('click', function() {
                    $('#searchCompras').val('');
                    load_compras();	
            });            
    });
</script>
<script>
    const tabela = document.querySelector("#tabela_compras");

    const listarUsuarios = async (pagina) => {
        const dados = await fetch("funcoes/compras/tabela_compras.php?pagina=" + pagina);
        const resposta = await dados.text();
        tabela.innerHTML = resposta;
    }

    listarUsuarios(1);

</script>

