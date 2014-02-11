<div class="panel-group" id="accordion">
    <?php foreach ($pedidos_cliente as $linha) { ?>
    <?php
    $total = $this->geral_model->TotalPedido($linha->PEDIDO_ID)->row();
    $ToralItens = $this->join_model->ListaPedido($linha->PEDIDO_ID)->num_rows()
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $linha->PEDIDO_ID ?>">
                        
                        <span class="badge pull-right">+</span>
                        N. do Pedido: <?php echo $linha->PEDIDO_ID ?> / Estatus: <?php echo $linha->PEDIDO_ESTATUS ?> / Data: <?php echo $linha->PEDIDO_DATA ?> /  N. Itens: <?php echo $ToralItens; ?> / Total: <?php echo $total->total; ?>
                        
                    </a>
                </h4>
            </div>
            <div id="<?php echo $linha->PEDIDO_ID ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    
                    <?php
                    $pedido = $this->join_model->ListaPedido($linha->PEDIDO_ID)->result();

                    $this->table->set_heading('ID', 'QUANTIDADE', 'MEDIDA', 'DESCRIÇÃO', 'PESO(Kg)', 'PREÇO(UN)', 'SUB. TOTAL');

                    foreach ($pedido as $linha) {

                        $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);

                        $this->table->add_row($linha->PRO_ID, $linha->LIST_PED_QNT, $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, $linha->PRO_PESO, \money_format('%n', $linha->LIST_PED_PRECO), money_format('%n', $sub_total));
                    }

                    $this->table->add_row('', '', '', '', '', 'TOTAL', money_format('%n', $total->total));

                    $tmpl = array('table_open' => '<table class="table table-striped">');
                    $this->table->set_template($tmpl);
                    echo $this->table->generate();
                    ?>
                    
                </div>
            </div>
        </div>

    <?php } ?>
</div>
    <ul class="pagination" id="PagPedidos">
        <? if ($paginacao) echo $paginacao; ?>
</ul>