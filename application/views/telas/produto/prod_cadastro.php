<form action="<?php echo base_url('produto'); ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <?php
        if (isset($mensagem) and $mensagem != NULL)
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
        ?>

        <label>Descrição:</label>
        <?php echo form_error('PRO_DESCRICAO'); ?>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" maxlength="100" autofocus />

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('PRO_CARAC_TEC'); ?>
        <textarea name="PRO_CARAC_TEC" rows="10"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>                    

        <div class="row">
            <div class="col-sm-3">
                <label>Peso(Kg):</label>
                <?php echo form_error('PRO_PESO'); ?>
                <input type="text" name="PRO_PESO" value="<?php echo set_value('PRO_PESO'); ?>" class="peso" />
            </div>
            <div class="col-sm-5">
                <label>Categoria:</label>
                <?php
                echo form_error('CATE_ID');
                if ($categorias != NULL) {
                    foreach ($categorias as $categoria)
                        $options[$categoria->CATE_ID] = $categoria->CATE_NOME;
                } else {
                    $options[''] = 'Cadastre uma categoria';
                }
                echo form_dropdown('CATE_ID', $options, $this->input->post('CATE_ID'));
                unset($options);
                ?>
            </div>
            <div class="col-sm-4">
                <label>Unidade de medida:</label>
                <?php
                echo form_error('MEDI_ID');
                if ($medidas != NULL) {
                    foreach ($medidas as $medida)
                        $options[$medida->MEDI_ID] = $medida->MEDI_NOME;
                } else {
                    $options[''] = 'Cadastre uma unidade de medida';
                }
                echo form_dropdown('MEDI_ID', $options, $this->input->post('MEDI_ID'));
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Estatus:</label>
                <?php echo form_dropdown('PRO_ESTATUS', array('a' => 'Ativo', 'd' => 'Desativo'), $this->input->post('PRO_ESTATUS')); ?>
            </div>
            <div class="col-sm-6">
                <label>Tipo (Produto/Serviço):</label>
                <?php echo form_dropdown('PRO_TIPO', array('p' => 'Produto', 's' => 'Serviço'), $this->input->post('PRO_TIPO')); ?>
            </div>
        </div>

        <hr>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>

    </fieldset>

</form>