<div class="well">
<form action="<?php echo base_url('ordemservico'); ?>/cadastrar" method="post" accept-charset="utf-8">

    <fieldset>

        <legend>Nova Ordem de Serviço<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></legend>

        <?php
        if (isset($mensagem) and $mensagem != NULL)
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
        ?>

        
        <label>NOME DA PESSOA</label>
        <?php echo form_error('PES_ID'); ?>
        <input type="text" name="PES_NOME" autocomplete="off" id="pessoa" value="<?php echo set_value('PES_NOME'); ?>" />

        <label>DESCRIÇÃO EQUIPAMENTO</label>
        <?php echo form_error('OS_EQUIPAMENT'); ?>
        <textarea name="OS_EQUIPAMENT" rows="3"><?php echo set_value('OS_EQUIPAMENT'); ?></textarea>
        
        <label>DEFEITO</label>
        <?php echo form_error('OS_DSC_DEFEITO'); ?>
        <textarea name="OS_DSC_DEFEITO" rows="3"><?php echo set_value('OS_DSC_DEFEITO'); ?></textarea>

        <label>OBSERVAÇÃO</label>
        <?php echo form_error('OS_OBSERVACAO'); ?>
        <textarea name="OS_OBSERVACAO" rows="3"><?php echo set_value('OS_OBSERVACAO'); ?></textarea>


        <input type="hidden" name="PES_ID" id="PES_ID" value="<?php echo set_value('PES_ID'); ?>"/>
        
        <hr>

        <button type="submit" class="btn btn-primary">Salvar</button>

    </fieldset>

</form>
</div>