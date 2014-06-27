<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-5"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>DATA</label><input type="text"
                                                        value="<?php
                                                        if (isset($pedido->PEDIDO_DATA)) {
                                                            echo $pedido->PEDIDO_DATA;
                                                        } else {
                                                            echo date("Y-m-d h:i:s");
                                                        }
                                                        ?>" disabled /></div>
        <div class="col-sm-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" id="pedido_id" value="<?php echo $pedido_id ?>" disabled /></div>
        <div class="col-sm-1"><br><?php echo anchor('venda/excluirpedido/' . $pedido_id, 'Excluir', 'class="btn btn-warning"'); ?></div>
        <div class="col-sm-1"><br><?php echo anchor('venda/pagamento', 'Finaliza', 'class="btn btn-primary" id="pagamento"'); ?></div>
    </div>
</div>
<div class="well">
    <div class="row">
        <div class="col-sm-10">
            <input type="text" name="PRO_DESCRICAO" id="produto_venda" autocomplete="off"/>
        </div>
        <div class="col-sm-2">
            <?php echo anchor('venda/itens/' . $pedido_id, 'Atualizar', 'class="btn btn-warning" id="atualiza-pedido"'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" id="ListaVenda">
        <?php
        if ($lista_pedido <> NULL) {

            $this->table->set_heading('', '', 'QNT', 'MEDIDA', 'DESCRIÇÃO', 'PESO(Kg)', 'PREÇO(UN)', 'SUB. TOTAL', '');

            foreach ($lista_pedido as $linha) {

                $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);

                $linha->PRO_IMG != null ? $icone = str_replace(".jpg", "_thumb.jpg", $linha->PRO_IMG) : $icone = "sem_img.gif";

                $this->table->add_row($linha->PRO_ID, '<img src="assets/arquivos/produto/' . $icone . '" class="img-rounded" width="80" height="80">', '<input type="number" id="quantidade" min="1.00" step="1.00" max="' . $linha->ESTOQ_ATUAL . '" list_ped_id="' . $linha->LIST_PED_ID . '" id_estoque="' . $linha->ESTOQ_ID . '" value="' . $linha->LIST_PED_QNT . '">', $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, $linha->PRO_PESO, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total), '<button type="button" class="close" id="excluir-item" list_ped_id="' . $linha->LIST_PED_ID . '">&times;</button>');
            }

            $tmpl = array('table_open' => '<table class="table table-hover">');
            $this->table->set_template($tmpl);

            echo $this->table->generate();
            ?>
            <div class="col-sm-12 BordaOs text-right">
                TOTAL A PAGAR : <?php echo $this->convert->em_real($total->total) ?>
            </div>
        <?php } ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/vendas.js'); ?>"></script>
