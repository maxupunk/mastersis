<form action="<?php echo base_url('categoria'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE CATEGORIA</legend>

        <?php
        echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        if ($this->session->flashdata('cad_cate_ok')):
            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('cad_cate_ok') . '</div>';
        endif;
        ?>

        <label>Categoria:</label>
        <input type="text" name="CATE_NOME" value="<?php echo set_value('CATE_NOME'); ?>" maxlength="45" class="span6" />

        <label>Descrição:</label>
        <textarea name="CATE_DESCRIC" rows="10" class="span6"><?php echo set_value('CATE_DESCRIC'); ?></textarea>                    

        <hr><button type="submit" class="btn">CADASTRAR</button>

    </fieldset>

</form>