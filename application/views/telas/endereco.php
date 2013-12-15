<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group" id="sub_menu">
                            <button class="btn btn-default" url="<?php echo base_url('endereco'); ?>/bairro">Bairro</button>
                            <button class="btn btn-default" url="<?php echo base_url('endereco'); ?>/rua">Rua</button>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div id="cadastro"><!-- tabela de cadastro --></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <input type="text" name="buscar" url="<?php echo base_url('endereco'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Buscar endereço">
                    </div>
                    <div class="panel-body">
                        <div id="resultado"><!--resultado da busca --></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>