<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-5"><label>FORNECEDOR</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>DATA</label><input type="text"
                                                        value="<?php echo isset($pedido->PEDIDO_DATA) ? date("d/m/Y - H:i:s", strtotime($pedido->PEDIDO_DATA)) : date("d/m/Y - h:i:s") ?>" disabled /></div>
        <div class="col-sm-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" id="IdPed" value="<?php echo $IdPed ?>" disabled /></div>
        <div class="col-sm-2"><br>
            <?php echo anchor('pedido/DelPedido/' . $IdPed . '/compras', 'Excluir', 'class="btn btn-warning"'); ?>
            <?php echo anchor('compras/fecha/' . $IdPed, 'Fechar', 'class="btn btn-primary" id="InModel"'); ?></div>
    </div>
</div>
<div class="well">
    <div class="row">
        <div class="col-sm-9">
            <input type="text" name="PRO_DESCRICAO" id="ProdutoDesc" autocomplete="off"/>
            <input type="hidden" id="tipo" value="c">
        </div>
        <div class="col-sm-3">
            <?php echo anchor('produto', 'Add Pro', 'class="btn btn-success" id="InModel"'); ?>
            <?php echo anchor('venda/itens/' . $IdPed, 'Atualiza', 'class="btn btn-warning" id="atualiza-pedido"'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" id="ListaPedido">
        <?php $this->load->view("telas/pedido_itens"); ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/pedidos.js'); ?>"></script>
