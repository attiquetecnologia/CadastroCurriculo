<div class="container-fluid">
    <?php echo form_open(base_url().'pessoas/pesquisar', 'id="form-pesquisa"'); ?>
    <div class="input-group">
        <input type="text" id="pesquisa" name="pesquisa" class="form-control" placeholder="Pesquisa geral, nome, endereco...">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search" ></span>
            </button>
            <a href="<?php echo base_url()."pessoas/inserir"; ?>" class="btn btn-default">
                <span class="glyphicon glyphicon-plus" ></span>
            </a>
        </span>
    </div><!-- /input-group -->
    <?php echo form_close(); ?>
    <table class="table table-striped">
        <th>id</th><th>Nome</th><th>Sobrenome</th><th>Contato</th><th>Logradouro</th><th>Número</th><th>CEP</th><th>Bairro</th><th>Cidade</th><th>UF</th><td>Ações</td>
    <?php foreach($pessoas as $pessoa): ?>
        <tr>
            <td><?php echo $pessoa->id ?></td>
            <td><?php echo $pessoa->nome ?></td>
            <td><?php echo $pessoa->sobrenome ?></td>
            <td><?php echo $pessoa->contato ?></td>
            <td><?php echo $pessoa->logradouro; ?></td>
            <td><?php echo $pessoa->numero_endereco; ?></td>
            <td><?php echo $pessoa->cep ?></td>
            <td><?php echo $pessoa->bairro ?></td>
            <td><?php echo $pessoa->cidade ?></td>
            <td><?php echo $pessoa->uf ?></td>
            <td><a title="Editar" href="<?php echo base_url(). 'pessoas/editar/'.$pessoa->id; ?>">Editar</a>
            |
            <a title="Deletar" href="<?php echo base_url() . 'pessoas/deletar/'.$pessoa->id; ?>" onclick="return confirm('Confirma a exclusão deste registro?')">Excluir</a></td>
        </tr>
    <?php endforeach ?>
    </table><!-- end row -->
</div><!-- end container -->



