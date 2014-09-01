<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-5"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>DATA</label><input type="text"
                                                        value="<?php echo isset($pedido->PEDIDO_DATA) ? date("d/m/Y - H:i:s", strtotime($pedido->PEDIDO_DATA)) : date("d/m/Y - h:i:s") ?>" disabled /></div>
        <div class="col-sm-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" id="pedido_id" value="<?php echo $pedido_id ?>" disabled /></div>
        <div class="col-sm-1"><br><?php echo anchor('pedido/DelPedido/' . $pedido_id, 'Excluir', 'class="btn btn-warning"'); ?></div>
        <div class="col-sm-1"><br><?php echo anchor('venda/pagamento/' . $pedido_id, 'Finaliza', 'class="btn btn-primary" id="InModel"'); ?></div>
    </div>
</div>
<div class="well">
    <div class="row">
        <div class="col-sm-6">
            <input type="text" name="PRO_DESCRICAO" id="ProdutoDesc" autocomplete="off"/>
            <input type="hidden" id="tipo" value="v">
        </div>
        <div class="col-sm-3">
            <?php echo anchor('venda/itens/' . $pedido_id, 'Nova Venda', 'class="btn btn-primary" id="atualiza-pedido"'); ?>
            <?php echo anchor('venda/itens/' . $pedido_id, 'Atualizar', 'class="btn btn-warning" id="atualiza-pedido"'); ?>
        </div>
        <div class="col-sm-2">
            <br>
            <input type="hidden" id="IdCliente" value="">
            <span id="pessoa-selec"></span>
            <input type="text" id="pessoa" autocomplete="off" value="" placeholder="Cliente"/>
        </div>
        <div class="col-sm-1">
            <br>
            <input type="text" id="IdPed" autocomplete="off" value="" placeholder="N. venda"/>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" id="ListaPedido">
        <?php $this->load->view("telas/pedido_itens"); ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/pedidos.js'); ?>"></script>
