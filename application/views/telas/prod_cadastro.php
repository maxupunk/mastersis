<form action="<?php echo base_url('produto'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE PRODUTO</legend>

        <?php
        echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        if ($this->session->flashdata('cad_prod_ok')):
            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('cad_prod_ok') . '</div>';
        endif;
        ?>

        <label>Descrição do produto:</label>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" maxlength="100" class="span6" />

        <label>Caracteristica Tecnicas:</label>
        <textarea name="PRO_CARAC_TEC" rows="10" class="span6"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>                    

        <hr><button type="submit" class="btn">CADASTRAR</button>

    </fieldset>

</form>