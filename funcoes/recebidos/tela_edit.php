<?php 
require '../../get_dados.php';
require '../../conexao.php';

$id =  $_POST['id'];

?>


<style>
    .div-parcelas{
        display: none;
    }

    .ifpagamento_remoto{
        display: none;
    }
</style>

<?php 

    $sql = "SELECT id, partnumber, data_entrega, 
    (SELECT nome FROM integrantes WHERE id = e.recebido_id LIMIT 1) as recebido_id,
    (SELECT nome FROM compras WHERE id = e.compra_id) AS nome,
    (SELECT data_compra FROM compras WHERE id = e.compra_id) AS data_compra
        FROM recebidos e WHERE id = $id";

    $query = mysqli_query($conexao,$sql);
    $array = mysqli_fetch_assoc($query);

    $recebido_id = $array['recebido_id'];
    $data_entrega =  $array['data_entrega'];
    $data_compra = $array['data_compra'];


?>
<div class="card">
    <div class="card-header">Recebimento</div>
    <div class="card-body">
        <div class="card-title">
            <h3 class="text-center"><?=$array['nome']?></h3>
        </div>
        <hr>
        <form id="form_edit" method="post">
            <div class="row">
                <div style="display: none;">
                    <div class="form-group">
                        <label for="id_produto" class="control-label mb-1">Id Produto</label>
                        <input id="id_produto" name="id_produto" class="form-control"
                        type="text" value="<?=$id?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="nome_produto" class="control-label mb-1">Nome Produto</label>
                        <input id="nome_produto" name="nome_produto" class="form-control" disabled
                        type="text" aria-required="true" aria-invalid="false" placeholder="Nome do produto" value="<?=$array['nome']?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="partnumber_produto" class="control-label mb-1">PartNumber</label>
                        <input id="partnumber_produto" name="partnumber_produto" type="text" class="form-control" disabled
                        aria-required="true" aria-invalid="false" placeholder="PartNumber do produto" value="<?=$array['partnumber']?>"> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="recebido" class="control-label mb-1">Recebido por</label>
                        <?php
                        
                        if($recebido_id == ''){
                            $sql = "SELECT * from integrantes order by nome asc";
                        }else{
                            $sql = "SELECT * from integrantes order by FIND_IN_SET(id, '$recebido_id') desc";
                        }
                        
                        $query = mysqli_query($conexao, $sql);
                        ?>
                        <select name="recebido" id="recebido" class="form-control">
                            <?php 
                            while($array = mysqli_fetch_assoc($query)){
                                $recebido = $array["nome"];
                                echo "<option>$recebido</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="data_compra" class="control-label mb-1">Data da compra</label>
                        <input id='data_compra' name='data_compra' type='date' class='form-control' value='<?=$data_compra?>' disabled>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="data_entrega" class="control-label mb-1">Data da entrega</label>
                        <?php
                        if($data_entrega == ''){
                            echo '<input id="data_entrega" name="data_entrega" type="date" aria-required="true" class="form-control">';
                        }else{
                            echo "<input id='data_entrega' name='data_entrega' type='date'  aria-required='true' class='form-control' value='$data_entrega'>";    
                        }
                        ?>
                    </div>
                </div>
            </div>            
            <div>
                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                    <span>Editar</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    
    $('#form_edit').on("submit", function(event){
        var data_entrega = $("#data_entrega").val();
        
        if(data_entrega == ''){
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Preencha uma data!'
            }) 
        }else{
            Swal.fire({
            title: 'Alerta',
            text: "Você desejar confirmar o recebimento?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim!',
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
                        method: "POST",
                        url: "funcoes/recebidos/backend_edit.php",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Aguarde...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function (result) {
                            console.log(result);
                            Swal.close();
                            var json = JSON.parse(result);
                            if(json.erro == false){
                                let timerInterval
                                Swal.fire({
                                icon: 'success',                                    
                                title: json.msg,
                                html: 'Fechando em <b></b>  milisegundos',
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                            window.location.href = "http://127.0.0.1/estoque_git/recebidos"
                                    }
                                })
                            }else if(json.erro == true){
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

                            }else if(json.erro == 'data'){
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
                    })
                }
            })
        }

        event.preventDefault();
        
        });

})
</script>