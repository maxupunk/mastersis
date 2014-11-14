<div class="panel-group" id="accordion">
    <?php if ($pedidos_cliente == null) { ?>
    <h4 class="text-center">Não existe compras em espera.</h4>
        <?php
        exit();
    }

    foreach ($pedidos_cliente as $linha) {

        $total = $this->geral_model->TotalPedido($linha->PEDIDO_ID)->row();
        $ToralItens = $this->join_model->ListaPedido($linha->PEDIDO_ID)->num_rows();
        $Fornecedor = $this->crud_model->pega("PESSOAS", array("PES_ID" => $linha->PES_ID))->row();
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">

                    <div class="pull-right">
                        <a href="pedido/receber/<?php echo $linha->PEDIDO_ID ?>" id="InModel" class="btn-xs btn-success">Receber</a>
                        <a href="compras/abrir/<?php echo $linha->PES_ID ?>" id="EditaPedido" class="btn-xs btn-warning">Alterar</a>
                        <a href="pedido/Delete/<?php echo $linha->PEDIDO_ID ?>" id="InModel" class="btn-xs btn-danger">Canselar</a>
                    </div>
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $linha->PEDIDO_ID ?>">
                        <?php echo $Fornecedor->PES_NOME ?> | PEDIDO: <?php echo $linha->PEDIDO_ID ?> - <?php echo date("d/m/Y - H:i:s", strtotime($linha->PEDIDO_DATA)); ?> | TOTAL: <?php echo $this->convert->em_real($total->total); ?> | <?php echo $this->convert->EstatusPedido($linha->PEDIDO_ESTATUS); ?>
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

                            $this->table->add_row($linha->PRO_ID, $linha->LIST_PED_QNT, $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, $linha->PRO_PESO, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total));
                        }

                        $this->table->add_row('', '', '', '', '', 'TOTAL', $this->convert->em_real($total->total));

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