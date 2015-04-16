<?php
if (isset($mensagem) and $mensagem != NULL)
    echo '<div class="alert alert-info">' . $mensagem . '</div>';

if ($total->total == NULL) {
    echo 'Não é possivel finalisa a ordem de serviço. Não existe serviço ou produtos na ordem.';
    exit;
}
?>
<form action="<?php echo base_url('ordemservico'); ?>/entregar/<?php echo $id_pedido ?>" id="SubmitAjax" method="post" accept-charset="utf-8">
    <fieldset>
    <div class="row">
        <div class="col-sm-9"><label>CLIENTE</label><input type="text" name="PES_NOME" value="<?php echo $pessoa->PES_NOME ?>" readonly /></div>
        <div class="col-sm-3"><label>PEDIDO</label><input type="text" name="PEDIDO_ID" id="id_pedido" value="<?php echo $id_pedido ?>" readonly /></div>
    </div>
    <div class="row">
        <div class="col-sm-4"><label>TOTAL</label><input type="text" name="valor-total" id="valor-total" value="<?php echo $this->convert->em_real($total->total); ?>" class="valor" readonly /></div>
    </div>

    <input type="hidden" name="PEDIDO_ID" value="<?php echo $id_pedido ?>"/>

    </fieldset>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default">Finalizar</button>
    </div>
</form>