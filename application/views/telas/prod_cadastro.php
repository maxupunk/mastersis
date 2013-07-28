<form action="<?php echo base_url('produto'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE PRODUTO</legend>

        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>Descrição:</label>
        <?php echo form_error('PRO_DESCRICAO'); ?>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" maxlength="100" autofocus />

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('PRO_CARAC_TEC'); ?>
        <textarea name="PRO_CARAC_TEC" rows="10"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>                    

        <?php
        echo form_error('CATE_ID');
        if ($categorias != NULL){
        foreach ($categorias as $categoria)
            $options[$categoria->CATE_ID] = $categoria->CATE_NOME;
        }else{ $options[''] = 'Cadastre uma categoria antes de continuar'; }
        echo form_dropdown('CATE_ID', $options, $this->input->post('CATE_ID'));
        ?>

        <?php
        echo form_error('MEDI_ID');
        if ($medidas != NULL){
        foreach ($medidas as $medida)
            $options[$medida->MEDI_ID] = $medida->MEDI_NOME;
        }else{ $options[''] = 'Cadastre uma unidade de medida antes de continuar'; }
        echo form_dropdown('MEDI_ID', $options, $this->input->post('MEDI_ID'));
        ?>
        </select>

        <hr><button type="submit" class="btn" disabled>CADASTRAR</button>

    </fieldset>

</form>