<div class="row">
    <div class="col-sm-6">
        <div class="btn-group" id="sub_menu">
            <button class="btn btn-default" url="<?php echo base_url('pessoa'); ?>/cadastrar">Cadastro</button>
        </div>

        <div id="cadastro"><!-- tabela de cadastro --></div>

    </div>

    <div class="col-sm-6">
        <div class="well">
            <input type="text" name="buscar" url="<?php echo base_url('pessoa'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Busca pessoa">
        </div>
        <hr>
        <div id="resultado"><!--resultado da busca --></div>

    </div>
</div>