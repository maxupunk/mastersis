<form action="<?php echo base_url('produto'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE PRODUTO</legend>

        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
        
        <label>Descrição:</label>
        <?php echo form_error('PRO_DESCRICAO'); ?>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" maxlength="100" class="span6" />

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('PRO_CARAC_TEC'); ?>
        <textarea name="PRO_CARAC_TEC" rows="10" class="span6"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>                    

        <hr><button type="submit" class="btn">CADASTRAR</button>

    </fieldset>

</form>