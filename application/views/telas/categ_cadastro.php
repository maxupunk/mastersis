<form action="<?php echo base_url('categoria'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE CATEGORIA</legend>
        
        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>Categoria:</label>
        <?php echo form_error('CATE_NOME'); ?>
        <input type="text" name="CATE_NOME" value="<?php echo set_value('CATE_NOME'); ?>" maxlength="45" class="span6" />

        <label>Descrição:</label>
        <?php echo form_error('CATE_DESCRIC'); ?>
        <textarea name="CATE_DESCRIC" rows="10" class="span6"><?php echo set_value('CATE_DESCRIC'); ?></textarea>                    

        <hr><button type="submit" class="btn">CADASTRAR</button>

    </fieldset>

</form>