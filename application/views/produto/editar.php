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

        <label>Codigo Barra:</label>
        <?php echo form_error('PRO_CODBARRA'); ?>
        <input type="text" name="PRO_CODBARRA" value="<?php echo set_value('PRO_CODBARRA', $query->PRO_CODBARRA); ?>" maxlength="45" autofocus />
        
        <label>Descrição do produto:</label>
        <?php echo form_error('PRO_DESCRICAO'); ?>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO', $query->PRO_DESCRICAO); ?>"/>

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('PRO_CARAC_TEC'); ?>
        <textarea name="PRO_CARAC_TEC" rows="10"><?php echo set_value('PRO_CARAC_TEC', $query->PRO_CARAC_TEC); ?></textarea>


        <div class="row">
            <div class="col-sm-3">

                <label>Peso (Kg):</label>
                <?php echo form_error('PRO_PESO'); ?>
                <input type="text" name="PRO_PESO" value="<?php echo set_value('PRO_PESO', $query->PRO_PESO); ?>" class="peso" />
            </div>
            <div class="col-sm-5">
                <label>Categoria:</label>
                <?php
                echo form_error('CATE_ID');
                if ($categorias != NULL) {
                    foreach ($categorias as $categoria)
                        $options[$categoria->CATE_ID] = $categoria->CATE_NOME;
                } else {
                    $options[''] = 'Cadastre uma categoria antes de continuar';
                }
                echo form_dropdown('CATE_ID', $options, set_value('CATE_ID', $query->CATE_ID));
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
                    $options[''] = 'Cadastre uma unidade de medida antes de continuar';
                }
                echo form_dropdown('MEDI_ID', $options, set_value('MEDI_ID', $query->MEDI_ID));
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Estatus:</label>
                <?php echo form_dropdown('PRO_ESTATUS', array('a' => 'Ativo', 'd' => 'Desativo'), set_value('PRO_ESTATUS', $query->PRO_ESTATUS)); ?>
            </div>
            <div class="col-sm-6">
                <label>Tipo(Produto/Serviço):</label>
                <?php echo form_dropdown('PRO_TIPO', array('p' => 'Produto', 's' => 'Serviço'), set_value('PRO_TIPO', $query->PRO_TIPO)); ?>
            </div>
        </div>

        <input type="hidden" value="<?php echo $query->PRO_ID; ?>" name="id_produto" />

        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>
</form>
