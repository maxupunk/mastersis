<form action="<?php echo base_url('usuario'); ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <?php
        if (isset($mensagem) and $mensagem != NULL)
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
        ?>

        <label>NOME DA CLIENTE/FORNECEDOR</label>  | <span id="pessoa-selec"></span>
        <?php echo form_error('PES_ID'); ?>
        <input type="text" name="PES_NOME" autocomplete="off" id="pessoa" value="<?php echo set_value('PES_NOME'); ?>"/>

        <div class="row">
            <div class="col-sm-4">
                <label>NATUREZA</label>
                <select name="DESREC_NATUREZA">
                    <option value="1">Receita</option>
                    <option value="2">Despeza</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label>VALOR</label>
                <?php echo form_error('DESREC_VALOR'); ?>
                <input type="text" name="DESREC_VALOR" value="<?php echo set_value('DESREC_VALOR'); ?>" class="valor" />                
            </div>
            <div class="col-sm-4">
                <label>VENCIMENTO</label>
                <input type="date" name="PES_NASC_DATA" value="<?php echo set_value('PES_NASC_DATA'); ?>"/>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <label>ADICIONA EM</label>
                <select name="adiciona">
                    <option value="1">Avulso</option>
                    <option value="2">Ordem</option>
                    <option value="3">Comp/Vend</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label>ID</label>
                <?php echo form_error('PED_OS_ID'); ?>
                <input type="text" name="PED_OS_ID" value="<?php echo set_value('PED_OS_ID'); ?>" />
            </div>
            <div class="col-sm-3">
                <label>ESTATUS</label>
                <select name="DESCRE_ESTATUS">
                    <option value="ab">Aberto</option>
                    <option value="pg">pago</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label>DATA PG</label>
                <input type="date" name="DESCRE_DATA_PG" value="<?php echo set_value('DESCRE_DATA_PG'); ?>"/>
            </div>
        </div>

        <label>DESCRIÇÃO/OBS</label>
        <?php echo form_error('DESREC_DESCR'); ?>
        <input type="text" name="DESREC_DESCR" value="<?php echo set_value('DESREC_DESCR'); ?>" />


        <input type="hidden" name="PES_ID" id="PES_ID" value="<?php echo set_value('PES_ID'); ?>"/>

        <div class="botoes">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>

</form>
<script src="<?php echo base_url('assets/js/pessoa.js'); ?>"></script>