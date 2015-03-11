<form action="<?php echo base_url('categoria'); ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>Categoria:</label>
        <?php echo form_error('CATE_NOME'); ?>
        <input type="text" name="CATE_NOME" value="<?php echo set_value('CATE_NOME'); ?>" maxlength="45" autofocus />

        <label>Descrição:</label>
        <?php echo form_error('CATE_DESCRIC'); ?>
        <textarea name="CATE_DESCRIC" rows="10"><?php echo set_value('CATE_DESCRIC'); ?></textarea>                    

        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <input type="reset" class="btn btn-warning" value="Limpar"/>

    </fieldset>

</form>