<?php
if (isset($mensagem) and $mensagem != NULL)
    echo '<div class="alert alert-info">' . $mensagem . '</div>';

if ($total->total == NULL) {
    echo 'Não é possivel finalisa a ordem de serviço. Não existe serviço ou produtos na ordem.';
    exit;
}
?>
<div class="row">
    <div class="col-sm-9"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $pessoa->PES_NOME ?>" disabled /></div>
    <div class="col-sm-3"><label>PEDIDO</label><input type="text" id="id_pedido" value="<?php echo $id_pedido ?>" disabled /></div>
</div>
<div class="row">
    <div class="col-sm-4"><label>TOTAL</label><input type="text" name="valor-total" id="valor-total" value="<?php echo $total->total ?>" class="valor" disabled /></div>
</div>

<div class="botoes-modal">
    <button href="ordemservico/finaliza/<?php echo $id_pedido ?>" class="btn btn-default Model-Submit" id="InModel">Finalizar</button>
</div>