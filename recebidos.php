<?php require_once 'get_dados.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Recebidos</title>

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
    <!-- animation do sweetalert-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<style>
.colored-toast.swal2-icon-success {
  background-color: #a5dc86 !important;
}

.colored-toast .swal2-title {
  color: white;
}

.colored-toast .swal2-close {
  color: white;
}

.colored-toast .swal2-html-container {
  color: white;
}
</style>
<body class="animsition">
    <div class="page-wrapper">
        <?php require 'subtelas/header-mobile.php';
        require 'subtelas/sidebar.php';?>
        <div class="page-container">
        <?php require 'subtelas/header.php';?>
        
        <?php
        if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit'])){

        $id = $_GET['edit'];
            echo '
                <div class="main-content">
                    <div class="section__content section__content--p30">    
                        <div class="container-fluid">
                            <div class="row">    
                                <div class="col-lg-9">
                                    <div id="edit_recebido"></div>
                                </div>
                            </div>
                        </div>
                    </div>';    
        }else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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
                                                    <input class="au-input au-input--xl" type="text" name="search" id="searchRegistro" placeholder="Procure uma compra" />
                                                    <button class="au-btn--submit" id="buttonClear">
                                                        <i class="zmdi zmdi-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tabela_recebidos"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        
        ?>

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
	
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit'])){
            ?>load_edit(<?=$_GET['edit']?>);<?php    
        }else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nota'])){
            ?><?php
        }else if($_SERVER['REQUEST_METHOD'] === 'GET'){
            ?> load_table();<?php 
        }?>

        
        function load_edit(query){

            $.ajax(
                {
                    url: "funcoes/recebidos/tela_edit.php",
                    method: "post",
                    data: {id:query},
                    success: function(data)
                    {
                        $('#edit_recebido').html(data);
                    }
                }
            )
        }


        function load_table(query)
        {
            $.ajax(
                {
                    url:"funcoes/recebidos/tabela_recebidos.php",
                    method:"post",
                    data:{query:query},
                    success:function(data)
                    {
                        // renderizar a tabela e os elementos
                        $('#tabela_recebidos').html(data); 
                        //
                    }
                }
            );
        }

        $('.au-input--xl').on('keyup', function() {
            var search = $(this).val();
            
            if(search != '')
            {
                load_table(search);
            }
            else
            {
                load_table();			
            }
                
        });

        $('#buttonClear').on('click', function() {
            $('#searchRegistro').val('');
            load_table();	
        });  
    });
</script>
<script>
    <?php if(!isset($_GET['cadastro']) && !isset($_GET['edit']) && !isset($_GET['nota'])){
    ?>
    const tabela = document.querySelector("#tabela_recebidos");

    const listarRegistros = async (pagina) => {
        const dados = await fetch("funcoes/recebidos/tabela_recebidos.php?pagina=" + pagina);
        const resposta = await dados.text();
        tabela.innerHTML = resposta;
    }

    listarRegistros(1);

    <?php } ?>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    })

    function deletaRecebido(id){
        Swal.fire({
            title: 'Alerta',
            text: "Você deseja remover o recebimento?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não!',
            allowOutsideClick: () => {
                const popup = Swal.getPopup()
                popup.classList.remove('swal2-show')
                setTimeout(() => {
                popup.classList.add('animate__animated', 'animate__headShake')
                })
                setTimeout(() => {
                popup.classList.remove('animate__animated', 'animate__headShake')
                }, 500)
                return false
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"funcoes/recebidos/desvincular_recebimento.php",
                    method:"post",
                    data:{
                        id:id
                    },
                    success:function(data){
                        var json = JSON.parse(data);
                        if(json.erro === false){
                            Toast.fire({
                                icon: 'success',
                                title: 'Recebimento cancelado.'
                            })
                            listarRegistros(1);    
                        }else if(json.erro === true){
                            Swal.fire({
                                title: json.msg,
                                icon: 'error',
                                allowOutsideClick: () => {
                                    const popup = Swal.getPopup()
                                    popup.classList.remove('swal2-show')
                                    setTimeout(() => {
                                    popup.classList.add('animate__animated', 'animate__headShake')
                                    })
                                    setTimeout(() => {
                                    popup.classList.remove('animate__animated', 'animate__headShake')
                                    }, 500)
                                    return false
                                }
                            })
                        }
                        
                    }
                });
            }
        })
    }

</script>