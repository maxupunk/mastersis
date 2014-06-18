<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
<?php } ?>
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