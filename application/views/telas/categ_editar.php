<?php
if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form method="post" action="<?php echo base_url('categoria'); ?>/editar/<?php echo $query->CATE_ID; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE CATEGORIA</legend>


        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>


        <label>Descrição do produto:</label>
        <?php echo form_error('CATE_NOME'); ?>
        <input type="text" name="CATE_NOME" value="<?php echo set_value('CATE_NOME', $query->CATE_NOME); ?>" />

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('CATE_DESCRIC'); ?>
        <textarea name="CATE_DESCRIC" rows="10"><?php echo set_value('CATE_DESCRIC', $query->CATE_DESCRIC); ?></textarea>

        <?php echo form_dropdown('CATE_ESTATUS', array('a' => 'Ativo', 'd' => 'Desativo'), set_value('CATE_ESTATUS', $query->CATE_ESTATUS)); ?>

        </div>

        <input type="hidden" value="<?php echo $query->CATE_ID; ?>" name="id_categoria" />

        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" disabled>Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>
</form>
