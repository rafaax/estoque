<?php require_once 'get_dados.php';?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Retirados</title>

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
        <?php require 'subtelas/header-mobile.php';?>
        <?php require 'subtelas/sidebar.php';?>
        <div class="page-container">
            <?php require 'subtelas/header.php';?>
            <?php if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['retirado'])){
                    

                }else if($_SERVER['REQUEST_METHOD'] == 'GET'){
                echo '
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid"><div class="row">
                            <div class="col-md-12">
                                <h3 class="title-5 m-b-35"></h3>
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        <div class="form-header">
                                            <input class="au-input au-input--xl" type="text" name="search" id="searchRetirada" placeholder="Procure uma compra" />
                                            <button class="au-btn--submit" id="buttonClear">
                                                <i class="zmdi zmdi-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="tabela_retirados"></div>
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

    const tabela = document.querySelector("#tabela_retirados");

    const listarRegistros = async (pagina) => {
        const dados = await fetch("funcoes/retirada/tabela_retirados.php?pagina=" + pagina);
        const resposta = await dados.text();
        tabela.innerHTML = resposta;
    }

    listarRegistros(1);

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

    function devolverParcela(id, quantidade){
        Swal.fire({
            title: 'Alerta',
            text: "Você realmente deseja devolver?",
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
                Swal.fire({
                    title: 'Quanto você deseja devolver?',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        min: 1,
                        max: quantidade
                    },
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    confirmButtonText: 'Devolver',
                    cancelButtonText: 'Não!',
                    
                    preConfirm: (qt) => {
                        const arrayPost = {
                            id: id, qt: qt 
                        };

                        const requestOptions = {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(arrayPost),
                        };

                        return fetch('funcoes/retirada/backend_devolucao.php', requestOptions)
                        .then(response => {
                            if (!response.ok) {
                            throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .then(data => {
                            console.log(data);
                            
                            if(data.erro === false){
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Devolução recebida.'
                                })
                                listarRegistros(1);    
                            }else if(data.erro === true){
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
                        
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        
                    })
            }
        })
    }


    $(document).ready(function(){
	
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET[''])){
            ?> load_retirar(<?=$_GET['retirado']?>)<?php
        }else if($_SERVER['REQUEST_METHOD'] === 'GET'){
            ?> load_table();<?php
        }
        ?>
        
       

        

        function load_table(query){
            $.ajax({
                url:"funcoes/retirada/tabela_retirados.php",
                method:"post",
                data:{query:query},
                success:function(data)
                {
                    $('#tabela_retirados').html(data); 
                }
            });
        }

        $('.au-input--xl').on('keyup', function() {
            var search = $(this).val();
        
            if(search != ''){
                load_table(search);
            }
            else{
                load_table();			
            }
            
        });

        $('#buttonClear').on('click', function() {
            $('#searchRetirada').val('');
            load_table();	
        });

        

    }); // fecha document ready
    
</script>