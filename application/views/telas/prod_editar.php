<?php

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>
<form method="POST" action="<?php echo base_url('produto'); ?>/editar/<?php echo $query->PRO_ID; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE PRODUTO</legend>

        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>Descrição do produto:</label>
        <?php echo form_error('PRO_DESCRICAO'); ?>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO', $query->PRO_DESCRICAO); ?>"/>

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('PRO_CARAC_TEC'); ?>
        <textarea name="PRO_CARAC_TEC" rows="10"><?php echo set_value('PRO_CARAC_TEC', $query->PRO_CARAC_TEC); ?></textarea>

        <label>Peso (Kg):</label>
        <?php echo form_error('PRO_PESO'); ?>
        <input type="text" name="PRO_PESO" value="<?php echo set_value('PRO_PESO', $query->PRO_PESO); ?>" class="peso" />

        
        <?php echo form_dropdown('PRO_ESTATUS', array('a' => 'Ativo', 'd' => 'Desativo'), set_value('PRO_ESTATUS', $query->PRO_ESTATUS)); ?>

        <input type="hidden" value="<?php echo $query->PRO_ID; ?>" name="id_produto" />

        <hr><button type="submit" class="btn btn-default">ATUALIZAR</button>

    </fieldset>
</form>
