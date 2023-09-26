<?php include_once '../../conexao.php';?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="table-responsive table--no-card m-b-30" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-borderless table-striped table-earning">
        <thead style="position: sticky; top: 0;">
            <tr>
                <th>nome</th>
                <th class="text-right">ID</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $sql = "SELECT * from categoria order by nome asc";
            $query = mysqli_query($conexao, $sql);
            while ($array = mysqli_fetch_array($query)) {
                $nome = $array['nome'];
                $id = $array['id']; 
                echo "<tr class='table-row' data-toggle='modal' data-target='#myModal-$id'>";
                    echo "<td> $nome </td>";
                    echo "<td  class='text-right'> $id </td>";
                echo "</tr>";
                ?>
                <div class="modal fade" id="myModal-<?=$id?>" role="dialog" data-bs-focus="false" aria-labelledby="myModalLabel-<?=$id?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">  
                                <h5 class="modal-title" id="myModalLabel-<?=$id?>">Categoria</h5>
                            </div>
                            <div class="modal-body">
                                <div class="event-info">
                                    <label class="col-sm-2 col-form-label"><strong>Título:</strong></label>
                                    <?=$nome?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!-- <button class="btn btn-warning btn-vis-edit">Editar</button> -->
                                <button class="btn btn-danger btn-delete" onclick="deletaCategoria('<?=$id?>', '<?=$nome?>')">Deletar</button>
                                <button class="btn btn-warning btn-vis-edit" onclick="editaCategoria('<?=$id?>')">Editar</button>
                                <button type="button" class="btn btn-primary btn-canc-edit" data-dismiss="modal">Cancelar</button>
                                
                                <!-- <button type="button" class="btn btn-primary">Confirm</button> -->
                            </div>
                        </div>
                    </div>
                </div> 
            <?php } ?>
        </tbody>
    </table>
</form>
</div>

<script>
    function editaCategoria(id){
        Swal.fire({
                title: 'Edite a categoria:' + id,
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                showLoaderOnConfirm: true,
                preConfirm: (text) => {
                    const arrayPost = {
                        categoria: text,
                        id: id
                    };

                    const requestOptions = {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(arrayPost),
                        };

                    return fetch('funcoes/categorias/categoria_edit.php', requestOptions)
                    .then(response => {
                        
                        if (!response.ok) {
                        throw new Error('A solicitação não foi bem-sucedida');
                        }
                        
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        console.log('aa');
                        if(data.erro == false){
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Registro alterado com sucesso!',
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
    }


    function deletaCategoria(id, nome){
        Swal.fire
        (
            {
                title: 'Voce deseja deletar a categoria: ' + nome +' ?',
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: `Não`,
            }
        ).then(
            (result) => {
            /* Read more about isConfirmed, isDenied below */
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
                return fetch('funcoes/categorias/categoria_delete.php', requestOptions)
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
    }
</script>