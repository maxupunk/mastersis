<div class="row">

    <div class="col-md-6"><!-- coluna esquerda -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Ordem de Serviços em aberto.
                <span class="badge"><?php echo count($emabertos) ?></span>
                <a href="#" class="btn btn-success btn-xs pull-right" id="NovoOs">Nova</a>
            </div>
            <div class="panel-body">
                <?php
                if ($emabertos <> NULL) {
                    
                $this->table->set_heading('COD', 'CLIENTE', 'OPÇÕES');

                foreach ($emabertos as $linha) {
                    $this->table->add_row($linha->OS_ID, $linha->PES_NOME,
                            '<a href="ordemservico/detalhes/'.$linha->OS_ID.'" id="LinkOS" class="btn btn-info btn-xs">Detalhes</a>
                             <a href="ordemservico/editar/'.$linha->OS_ID.'" id="LinkOS" class="btn btn-warning btn-xs">Editar</a>
                             <a href="#" id="LinkOS" class="btn btn-danger btn-xs">Apagar</a>');
                }

                $tmpl = array('table_open' => '<table class="table table-hover">');
                $this->table->set_template($tmpl);

                echo $this->table->generate();
                } else {
                            echo "Não á serviço(s) em aberto!";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-6"><!-- coluna direita -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Ordem de serviços pendentes.
                        <span class="badge"><?php echo count($pendentes) ?></span>
                    </div>
                    <div class="panel-body">

                        <?php
                        if ($pendentes <> NULL) {

                            $this->table->set_heading('COD', 'CLIENTE', 'OPÇÕES');

                            foreach ($pendentes as $linha) {
                                $this->table->add_row($linha->OS_ID, $linha->PES_NOME,
                            '<a href="ordemservico/detalhes/'.$linha->OS_ID.'" id="LinkOS" class="btn btn-info btn-xs">Detalhes</a>
                             <a href="ordemservico/editar/'.$linha->OS_ID.'" id="LinkOS" class="btn btn-warning btn-xs">Editar</a>
                             <a href="#" id="LinkOS" class="btn btn-danger btn-xs">Apagar</a>');
                            }

                            $tmpl = array('table_open' => '<table class="table table-hover">');
                            $this->table->set_template($tmpl);

                            echo $this->table->generate();
                        } else {
                            echo "Não á serviço(s) pendente(s)!";
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Concluidos (Aguardando entrega).
                        <span class="badge"><?php echo count($concluidos) ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        if ($concluidos <> NULL) {

                            $this->table->set_heading('COD', 'CLIENTE', 'OPÇÕES');

                            foreach ($concluidos as $linha) {
                                $this->table->add_row($linha->OS_ID, $linha->PES_NOME,
                            '<a href="ordemservico/detalhes/'.$linha->OS_ID.'" id="LinkOS" class="btn btn-info btn-xs">Detalhes</a>
                             <a href="ordemservico/editar/'.$linha->OS_ID.'" id="LinkOS" class="btn btn-warning btn-xs">Editar</a>
                             <a href="#" id="LinkOS" class="btn btn-danger btn-xs">Apagar</a>');
                            }

                            $tmpl = array('table_open' => '<table class="table table-hover">');
                            $this->table->set_template($tmpl);

                            echo $this->table->generate();
                        } else {
                            echo "Não á serviço(s) concluido(s)!";
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div> <!-- coluna direita -->

</div> <!-- ROW principal -->

<div  class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><input type="text" name="buscar" url="<?php echo base_url('endereco'); ?>/busca?buscar=" id="busca" class="form-control" placeholder="Buscar por cliente"></div>
            <div class="panel-body">
                <div id="resultado"><!--resultado da busca --></div>
            </div>
        </div>
    </div>
</div>