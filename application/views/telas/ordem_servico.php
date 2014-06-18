<div class="row">
    <?php
    if ($this->session->flashdata('mensagem'))
        echo '<div class="alert alert-info">' . $this->session->flashdata('mensagem') . '</div>';
    ?>
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
                            '<a href="ordemservico/itens/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-success btn-xs">Itens</a>
                             <a href="ordemservico/imprimir/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-info btn-xs">Imprimir</a>
                             <a href="ordemservico/editar/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-warning btn-xs">Editar</a>
                             <a href="ordemservico/excluir/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-danger btn-xs">Apagar</a>');
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
                            '<a href="ordemservico/imprimir/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-info btn-xs">Imprimir</a>
                             <a href="ordemservico/editar/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-warning btn-xs">Editar</a>
                             <a href="ordemservico/excluir/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-danger btn-xs">Apagar</a>');
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
    </div>

    <div class="row">

        <div class="col-md-6">
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
                            '<a href="ordemservico/imprimir/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-info btn-xs">Imprimir</a>
                             <a href="ordemservico/editar/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-warning btn-xs">Editar</a>
                             <a href="ordemservico/excluir/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-danger btn-xs">Apagar</a>');
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

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ultimas ordens entregues.
                    <span class="badge"><?php echo count($entregues) ?></span>
                </div>
                <div class="panel-body">
                    <?php
                    if ($entregues <> NULL) {

                        $this->table->set_heading('COD', 'CLIENTE', 'OPÇÕES');

                        foreach ($entregues as $linha) {
                            $this->table->add_row($linha->OS_ID, $linha->PES_NOME, 
                            '<a href="ordemservico/imprimir/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-info btn-xs">Imprimir</a>
                             <a href="ordemservico/editar/' . $linha->OS_ID . '" id="LinkOS" class="btn btn-warning btn-xs">Editar</a>');
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