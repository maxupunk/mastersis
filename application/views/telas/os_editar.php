<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-6"><label>CLIENTE</label><br><?php echo $OsDados->PES_NOME ?></div>
            <div class="col-sm-4"><label>ENTRADA</label><br><?php echo $OsDados->OS_DATA_ENT ?></div>
            <div class="col-sm-2"><label>OS N.</label><br><?php echo $OsDados->OS_ID ?></div>
        </div>
    </div>
    <div class="panel-body">

        <div class="col-sm-12">
            <div class="row">
                <span>EQUIPAMENTO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $OsDados->OS_EQUIPAMENT ?>
                </div>
            </div>

            <div class="row">
                <span>DEFEITO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo form_error('OS_DSC_DEFEITO'); ?>
                    <textarea name="OS_DSC_DEFEITO" rows="6"><?php echo set_value('OS_DSC_DEFEITO', $OsDados->OS_DSC_DEFEITO); ?></textarea>
                </div>
            </div>

            <div class="row">
                <span>SOLUÇÃO:</span>
                <div class="col-sm-12 BordaOs">             
                    <?php echo form_error('OS_DSC_SOLUC'); ?>
                    <textarea name="OS_DSC_SOLUC" rows="6"><?php echo set_value('OS_DSC_SOLUC', $OsDados->OS_DSC_DEFEITO); ?></textarea>
                </div>
            </div>

            <div class="row">
                <span>DEPENDENCIA:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo form_error('OS_DSC_PENDENT'); ?>
                    <textarea name="OS_DSC_PENDENT" rows="6"><?php echo set_value('OS_DSC_PENDENT', $OsDados->OS_DSC_PENDENT); ?></textarea>
                </div>
            </div>

            <div class="row">
                <span>PRODUTOS:</span>
                <div class="col-sm-12 BordaOs" id="ListaProduto">
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
                <span>SERVICOS:</span>
                <div class="col-sm-12 BordaOs" id="ListaServico">
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
                    TOTAL A PAGAR : <?php echo $this->convert->somar_real($ListaProdutoTotal->total, $ListaServicoTotal->total) ?>
                </div>
            </div>

            <div class="row">
                <span>OBSERVAÇÃO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $OsDados->OS_OBSERVACAO ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 pull-right">
                    <?php echo form_dropdown('OS_ESTATUS', array('1' => 'ABERTO', '2' => 'PENDENTE', '3' => 'CONCLUIDO', '4' => 'ESTREGUE'), set_value('OS_ESTATUS', $Estatus->OS_ESTATUS)); ?>
                </div>
            </div>

        </div>

    </div>
</div>