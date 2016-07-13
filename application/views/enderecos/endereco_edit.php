<script>
$(document).ready( function() {
$("#cep").on("blur",function(){                   
    var base_url = '<?php echo base_url(); ?>'; 
    var controller = 'enderecos';
    var action = 'search_cep';
    var cep = $(this).val();

    //requisicao ajax enviando os parâmetros via POST
    $.ajax({
        'url' : base_url + controller + '/' + action + '/' + cep,
        'type' : 'POST', 
        'data' : {'cep' : cep},
        'success' : function(data){
            //recuperando o resultado via json
            var dado = $.parseJSON(data);
            //populando os valores                      
            $("#logradouro").val(dado.logradouro);
            $("#bairro").val(dado.bairro);
            $("#cidade").val(dado.cidade);
            $("#id").val(dado.id_endereco);
            $("#uf").val(dado.uf);
        }
    });
});
});//fim document ready
</script>
<div class="row">
    <hr>
    <?php echo form_open(base_url().'enderecos/cadastro', 'id="form-enderecos"'); ?>

    <input type="hidden" name="id" value="<?php echo $IS_EDITAR ? $dados[0]->id : "0" ?>"/>
    <div class="col-md-6">
        <label for="cep">CEP:</label><br/>
        <div class="input-group">
            <input type="text" id="cep" name="cep" class="form-control" placeholder="Search cep" value="<?php echo $IS_EDITAR ? $dados[0]->cep : "" ?>">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" onclick="busca_cep();">
                        <span class="glyphicon glyphicon-search" ></span>
                    </button>
                </span>
        </div><!-- /input-group -->
        <?php echo form_error('cep'); ?>
        
        <label for="logradouro">Logradouro:</label><br/>
        <input type="text" id="logradouro" name="logradouro" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->logradouro : "" ?>"/>
        <?php echo form_error('logradouro'); ?>

        <label for="bairro">Bairro:</label><br/>
        <input type="text" id="bairro" name="bairro" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->bairro : ""?>"/>
        <?php echo form_error('bairro'); ?>
    </div>
    <div class="col-md-6">
        <label for="cidade">Cidade:</label><br/>
        <input type="text" id="cidade" name="cidade" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->cidade : "" ?>"/>
        <?php echo form_error('cidade'); ?>

        <label for="uf">UF:</label><br/>
        <input type="text" id="uf" name="uf" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->uf : ""?>"/>
        <?php echo form_error('uf'); ?>
        <input type="submit" name="salvar" class="btn btn-primary" value="Salvar" />
    </div>
    

    <?php echo form_close(); ?>
</div>
<!-- end container -->
