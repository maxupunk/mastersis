<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="col-sm-6"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>DATA</label><input type="text" value="<?php if (isset($pedido->PEDIDO_DATA)) { echo $pedido->PEDIDO_DATA; } else { echo date("Y-m-d h:i:s"); } ?>" disabled /></div>
        <div class="col-sm-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" value="<?php echo $id_venda ?>" disabled /></div>
        <div class="col-sm-1"><br><?php echo anchor('venda/cansela/'.$id_venda, 'Cansela', 'class="btn btn-warning"'); ?></div>
    </div>
</div>
<hr>
<div class="well">
    <label>Digite a descrição, caracteristica ou id do produto</label>
    <input type="text" name="PRO_DESCRICAO" id="produto_venda" autocomplete="off"/>
</div>
