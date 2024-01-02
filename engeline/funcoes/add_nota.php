<?php 

include_once '../../conexao.php';
include '../../get_dados.php';

$path_nf = '';
?>
    <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
            <div class="card">
                
                <div class="card-header">
                    Insira a <strong>NOTA FISCAL</strong>
                </div>       
                <div class="media">
                        <img class="rounded-circle mr-3" 
                        <?php //style="width:85px; height:85px;"?> 
                        src="<?php echo "$path_nf"?>">
                    
                </div>
                <div class="card-body card-block">
                    <form id='insert_nf' method="post" enctype="multipart/form-data" class="form-horizontal">
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
</div>

<script>
    $(document).ready(function(){
        
    });

</script>




