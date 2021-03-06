<form action="<?php echo base_url('financeiro'); ?>/novo" method="post" id="SubmitAjax" accept-charset="utf-8">

    <?php
    echo validation_errors();
    if (isset($mensagem) and $mensagem != NULL) {
        echo $mensagem;
        exit();
    }
    ?>
    <fieldset>

        <label>NOME DA CLIENTE/FORNECEDOR</label>  | <span id="pessoa-selec"><?php echo set_value('PES_ID'); ?> - <?php echo set_value('PES_NOME'); ?></span>
        <input type="text" name="PES_NOME" autocomplete="off" id="pessoa" value="<?php echo set_value('PES_NOME'); ?>"/>

        <div class="row">
            <div class="col-sm-4">
                <label>NATUREZA</label>
                <select name="DESREC_NATUREZA">
                    <option value="1" <?php echo set_select('DESREC_NATUREZA', '1', TRUE); ?>>Receita</option>
                    <option value="2" <?php echo set_select('DESREC_NATUREZA', '2'); ?>>Despeza</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label>VALOR</label>
                <input type="text" name="DESREC_VALOR" value="<?php echo set_value('DESREC_VALOR'); ?>" class="valor" />                
            </div>
            <div class="col-sm-4">
                <label>VENCIMENTO</label>
                <input type="text" class="data" name="DESREC_VECIMENTO" value="<?php echo set_value('DESREC_VECIMENTO'); ?>" />
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <label>ADICIONA EM</label>
                <select name="ADICIONA" id="ADICIONA">
                    <option value="1" <?php echo set_select('ADICIONA', '1', TRUE); ?> >Avulso</option>
                    <option value="2" <?php echo set_select('ADICIONA', '2'); ?> >Ordem</option>
                    <option value="3" <?php echo set_select('ADICIONA', '3'); ?> >Comp/Vend</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label class="PedOsId">ID</label>
                <input type="text" name="PED_OS_ID" id="PED_OS_ID" value="<?php echo set_value('PED_OS_ID'); ?>"/>
            </div>
            <div class="col-sm-3">
                <label>ESTATUS</label>
                <select name="DESCRE_ESTATUS" id="DESCRE_ESTATUS">
                    <option value="ab" <?php echo set_select('DESCRE_ESTATUS', 'ab', TRUE); ?>>Aberto</option>
                    <option value="pg" <?php echo set_select('DESCRE_ESTATUS', 'pg'); ?>>pago</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label>PAGO EM</label>
                <input type="text" class="data" id="DESCRE_DATA_PG" name="DESCRE_DATA_PG" value="<?php echo set_value('DESCRE_DATA_PG'); ?>" disabled/>
            </div>
        </div>

        <label>DESCRIÇÃO</label>
        <input type="text" name="DESREC_DESCR" value="<?php echo set_value('DESREC_DESCR'); ?>" />


        <input type="hidden" name="PES_ID" id="PES_ID" value="<?php echo set_value('PES_ID'); ?>"/>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>

</form>
<script src="<?php echo base_url('assets/js/pessoa.js'); ?>"></script>