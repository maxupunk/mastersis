<?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="bg_venda">
    <div class="col-7"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
    <div class="col-3"><label>DATA</label><input type="text" value="<?php echo @$pedido->PEDIDO_DATA ?>" disabled /></div>
    <div class="col-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" value="<?php echo $id_venda ?>" disabled /></div>
</div>


<label>PRODUTO (DESCRIÇÃO OU ID) :</label>
<input type="text" name="PRO_DESCRICAO" id="produto_venda" autocomplete="off" autofocus />
<script src="<?php echo base_url('assets/js/vendas.js');  ?>"></script>