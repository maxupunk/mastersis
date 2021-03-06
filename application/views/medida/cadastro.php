<form action="<?php echo base_url('medida'); ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>Medida:</label>
        <?php echo form_error('MEDI_NOME'); ?>
        <input type="text" name="MEDI_NOME" value="<?php echo set_value('MEDI_NOME'); ?>" maxlength="45" autofocus />

        <label>Sigla:</label>
        <?php echo form_error('MEDI_SIGLA'); ?>
        <input type="text" name="MEDI_SIGLA" value="<?php echo set_value('MEDI_SIGLA'); ?>" maxlength="4" />

        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <input type="reset" class="btn btn-warning" value="Limpar"/>

    </fieldset>

</form>