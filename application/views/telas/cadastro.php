<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs nav-justified sub-menu">
            <li><a href="<?php echo base_url('produto') ?>">Produto</a></li>
            <li><a href="<?php echo base_url('servico') ?>">Servico</a></li>            
            <li><a href="<?php echo base_url('pessoa') ?>">Pessoa</a></li>
            <li><a href="<?php echo base_url('usuario') ?>">Usario</a></li>
            <li><a href="<?php echo base_url('endereco') ?>">Endereco</a></li>
            <li><a href="<?php echo base_url('categoria') ?>">Categoria</a></li>
            <li><a href="<?php echo base_url('medida') ?>">Un. Medida</a></li>
            <li><a href="<?php echo base_url('produto/avaria') ?>">Avaria</a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-12">
                <div id="content-sub-menu" class="BordaCad"><!-- tabela de cadastro --></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-12 BordaCad">
                        <input type="text" name="buscar" id="busca" itemref="#" placeholder="Busca">
                        <div id="resultado"><!--resultado da busca --></div>
            </div>
        </div>
    </div>
</div>