<div class="well">
    <form action="<?php echo base_url('compras'); ?>/excluir/<?php echo $PedidoDados->PEDIDO_ID ?>" method="post" accept-charset="utf-8">
        <fieldset>

            <legend>Excluir esse pedido? <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></legend>

            <div class="row BordaOs">
                <div class="col-sm-6"><label>N. compra</label><br><?php echo $PedidoDados->PEDIDO_ID ?></div>
                <div class="col-sm-4"><label>Data decompra</label><br><?php echo $PedidoDados->PEDIDO_DATA ?></div>
                <div class="col-sm-2"><label>Estatus</label><br><?php echo $PedidoDados->PEDIDO_ESTATUS ?></div>
            </div>

            <div class="row BordaOs">
                <span>OBS.:</span>
                <div class="col-sm-12">
                    <?php echo $PedidoDados->PEDIDO_OBS ?>
                </div>
            </div>

            <div class="row BordaOs">
                <span>Numero do documento:</span>
                <div class="col-sm-12">
                    <?php echo $PedidoDados->PEDIDO_N_DOC ?>
                </div>
            </div>

            <input type="hidden" name="id_pedido" value="<?php echo $PedidoDados->PEDIDO_ID ?>" />

            <hr>
            <button type="submit" class="btn btn-danger">SIM, EXCLUIR</button>
            <button type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true">NÃO, CANSELAR</button>

        </fieldset>
    </form>
</div>