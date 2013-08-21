<div class="row">
    <div class="col-sm-6">
        <div class="btn-group" id="sub_menu">
            <button class="btn btn-default" url="<?php echo base_url('categoria'); ?>/cadastrar">Cadastro</button>
            <button class="btn btn-default" url="<?php echo base_url('categoria'); ?>/listar">Lista todas</button>
        </div>

        <div id="cadastro"><!-- tabela de cadastro --></div>

    </div>

    <div class="col-sm-6">
        <div class="well">
            <input type="text" name="buscar" url="<?php echo base_url('categoria'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Busca categoria">
        </div>
        <div id="resultado"></div><!--resultado da busca -->

    </div>
</div>