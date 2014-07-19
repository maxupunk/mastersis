<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-5"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>DATA</label><input type="text"
                                                        value="<?php
                                                        if (isset($pedido->PEDIDO_DATA)) {
                                                            echo date("d/m/Y - H:i:s", strtotime($pedido->PEDIDO_DATA));
                                                        } else {
                                                            echo date("d/m/Y - h:i:s");
                                                        }
                                                        ?>" disabled /></div>
        <div class="col-sm-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" id="pedido_id" value="<?php echo $pedido_id ?>" disabled /></div>
        <div class="col-sm-1"><br><?php echo anchor('pedido/DelPedido/' . $pedido_id, 'Excluir', 'class="btn btn-warning"'); ?></div>
        <div class="col-sm-1"><br><?php echo anchor('venda/pagamento/' . $pedido_id, 'Finaliza', 'class="btn btn-primary" id="InModel"'); ?></div>
    </div>
</div>
<div class="well">
    <div class="row">
        <div class="col-sm-10">
            <input type="text" name="PRO_DESCRICAO" id="ProdutoDesc" autocomplete="off"/>
            <input type="hidden" id="tipo" value="v">
        </div>
        <div class="col-sm-2">
            <?php echo anchor('venda/itens/' . $pedido_id, 'Atualizar', 'class="btn btn-warning" id="atualiza-pedido"'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" id="ListaPedido">
        <?php
        if ($lista_pedido <> NULL) {

            $this->table->set_heading('COD', 'DESCRIÇÃO', 'QNT', 'VALOR', 'SUBTOTAL');

            foreach ($lista_pedido as $linha) {
                $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
                $quantidade = '<input type="number" id="quantidade" min="1.00" step="1.00" ListPed="' . $linha->LIST_PED_ID . '" Estoque="' . $linha->ESTOQ_ID . '" value="' . $linha->LIST_PED_QNT . '">';
                $excluir = '<button type="button" class="close" id="excluir-item" ListPed="' . $linha->LIST_PED_ID . '">&times;</button>';
                $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $quantidade, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total), $excluir);
            }

            $tmpl = array('table_open' => '<table class="lista-produto">');
            $this->table->set_template($tmpl);

            echo $this->table->generate();
            ?>
            <div class="col-sm-12 BordaOs text-right">
                TOTAL A PAGAR : <?php echo $this->convert->em_real($total->total) ?>
            </div>
            <?php
        } else {
            echo "<p align='center'>Não foi usado produto(s)!</p>";
        }
        ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/pedidos.js'); ?>"></script>
