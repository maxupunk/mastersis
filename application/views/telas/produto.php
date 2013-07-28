<div class="row">
    <div class="col-6">
        <div class="btn-group" id="sub_menu">
            <button class="btn" url="<?php echo base_url('produto'); ?>/cadastrar">Cadastro</button>
            <button class="btn" url="<?php echo base_url('produto'); ?>/listar">Lista todos</button>
        </div>

        <div id="cadastro"><!-- tabela de cadastro --></div>

    </div>

    <div class="col-6">
        <div class="well">
            <input type="text" name="buscar" url="<?php echo base_url('produto'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Busca produto">
        </div>
        <div id="resultado"><!--resultado da busca --></div>

    </div>
</div>