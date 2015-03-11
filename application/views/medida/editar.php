<?php
if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form method="post" action="<?php echo base_url('medida'); ?>/editar/<?php echo $query->MEDI_ID; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE MEDIDA</legend>


        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>


        <label>Medida:</label>
        <?php echo form_error('MEDI_NOME'); ?>
        <input type="text" name="MEDI_NOME" value="<?php echo set_value('MEDI_NOME', $query->MEDI_NOME); ?>" />

        <label>Sigla:</label>
        <?php echo form_error('MEDI_SIGLA'); ?>
        <input type="text" name="MEDI_SIGLA" value="<?php echo set_value('MEDI_SIGLA', $query->MEDI_SIGLA); ?>" />

        
        <input type="hidden" value="<?php echo $query->MEDI_ID; ?>" name="id_medida" />

        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>
</form>
