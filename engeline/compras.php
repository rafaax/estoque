<?php require_once '../get_dados.php';?>
<?php require_once '../conexao.php';?>
<?php 

function nomeMes($num){
    if($num == 1){
        return 'Janeiro';
    }else if($num == 2){
        return 'Fevereiro';
    }else if($num == 3){
        return 'Março';
    }else if($num == 4){
        return 'Abril';
    }else if($num == 5){
        return 'Maio';
    }else if($num == 6){
        return 'Junho';
    }else if($num == 7){
        return 'Julho';
    }else if($num == 8){
        return 'Agosto';
    }else if($num == 9){
        return 'Setembro';
    }else if($num == 10){
        return 'Outubro';
    }else if($num == 11){
        return 'Novembro';
    }else if($num == 12){
        return 'Dezembro';
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Compras</title>
    <!-- Fontfaces CSS-->
    <link href="../css/font-face.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <!-- Bootstrap CSS-->
    <link href="../vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <!-- Vendor CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="../vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="../vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php require '../subtelas/header-mobile-engeline.php';
        require '../subtelas/sidebar-engeline.php';?>
        <div class="page-container">
        <?php require '../subtelas/header-engeline.php';

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

        }else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nota'])){
        
        $nota_id = $_GET['nota'];
        $sql = "select path from notas_fiscais where compra_id = $nota_id limit 1";
        $query = mysqli_query($conexao, $sql);

        if(mysqli_num_rows($query) > 0){
            $array = mysqli_fetch_array($query);
            $path = $array['path'];
        }

        // 
        echo '

            <div class="main-content">
                <div class="section__content section__content--p30">    
                    <div class="container-fluid">
                        <div class="row">    
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-6">
                                    </div>
                                    <div class="col-lg-6">
                                    </div>
                                    <div class="col-lg-6">
                                    ';
                                    if(isset($path)){
                                        echo '
                                        <div class="card">
                                            
                                            <div class="card-header">
                                                Visualize <strong>NOTA FISCAL</strong>
                                            </div>
                                            <div class="card-body card-block">
                                                    <div class="row form-group"> 
                                                    <div class="col col-md-9">
                                                            <a target="_blank" href="../'. $path. '">
                                                                <label for="file-input" class=" form-control-label">Clique para visualizar a NF</label>
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                           
                                        </div>
                                        <div class="card">
                                            
                                            <div class="card-header">
                                                Substitua a <strong>NOTA FISCAL</strong>
                                            </div>
                                            <div class="card-body card-block">
                                                <form id="insert_nf" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                    <div class="row form-group">                                                        
                                                        <div class="col col-md-3">
                                                            <label for="file-input" class=" form-control-label">Insira a NF</label>
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
                                        </div>';
                                    }else{
                                        echo '<div class="card">
                                            
                                            <div class="card-header">
                                                Insira a <strong>NOTA FISCAL</strong>
                                            </div>
                                            <div class="card-body card-block">
                                                <form id="insert_nf" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                    <div class="row form-group">                                                        
                                                        <div class="col col-md-3">
                                                            <label for="file-input" class=" form-control-label">Insira a NF</label>
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
                                        </div>';
                                    }
                                        echo '
                                    </div>
                            </div>
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
                                                    <div class="rs-select2--dark rs-select2--md rs-select2--dark2">
                                                        <select class="js-example-basic-single" id="datafilter">
                                                            <option></option>';

            $sql = "SELECT year(data_compra) as ano, month(data_compra) as mes from compras 
                where engeline = 1 and data_compra is not null  group by year(data_compra), month(data_compra) order by data_compra desc";
            $query = mysqli_query($conexao, $sql);
            $arrAno = array();
            while($array = mysqli_fetch_array($query)){

                if($array['ano'] != $ano ){
                    array_push($arrAno, $array['ano']);    
                }
                $ano = $array['ano'];
            }

            foreach($arrAno as $array){
                echo "<optgroup label='$array'>";
                $sqlforeach = "SELECT month(data_compra) as mes_compra from compras where year(data_compra) = '$array' and engeline = 1 group by month(data_compra) order by data_compra desc";
                $query = mysqli_query($conexao, $sqlforeach);
                while($mes = mysqli_fetch_array($query)){
                    
                    $mes_compra = $mes['mes_compra'];
                    $nome = nomeMes($mes_compra);
                    echo "<option value='$array-$mes_compra'> $nome </option>";

                }
                echo '</optgroup>';
            }
                                            echo '  
                                                        </select>
                                                    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="../vendor/jquery-3.2.1.min.js"></script>
<script src="../vendor/bootstrap-4.1/popper.min.js"></script>
<script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
<script src="../vendor/slick/slick.min.js"></script>
<script src="../vendor/wow/wow.min.js"></script>
<script src="../vendor/animsition/animsition.min.js"></script>
<script src="../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="../vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="../vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="../vendor/circle-progress/circle-progress.min.js"></script>
<script src="../vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../vendor/chartjs/Chart.bundle.min.js"></script>
<script src="../vendor/select2/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  


<script type="text/javascript">

    $(document).ready(function(){
	
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cadastro'])){
            ?> load_cadastro();<?php
        }
        else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit'])){
            ?> load_edit(<?=$_GET['edit']?>);<?php    
        }else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nota'])){
            ?> <?php
        }else if($_SERVER['REQUEST_METHOD'] === 'GET'){
            ?> load_compras();<?php 
        }?>

        $('.js-example-basic-single').select2({
            placeholder: 'Filtre por data',
            allowClear: true,
        });

        $('#datafilter').on('select2:select', function (e) {
        
            let value = e.params.data.id;
            data_filter(value);

        });

        function data_filter(month){
            $.ajax({
                url:"funcoes/tabela_compras.php",
                method:"post",
                data:{filter:month},
                success:function(data)
                {
                    // renderizar a tabela e os elementos
                    $('#tabela_compras').html(data); 
                    //
                }
            });
        }
        
        function load_cadastro(query){
            $.ajax(
                {
                    url:"funcoes/cadastro_compras.php",
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
    

        function load_compras(query){
            $.ajax(
                {
                    url:"funcoes/tabela_compras.php",
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


        
    
        function load_edit(query){
            $.ajax(
                {
                    url:"funcoes/edit_compra.php",
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

            $('.au-btn--small').on("click", function(){
                Swal.fire({
                    title: 'Alerta',
                    text: "Você deseja ir para o cadastro de compra?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(function() {
                            window.location.href = "compras?cadastro";
                        }, 200)
                        
                    }
                })
            });

            <?php if(isset($_GET['nota'])){
                ?>
            
                $("#insert_nf").on("submit", function (event) {
                    event.preventDefault();
                    $.ajax({
                        method: "POST",
                        url: "funcoes/insert_nota.php?id=<?=$_GET['nota']?>",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function (json) {
                            console.log(json);
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
                                    text: 'Tipo de arquivo não permitido, escolha entre jpg, jpeg, png, pdf, xls ou xlsx!'
                                })
                            }else if(resposta.erro == true && resposta.msg == 'query'){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: 'Aconteceu algum erro em atualizar sua foto, tente novamente'
                                })
                            }else if(resposta.erro == true && resposta.msg == 'content_length'){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: 'O arquivo que você enviou é muito pesado para o sistema!'
                                })
                            }else if(resposta.erro == false){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso',
                                    text: 'Nota fiscal atrelada!'
                                })
                                setTimeout(function() {
                                    location.reload();
                                    }, 1000)
                            }
                        }
                    })
                });
            <?php } ?>

            
    });
</script>
<script>
    
    <?php if(!isset($_GET['cadastro']) && !isset($_GET['edit']) && !isset($_GET['nota'])){
        ?>
        const tabela = document.querySelector("#tabela_compras");

        const listarUsuarios = async (pagina) => {
            const dados = await fetch("funcoes/tabela_compras.php?pagina=" + pagina);
            const resposta = await dados.text();
            tabela.innerHTML = resposta;
        }

        listarUsuarios(1);
        
        function redirecionarCompra(id,nome){
            Swal.fire
            (
                {
                    title: 'Voce deseja enviar a compra ' + nome + ' para compras da Vetorian?',
                    showDenyButton: true,
                    confirmButtonText: 'Sim',
                    denyButtonText: `Não`,
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
                }
            ).then(
                (result) => {
                    if (result.isConfirmed) {
                        const arrayPost = {
                            id: id
                        };
                        const requestOptions = {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(arrayPost),
                        };
                        console.log(arrayPost);
                        return fetch('funcoes/envia_vetorian.php', requestOptions)
                        .then(response => {
                                
                                if (!response.ok) {
                                throw new Error('A solicitação não foi bem-sucedida');
                                }
                                
                                return response.json();
                            })
                            .then(data => {
                                console.log(data);
                                if(data.erro == false){
                                    Swal.fire('Compra redirecionada à Vetorian.', '', 'success')
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000)
                                }else{
                                    console.log(data);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro!',
                                        text: data.msg,
                                    })
                                }
                            })
                    }
                }
            )
        }

        function deletaCompra(id, nome){
            Swal.fire
            (
                {
                    title: 'Voce deseja deletar a compra ' + nome + '?',
                    showDenyButton: true,
                    confirmButtonText: 'Sim',
                    denyButtonText: `Não`,
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
                }
            ).then(
                (result) => {
                if (result.isConfirmed) {
                    const arrayPost = {
                            id: id
                        };
                    const requestOptions = 
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(arrayPost),
                    };
                    console.log(arrayPost);
                    return fetch('funcoes/delete_compra.php', requestOptions)
                    .then(response => {
                            
                            if (!response.ok) {
                            throw new Error('A solicitação não foi bem-sucedida');
                            }
                            
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);
                            if(data.erro == false){
                                Swal.fire('Você apagou o registro.', '', 'success')
                                setTimeout(function() {
                                    location.reload();
                                }, 1000)
                            }else{
                                console.log(data);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: data.msg,
                                })
                            }
                        })
                } else if (result.isDenied) {
                    Swal.fire('Registro não deletado!', '', 'info')
                }
                }
            )
    };
    <?php } ?>

function valida(path){
        if(path == undefined){
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi inserido nota fiscal',
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        }
    }

</script>

