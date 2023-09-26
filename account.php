<?php require_once 'get_dados.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Forms</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
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
          <!-- HEADER MOBILE -->
       <?php include_once 'subtelas/header-mobile.php';?>

        <!-- MENU SIDEBAR-->
        <?php include_once 'subtelas/sidebar.php';?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include_once 'subtelas/header.php';?>

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    
                                    <div class="card-header">
                                        Mude sua <strong>foto de perfil</strong>
                                    </div>       
                                    <div class="media">
                                            <img class="rounded-circle mr-3" 
                                            <?php //style="width:85px; height:85px;"?> 
                                            src="<?php echo "$fotoSession"?>">
                                        
                                    </div>
                                    <div class="card-body card-block">
                                        <form id='submit_foto' method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="file-input" class=" form-control-label">Insira sua foto</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" id="file-input" name="file-input" class="form-control-file">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Confirmar
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">Mude sua <strong>senha<strong></div>
                                    <div class="card-body card-block">
                                        <form id='change_password' method="post">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Digite sua senha atual</div>
                                                    <input type="password" id="password1" name="password_atual" class="form-control" onchange='passwords(this.value)'>
                                                    <div id='olho1' class="input-group-addon">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Digite a senha novamente</div>
                                                    <input type="password" id="password2" name="password_again" class="form-control" onchange='passwords(this.value)'>
                                                    <div id='olho2' class="input-group-addon">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Senha nova</div>
                                                    <input type="password" id="password3" name="new_password" class="form-control" onchange='passwords(this.value)'>
                                                    <div id='olho3' class="input-group-addon">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Confirmar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
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
    <script src="vendor/select2/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

<script>

    
    $( "#olho1" ).mouseenter(function() {
        $("#password1").attr("type", "text");
    });

    $( "#olho1" ).mouseout(function() { 
        $("#password1").attr("type", "password");
    });

    $( "#olho2" ).mouseenter(function() {
        $("#password2").attr("type", "text");
    });

    $( "#olho2" ).mouseout(function() { 
        $("#password2").attr("type", "password");
    });


    $( "#olho3" ).mouseenter(function() {
        $("#password3").attr("type", "text");
    });
    
    $( "#olho3" ).mouseout(function() { 
        $("#password3").attr("type", "password");
    });

    function passwords(text){
        
        var passwordAntiga = document.getElementById("password1").value;
        var passwordAntiga2 = document.getElementById("password2").value;
        var passwordNova = document.getElementById("password3").value;

        if(passwordAntiga != '<?=$senhaSession?>'){
            Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Senha incorreta!'
                })
            document.getElementById("password1").value = "";
        }

        if (passwordAntiga === passwordNova && passwordAntiga != '' && passwordNova != '') {
            Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Senha antiga não deve ser igual a senha nova!'
                })
            document.getElementById("password1").value = "";
            document.getElementById("password3").value = "";
            document.getElementById("password2").value = "";
        }
        if(passwordAntiga !== passwordAntiga2 && (passwordAntiga != "" && passwordAntiga2 != "")){
            Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Senhas nao coincidem'
                })
            document.getElementById("password1").value = "";
            document.getElementById("password2").value = "";
        }
    }
    
    

    $("#submit_foto").on("submit", function (event) {
        
        event.preventDefault();

        $.ajax({
            method: "POST",
            url: "funcoes/account/submit_foto.php",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (json) {
                var resposta = JSON.parse(json);
                
                if(resposta.erro == true && resposta.msg == 'erro generico') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Selecione um arquivo!'
                    }) 
                }else if(resposta.erro == true && resposta.msg == 'size'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Arquivo muito pesado, selecione uma foto menor!'
                    })
                }else if(resposta.erro == true && resposta.msg == 'tipo'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Tipo de arquivo não permitido, escolha entre jpg, jpeg ou png!'
                    })
                }else if(resposta.erro == true && resposta.msg == 'query'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Aconteceu algum erro em atualizar sua foto, tente novamente'
                    })
                }else if(resposta.erro == false){
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Foto atualizada!'
                    })
                    setTimeout(function() {
                        location.reload();
                        }, 1000)
                }
            }
        })
    });


    $("#change_password").on("submit", function (event) {
        
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        
        if(password1 === "" || password2 === ""){
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Preencha os campos!'
            })
        }

        event.preventDefault();

        $.ajax({
            method: "POST",
            url: "funcoes/account/change_password.php",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (json) {
                console.log(json);
                var resposta = JSON.parse(json);
                if(resposta.erro == true){
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Houve algum erro em tentar mudar sua senha...'
                    })
                }else{
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Senha atualizada com sucesso!'
                    })
                    setTimeout(function() {
                        location.reload();
                        }, 1000)
                }
            }
        })
    });



</script>

</html>
<!-- end document-->
