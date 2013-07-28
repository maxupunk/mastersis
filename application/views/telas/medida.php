<div class="row">
    <div class="col-6">
        <div class="btn-group" id="sub_menu">
            <button class="btn" url="<?php echo base_url('medida'); ?>/cadastrar">Cadastro</button>
        </div>

        <div id="cadastro"><!-- tabela de cadastro --></div>

    </div>

    <div class="col-6">
        <div class="well">
            <input type="text" name="buscar" url="<?php echo base_url('medida'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Busca medida">
        </div>
        <div id="resultado"></div><!--resultado da busca -->

    </div>
</div>