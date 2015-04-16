<form action="<?php echo base_url('financeiro'); ?>/novo" method="post" id="finanSubmit" accept-charset="utf-8">

    <?php
    echo validation_errors();
    if (isset($mensagem) and $mensagem != NULL) {
        echo '<div class="alert alert-info">' . $mensagem . '</div>';
        exit();
    }
    ?>
    <fieldset>

        <label>NOME DA CLIENTE/FORNECEDOR</label>
        <input type="text" autocomplete="off" id="pessoa" value="<?php echo set_value('PES_NOME', $query->PES_NOME); ?>" disabled />

        <div class="row">
            <div class="col-sm-3">
                <label>NATUREZA</label>
                <select disabled >
                    <option value="1" <?php echo set_select('DESREC_NATUREZA', '1', ($query->DESREC_NATUREZA == "1" ? TRUE : FALSE)); ?>>Receita</option>
                    <option value="2" <?php echo set_select('DESREC_NATUREZA', '2', ($query->DESREC_NATUREZA == "2" ? TRUE : FALSE)); ?>>Despeza</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label>PARCELA</label>
                <input type="text" value="<?php echo ($Parcelas->qnt - $query->PEDIDO_NPARC + 1) ?> DE <?php echo ($query->PEDIDO_NPARC != NULL ? $query->PEDIDO_NPARC : $query->OS_NPARC) ?>" disabled />
            </div>
            <div class="col-sm-3">
                <label>VALOR</label>
                <input type="text" value="<?php echo $this->convert->em_real($query->DESREC_VALOR) ?>" class="valor" disabled />                
            </div>
            <div class="col-sm-3">
                <label>VENCIMENTO</label>
                <input type="text" value="<?php echo date("d/m/Y", strtotime($query->DESREC_VECIMENTO)); ?>" disabled />
            </div>
        </div>

        <div class="row">
            <?php if ($query->PEDIDO_ID != NULL): ?>
                <div class="col-sm-2">
                    <label class="PedOsId">PEDIDO</label>
                    <input type="text" value="<?php echo $query->PEDIDO_ID ?>" disabled />
                </div>
                <div class="col-sm-4">
                    <label>DATA DO PEDIDO</label>
                    <input type="text" value="<?php echo date("d/m/Y - H:i:s", strtotime($query->PEDIDO_DATA)); ?>" disabled />
                </div>
            <?php elseif ($query->OS_ID != NULL): ?>
                <div class="col-sm-2">
                    <label>ORDEM</label>
                    <input type="text" value="<?php echo $query->OS_ID ?>" disabled />
                </div>
                <div class="col-sm-4">
                    <label>DATA DO PEDIDO</label>
                    <input type="text" value="<?php echo $query->OS_DATA_ENT ?>" disabled />
                </div>
            <?php endif; ?>
        </div>

        <label>DESCRIÇÃO</label>
        <input type="text" name="DESREC_DESCR" value="<?php echo set_value('DESREC_DESCR', $query->DESREC_DESCR); ?>" />

        <input type="hidden" name="PES_ID" id="PES_ID" value="<?php echo $query->PES_ID ?>"/>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Baixar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Canselar</button>
        </div>

    </fieldset>

</form>