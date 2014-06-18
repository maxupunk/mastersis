<?php $usuario = $this->crud_model->pega('USUARIO', array('USUARIO_ID' => $Detalhes->USUARIO_ID))->row(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        Detalhes da ordem
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="panel-body">

        <div class="col-sm-12 impresao">
            <div class="row BordaOs">
                <div class="col-sm-6"><label>CLIENTE: </label><?php echo $Detalhes->PES_NOME ?></div>
                <div class="col-sm-4"><label>ENTRADA: </label><?php echo $Detalhes->OS_DATA_ENT ?></div>
                <div class="col-sm-2"><label>OS N.: </label><?php echo $Detalhes->OS_ID ?></div>
            </div>

            <div class="row">
                <span>EQUIPAMENTO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $Detalhes->OS_EQUIPAMENT ?>
                </div>
            </div>

            <div class="row">
                <span>DEFEITO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $Detalhes->OS_DSC_DEFEITO ?>
                </div>
            </div>

            <div class="row">
                <span>SOLUÇÃO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $Detalhes->OS_DSC_SOLUC ?>
                </div>
            </div>

            <div class="row">
                <span>DEPENDENCIA:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $Detalhes->OS_DSC_PENDENT ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($ListaProduto <> NULL) {

                        $this->table->set_heading('COD', 'DESCRIÇÃO', 'QNT', 'VALOR', 'SUBTOTAL');

                        foreach ($ListaProduto as $linha) {
                            $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
                            $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $linha->LIST_PED_QNT, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total));
                        }

                        $this->table->add_row('', '', '', 'TOTAL', $this->convert->em_real($ListaProdutoTotal->total));

                        $tmpl = array('table_open' => '<table class="table table-hover">');
                        $this->table->set_template($tmpl);

                        echo $this->table->generate();
                    } else {
                        echo "<p align='center'>Não foi usado produto(s)!</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($ListaServico <> NULL) {

                        $this->table->set_heading('COD', 'DESCRIÇÃO', 'QNT', 'VALOR', 'SUBTOTAL');

                        foreach ($ListaServico as $linha) {
                            $sub_total = ($linha->LIST_SRV_QNT * $linha->LIST_SRV_PRECO);
                            $this->table->add_row($linha->LIST_SRV_ID, $linha->SERV_NOME, $linha->LIST_SRV_QNT, $this->convert->em_real($linha->LIST_SRV_PRECO), $this->convert->em_real($sub_total));
                        }

                        $this->table->add_row('', '', '', 'TOTAL:', $this->convert->em_real($ListaServicoTotal->total));

                        $tmpl = array('table_open' => '<table class="table table-hover">');
                        $this->table->set_template($tmpl);

                        echo $this->table->generate();
                    } else {
                        echo "<p align='center'>Não foi feito servico(s)!</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-5 BordaOs pull-right">
                    TOTAL A PAGAR : <?php echo $this->convert->somar_real($ListaProdutoTotal->total, $ListaServicoTotal->total); //$this->convert->em_real();     ?>
                </div>
            </div>

            <div class="row">
                <span> OBSERVAÇÃO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $Detalhes->OS_OBSERVACAO ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 BordaOs">
                    <span>ENTREGUE: </span><?php echo $Detalhes->OS_DATA_SAI ?>
                </div>
                <div class="col-sm-4 BordaOs">
                    <span>USUARIO: </span><?php echo $usuario->USUARIO_LOGIN ?>
                </div>
                <div class="col-sm-2 BordaOs">
                    <?php echo $Estatus ?>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="button" id="imprimir" class="btn btn-primary">Imprimir</button>
            </div>
        </div>

    </div>
</div>