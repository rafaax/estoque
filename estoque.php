<?php require_once 'get_dados.php';?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Estoque</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
        <?php require 'subtelas/header-mobile.php';?>
        <?php require 'subtelas/sidebar.php';?>
        <div class="page-container">
            <?php require 'subtelas/header.php';?>
            <?php if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['retirado'])){
                    $id_retirar = $_GET['retirado'];
                    $sql = "SELECT (SELECT partnumber from compras WHERE id = c.compra_id ) AS partnumber
                        from estoque c where quantidade > 0 and id = $id_retirar";  
                    $query = mysqli_query($conexao, $sql);
                    $res = mysqli_fetch_array($query);
                    $partnumber = $res['partnumber'];

                    $sql = "SELECT c.id FROM compras c INNER JOIN estoque e ON c.id = e.compra_id WHERE c.partnumber = '$partnumber' and e.quantidade > 0";
                    $query = mysqli_query($conexao, $sql);
                    $count = mysqli_num_rows($query);

                    if($count > 1){
                        
                        echo '<div class="main-content">
                                <div class="section__content section__content--p30">    
                                    <div class="container-fluid">
                                        <div class="row">    
                                            <div class="col-lg-9">
                                                <div id="seleciona_produto"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';                      
                    }else{
                        echo '<div class="main-content">
                                <div class="section__content section__content--p30">    
                                    <div class="container-fluid">
                                        <div class="row">    
                                            <div class="col-lg-9">
                                                <div id="retira_produto"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }
                

                }else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['res']) && isset($_GET['value'])){
                    if($_GET['res'] == true){
                        echo '<div class="main-content">
                                <div class="section__content section__content--p30">    
                                    <div class="container-fluid">
                                        <div class="row">    
                                            <div class="col-lg-9">
                                                <div id="retira_produto-res"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }
                }
                else if($_SERVER['REQUEST_METHOD'] == 'GET'){
                echo '<div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid"><div class="row">
                            <div class="col-md-12">
                                <h3 class="title-5 m-b-35"></h3>
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        <div class="form-header">
                                            <input class="au-input au-input--xl" type="text" name="search" id="searchEstoque" placeholder="Procure uma compra" />
                                            <button class="au-btn--submit" id="buttonClear">
                                                <i class="zmdi zmdi-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="table-data__tool-right">
                                        <div class="rs-select2--dark rs-select2--md rs-select2--dark2">
                                            <select class="js-example-basic-single" id="datafilter">
                                                <option></option>
                                                <option value="old">+ Antigo</option>
                                                <option value="qntmaior">+ Quantidade</option>
                                                <option value="qntmenor">- Quantidade</option>
                                            </select>
                                        </div>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-open-in-new"></i>EXPORTAR PARA EXCEL
                                        </button>
                                    </div>
                                </div>
                                <div id="tabela_estoque"></div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
            
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <script src="vendor/slick/slick.min.js"></script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/main.js"></script>
</body>
</html>

<script type="text/javascript">

    const tabela = document.querySelector("#tabela_estoque");

    const listarRegistros = async (pagina) => {
        const dados = await fetch("funcoes/estoque/tabela_estoque.php?pagina=" + pagina);
        const resposta = await dados.text();
        tabela.innerHTML = resposta;
    }

    listarRegistros(1);

    $(document).ready(function(){
	
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['retirado'])){
            ?> load_retirar(<?=$_GET['retirado']?>)<?php
        }else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['res']) && isset($_GET['value']) && $_GET['res'] == true){
            ?>load_retirar_pos_res(<?=$_GET['value']?>);<?php
        }
        else if($_SERVER['REQUEST_METHOD'] === 'GET'){
            ?> load_table();<?php
        }
        ?>

        $('.js-example-basic-single').select2({
            placeholder: 'Filtre por data',
            allowClear: true,
        });
        
        function data_filter(data){
            $.ajax({
                url:"funcoes/estoque/tabela_estoque.php",
                method:"post",
                data:{filter:data},
                success:function(data){
                    // renderizar a tabela e os elementos
                    $('#tabela_estoque').html(data); 
                    //
                }
            });  
        }

        function load_retirar(id){
            // console.log('a');
            $.ajax({
                url:"funcoes/estoque/retirar_estoque.php",
                method:"post",
                data:{id:id},
                success:function(data){
                    $('#seleciona_produto').html(data); 
                    $('#retira_produto').html(data); 
                }
            });
        }

        function load_retirar_pos_res(id){
            // console.log('a');
            $.ajax({
                url:"funcoes/estoque/retirar_estoque.php",
                method:"post",
                data:{
                    value:id,
                    res: true 
                },
                success:function(data){ 
                    $('#retira_produto-res').html(data); 
                }
            });
        }


        function load_table(query){
            $.ajax({
                url:"funcoes/estoque/tabela_estoque.php",
                method:"post",
                data:{query:query},
                success:function(data)
                {
                    // renderizar a tabela e os elementos
                    $('#tabela_estoque').html(data); 
                    //
                }
            });
        }

        
        $('.au-input--xl').on('keyup', function() {
            var search = $(this).val();
            
            console.log(search);
            if(search != ''){
                load_table(search);
            }
            else{
                load_table();			
            }
            
        });

        $('#buttonClear').on('click', function() {
            $('#searchEstoque').val('');
            load_table();	
        });


        $('#datafilter').on('select2:select', function (e) {
            // console.log(e);
            let value = e.params.data.id;
            data_filter(value);
        });



    }); // fecha document ready
    

</script>
