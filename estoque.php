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
        <!-- HEADER MOBILE-->
        <?php require 'subtelas/header-mobile.php';?>
        <!-- END HEADER MOBILE-->
        <!-- MENU SIDEBAR-->
        <?php require 'subtelas/sidebar.php';?>
        <!-- END MENU SIDEBAR-->
        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php require 'subtelas/header.php';?>
            <!-- END HEADER DESKTOP-->
            <!-- MAIN CONTENT-->
            <?php if($_SERVER['REQUEST_METHOD'] == 'GET'){
                echo '<div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div id="tabela_estoque">
                        </div>
                    </div>
                </div>';
            }
            ?>
            
        </div>
    </div>

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
    <script src="vendor/select2/select2.min.js">
    </script>
    <script src="js/main.js"></script>

</body>
</html>

<script type="text/javascript">

    $(document).ready(function(){
	
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET'){
            ?> load_table();<?php
        }
        ?>

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



    }); // fecha document ready
    



</script>