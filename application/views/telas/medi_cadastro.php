<form action="<?php echo base_url('medida'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE MEDIDA</legend>
        
        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>Medida:</label>
        <?php echo form_error('MEDI_NOME'); ?>
        <input type="text" name="MEDI_NOME" value="<?php echo set_value('MEDI_NOME'); ?>" maxlength="45" class="span4" />

        <label>Sigla:</label>
        <?php echo form_error('MEDI_SIGLA'); ?>
        <input type="text" name="MEDI_SIGLA" value="<?php echo set_value('MEDI_SIGLA'); ?>" maxlength="4" class="span1" />

        <hr><button type="submit" class="btn" disabled>CADASTRAR</button>

    </fieldset>

</form>