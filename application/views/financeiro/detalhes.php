<?php $TotalParc = isset($query->PEDIDO_NPARC) ? $query->PEDIDO_NPARC : '1'; ?>
<fieldset>

    <label>NOME DA CLIENTE/FORNECEDOR</label>
    <input type="text" autocomplete="off" value="<?php echo $query->PES_NOME ?>" disabled />

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
            <input type="text" value="<?php echo (($TotalParc - $Parcelas->qnt) + 1) ?> DE <?php echo $TotalParc; ?>" disabled />
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
                <input type="text" value="<?php echo date("d/m/Y - H:i", strtotime($query->PEDIDO_DATA)); ?>" disabled />
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
    <input type="text" name="DESREC_DESCR" value="<?php echo set_value('DESREC_DESCR', $query->DESREC_DESCR); ?>" disabled />
    
    <label>LOG DE ALTERAÇÕES</label>
    <div class="row">
        <div class="col-sm-12 rodape-finance">
            <table>
                <?php foreach ($historicos as $historico) { ?>
                    <tr>
                        <td width="33%"><?php echo $historico->USUARIO_LOGIN; ?></td>
                        <td width="33%"><?php echo $historico->HISTORICO_CMD; ?></td>
                        <td width="33%"><?php echo date("d/m/Y H:i:s", strtotime($historico->HISTORICO_DATA)) ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
    </div>

</fieldset>
