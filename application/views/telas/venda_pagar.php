<?php
if (isset($mensagem) and $mensagem != NULL)
    echo '<div class="alert alert-info">' . $mensagem . '</div>';

if ($total->total == NULL) {
    echo 'Não é possivel finalisa a compras. Não existe item nessa comprar.';
    exit;
}
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Finalizando venda avista</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-9"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $pessoa->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>PEDIDO</label><input type="text" value="<?php echo $id_pedido ?>" disabled /></div>
    </div>
    <div class="row">
        <div class="col-sm-4"><label>TOTAL</label><input type="text" name="valor-total" id="valor-total" value="<?php echo $total->total ?>" class="valor" disabled /></div>
    </div>
</div>
<div class="modal-footer">
    <button href="venda/fechapedido/<?php echo $id_pedido ?>" class="btn btn-default" id="InModel">Finalizar</button>
</div>