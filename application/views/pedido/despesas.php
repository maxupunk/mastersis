<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
<?php } ?>
<form action="<?php echo base_url('pedido'); ?>/Despesas/<?php echo $id_pedido ?>" id="SalvaDespesas" method="post" accept-charset="utf-8">
    <div class="row">
        <div class="col-xs-4">
            <label>IMPOSTO:</label>
            <input type="text" name="PEDIDO_IMPOSTO" value="<?php echo $this->convert->em_real($pedido->PEDIDO_IMPOSTO) ?>" class="valor">
        </div>
        <div class="col-xs-4">
            <label>FRETE:</label>
            <input type="text" name="PEDIDO_FRETE" value="<?php echo $this->convert->em_real($pedido->PEDIDO_FRETE) ?>" class="valor">
        </div>
        <div class="col-xs-4">
            <label>N do documento:</label>
            <input type="text" name="PEDIDO_N_DOC" value="<?php echo $pedido->PEDIDO_N_DOC ?>" maxlength="45"/>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <label>Observação:</label>
            <textarea name="PEDIDO_OBS" rows="3"><?php echo $pedido->PEDIDO_N_DOC ?></textarea>
        </div>
    </div>

    <input type="hidden" name="id_pedido" id="id_pedido" value="<?php echo $id_pedido ?>">
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>

</form>