<div class="row">
    <div class="col-sm-6">
        <div class="btn-group" id="sub_menu">
            <button class="btn btn-default" url="<?php echo base_url('endereco'); ?>/bairro">Bairro</button>
            <button class="btn btn-default" url="<?php echo base_url('endereco'); ?>/rua">Rua</button>
        </div>

        <div id="cadastro"><!-- tabela de cadastro --></div>
    </div>

    <div class="col-sm-6">
        <div class="well">
            <input type="text" name="buscar" url="<?php echo base_url('endereco'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Buscar endereço">
        </div>
        <div id="resultado"><!--resultado da busca --></div>

    </div>
</div>