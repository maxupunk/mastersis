<div class="row">
    <div class="span6">
        <script src="<?php echo base_url('application/views/js/forms.js'); ?>"></script>
        <script src="<?php echo base_url('application/views/js/cadastro.js'); ?>"></script>

        <div class="btn-group" id="sub_menu">
            <button class="btn" url="<?php echo base_url('endereco'); ?>/bairro">Bairro</button>
            <button class="btn" url="<?php echo base_url('endereco'); ?>/rua">Rua</button>
        </div>

        <div id="cadastro"><!-- tabela de cadastro --></div>
    </div>

    <div class="span6">
        <div class="well">
            <input type="text" name="buscar" url="<?php echo base_url('endereco'); ?>/busca?buscar=" id="busca" class="search-query span5" placeholder="Buscar endereço">
        </div>
        <div id="resultado"><!--resultado da busca --></div>

    </div>
</div>