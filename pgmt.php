<?php require_once 'get_dados.php';?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Formas de Pagamento</title>
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
	<link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
	<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
	<link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
	<link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
	<link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
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
                                <div id="tabela_pagamentos"></div>
                            </div>
                            
                            <div class="table-data__tool">
                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>adicionar forma de pagamento
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
