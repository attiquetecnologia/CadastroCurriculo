<div class="container-fluid">
    <?php echo form_open(base_url().'enderecos/pesquisar', 'id="form-pesquisa"'); ?>
    <div class="input-group">
        <input type="text" id="pesquisa" name="pesquisa" class="form-control" placeholder="Pesquisa geral, cep, bairro...">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search" ></span>
            </button>
            <a href="<?php echo base_url().'enderecos/inserir';?>" class="btn btn-default" >
                <span class="glyphicon glyphicon-plus" ></span>
            </a>
        </span>
    </div><!-- /input-group -->
    <?php echo form_close(); ?>
    <table class="table table-striped">
        <th>id</th><th>Logradouro</th><th>CEP</th><th>Bairro</th><th>Cidade</th><th>UF</th><td>Ações</td>
    <?php foreach($enderecos as $endereco): ?>
        <tr>
            <td><?php echo $endereco->id ?></td>
            <td><?php echo $endereco->logradouro; ?></td>
            <td><?php echo $endereco->cep ?></td>
            <td><?php echo $endereco->bairro ?></td>
            <td><?php echo $endereco->cidade ?></td>
            <td><?php echo $endereco->uf ?></td>
            <td><a title="Editar" href="<?php echo base_url(). 'enderecos/editar/'.$endereco->id; ?>">Editar</a>
            |
            <a title="Deletar" href="<?php echo base_url() . 'enderecos/deletar/'.$endereco->id; ?>" onclick="return confirm('Confirma a exclusão deste registro?')">Excluir</a></td>
        </tr>
    <?php endforeach ?>
    </table><!-- end row -->
</div><!-- end container -->



