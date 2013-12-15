<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group" id="sub_menu">
                            <button class="btn btn-default" url="<?php echo base_url('servico'); ?>/cadastrar">Cadastro</button>
                            <button class="btn btn-default" url="<?php echo base_url('servico'); ?>/listar">Lista todos</button>
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
                        <input type="text" name="buscar" url="<?php echo base_url('servico'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Busca serviço">
                    </div>
                    <div class="panel-body">
                        <div id="resultado"><!--resultado da busca --></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>