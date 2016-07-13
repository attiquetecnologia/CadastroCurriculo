<script>
$(document).ready( function() {
$("#cep").on("blur",function(){                   
    var base_url = '<?php echo base_url(); ?>'; 
    var controller = 'enderecos';
    var action = 'search_cep';
    var cep = $(this).val();
    //window.alert(base_url + controller + '/' + action + '/' + cep);
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
            $("#endereco_id").val(dado.id_endereco);
            $("#bairro").val(dado.bairro);
            $("#cidade").val(dado.cidade);
            $("#uf").val(dado.uf);
        }
    });
});
});//fim document ready

jQuery(function($){
    var fileDiv = document.getElementById("upload");
    var fileInput = document.getElementById("upload-image");
    console.log(fileInput);
    fileInput.addEventListener("change",function(e){
        var files = this.files
        showThumbnail(files)
    },false)
    
    fileDiv.addEventListener("click",function(e){
        $(fileInput).show().focus().click().hide();
        e.preventDefault();
    },false)
    
    fileDiv.addEventListener("dragenter",function(e){
        e.stopPropagation();
        e.preventDefault();
    },false);
    
    fileDiv.addEventListener("dragover",function(e){
        e.stopPropagation();
        e.preventDefault();
    },false);
    
    fileDiv.addEventListener("drop",function(e){
        e.stopPropagation();
        e.preventDefault();
        
        var dt = e.dataTransfer;
        var files = dt.files;
        
        showThumbnail(files)
    },false);
    
    function showThumbnail(files) {
        loadImage(files[0]);
        counter = 0;
        function loadImage( file ) {
            var canvas = document.createElement("canvas"),
                img = new Image();
            
            img.onload = function() {
                var w = img.width / 10, h = img.height / 10;
                canvas.width = w;
                canvas.height = h;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, w, h);
                var sourceX = img.width * 0.30,
                    sourceY = img.height * 0.30,
                    sourceWidth = img.width * 0.40,
                    sourceHeight = img.height * 0.40;
                ctx.drawImage(img, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, w, h);
                URL.revokeObjectURL( img.src );
                img = null;
                
                if (files.length > counter) {
                    counter++;
                    loadImage(files[counter]);
                }
            };
            
            var URL = window.URL || window.webkitURL;
            
            img.src = URL.createObjectURL( file );
            
            var thumbnail = document.getElementById("thumbnail");
            thumbnail.appendChild(canvas);
        }
    }
    
    
});
</script>
<style>
#thumbnail img{
  width:100px;
  height:100px;
  margin:5px;
}
canvas{
  border:1px solid red;
}
</style>
<div class="row">
    <hr>
    <?php echo form_open_multipart(base_url().'pessoas/cadastro', 'id="form-pessoas"'); ?>

    <input type="hidden" id="id" name="id" value="<?php echo $IS_EDITAR ? $dados[0]->id : "0"; ?>"/>
    <input type="hidden" id="endereco_id" name="endereco_id" value="<?php echo $IS_EDITAR ? $dados[0]->endereco_id : "0"; ?>"/>
    <div class="col-md-6">
        <fieldset>
            <legend>Dados Gerais</legend>
            <label for="nome">Nome:</label><br/>
            <input type="text" name="nome" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->nome : "" ?>"/>
            <?php echo form_error('nome'); ?>

            <label for="sobrenome">Sobrenome:</label><br/>
            <input type="text" name="sobrenome" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->sobrenome : "" ?>"/>
            <?php echo form_error('sobrenome'); ?>

            <label for="contato">Contato:</label><br/>
            <input type="text" name="contato" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->contato : ""?>"/>
            <?php echo form_error('contato'); ?>
            
            <label for="captadopor">Capitdo por:</label><br/>
            <select name="captadopor" id="captadopor" class="form-control">
                <option value="VISITA">Visita</option>
                <option value="EMAIL">Email</option>
                <option value="INTERNET">Internet</option>
                <option value="JORNAL">Jornal</option>
                <option value="LIGACAO">Ligação</option>
                <option value="TELEVISAO">Televisão</option>
                <option value="AMIGO">Amigo</option>
                <option value="INDICACAO">Indicação</option>
                <option value="GOOGLE">Google</option>
                <option value="FACEBOOK">Facebook</option>
                <option value="LINKEDIN">Linkedin</option>
                <option value="OUTRO">Outro</option>
            </select>
            <label for="captador">Captador:</label>
            <select name="captador" class="form-control">
                <option value="1">Rodrigo Attique (1)</option>
            </select>
            <label for="foto">Foto:</label>
            <input type="file" id="upload-image" name="foto" size="20" class="form-control" <input type="file" />
            <!-- colocar o negócio para exibir foto -->
            <div id="thumbnail"></div>
            <label id="ativo">
                <input checked="checked" class="boolean" 
                       id="ativo" name="ativo" type="checkbox" value="on">Ativo</label>
            
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset>
            <legend>Endereço</legend>
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

            <label for="numero">Numero:</label><br/>
            <input type="text" id="numero_endereco" name="numero_endereco" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->numero_endereco : "" ?>"/>

            <label for="bairro">Bairro:</label><br/>
            <input type="text" id="bairro" name="bairro" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->bairro : ""?>"/>
            <?php echo form_error('bairro'); ?>

            <label for="cidade">Cidade:</label><br/>
            <input type="text" id="cidade" name="cidade" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->cidade : "" ?>"/>
            <?php echo form_error('cidade'); ?>

            <label for="uf">UF:</label><br/>
            <input type="text" id="uf" name="uf" class="form-control" value="<?php echo $IS_EDITAR ? $dados[0]->uf : ""?>"/>
            <?php echo form_error('uf'); ?>
        </fieldset>
    </div>
    <div class="col-md-12">
        <input type="submit" name="salvar" class="btn btn-primary" value="Salvar" />
    </div>
    <?php echo form_close(); ?>
</div>
<!-- end container -->



