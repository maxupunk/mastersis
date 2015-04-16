<form action="<?php echo base_url('ordemservico'); ?>/cadastrar" id="SubmitAjax" method="post" accept-charset="utf-8">

    <fieldset>

        <?php
        if (isset($mensagem) and $mensagem != NULL) {
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
            exit();
        }
        ?>

        <label>NOME DA PESSOA</label> | <span id="pessoa-selec"><?php echo set_value('PES_ID'); ?> - <?php echo set_value('PES_NOME'); ?></span>
        <?php echo form_error('PES_ID'); ?>
        <input type="text" name="PES_NOME" autocomplete="off" id="pessoa" value="<?php echo set_value('PES_NOME'); ?>" required />

        <label>DESCRIÇÃO EQUIPAMENTO</label>
        <?php echo form_error('OS_EQUIPAMENT'); ?>
        <textarea name="OS_EQUIPAMENT" rows="3" required /><?php echo set_value('OS_EQUIPAMENT'); ?></textarea>

        <label>DEFEITO</label>
        <?php echo form_error('OS_DSC_DEFEITO'); ?>
        <textarea name="OS_DSC_DEFEITO" rows="3" required /><?php echo set_value('OS_DSC_DEFEITO'); ?></textarea>

        <label>OBSERVAÇÃO</label>
        <?php echo form_error('OS_OBSERVACAO'); ?>
        <textarea name="OS_OBSERVACAO" rows="3"><?php echo set_value('OS_OBSERVACAO'); ?></textarea>


        <input type="hidden" name="PES_ID" id="PES_ID" value="<?php echo set_value('PES_ID'); ?>"/>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary Model-Submit">Salvar</button>
        </div>

    </fieldset>

</form>
<script src="<?php echo base_url('assets/js/pessoa.js'); ?>"></script>