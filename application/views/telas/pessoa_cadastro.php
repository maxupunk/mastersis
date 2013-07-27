<form action="<?php echo base_url('pessoa'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">
    <fieldset>

        <legend>CADASTRO DE PESSOAS</legend>

        <?php
        if (isset($mensagem)) {
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
            exit();
        }
        ?>

        <?php echo form_dropdown('PES_TIPO', array('f' => 'FISICA', 'j' => 'JURIDICA'), '', 'id="pessoa_tipo" class="span3"'); ?>

        <label>Nome:</label>
        <?php echo form_error('PES_NOME'); ?>
        <input type="text" name="PES_NOME" value="<?php echo set_value('PES_NOME'); ?>" class="span6" />

        <label>C.P.F/CNPJ *:</label>
        <?php echo form_error('PES_CPF_CNPJ'); ?>
        <input type="text" name="PES_CPF_CNPJ" value="<?php echo set_value('PES_CPF_CNPJ'); ?>" class="cpf" />

        <label>Nome do pai:</label>
        <?php echo form_error('PES_NOME_PAI'); ?>
        <input type="text" name="PES_NOME_PAI" value="<?php echo set_value('PES_NOME_PAI'); ?>" class="span6" />

        <label>Nome da mãe:</label>
        <?php echo form_error('PES_NOME_MAE'); ?>
        <input type="text" name="PES_NOME_MAE" value="<?php echo set_value('PES_NOME_MAE'); ?>" class="span6" />

        <label>Data de nascimento *:</label>
        <?php echo form_error('PES_NASC_DATA'); ?>
        <input type="text" name="PES_NASC_DATA" value="<?php echo set_value('PES_NASC_DATA'); ?>" class="data" />

        <label>Telefone:</label>
        <?php echo form_error('PES_FONE'); ?>
        <input type="text" name="PES_FONE" value="<?php echo set_value('PES_FONE'); ?>" class="fone" />

        <label>Celular 1 *:</label>
        <?php echo form_error('PES_CEL1'); ?>
        <input type="text" name="PES_CEL1" value="<?php echo set_value('PES_CEL1'); ?>" class="fone" />

        <label>Celular 2:</label>
        <?php echo form_error('PES_VEL2'); ?>
        <input type="text" name="PES_CEL2" value="<?php echo set_value('PES_CEL2'); ?>" class="fone" />

        <?php echo form_error('RUA_ID'); ?>
        <?php
        $options = array('' => 'Selecione o Estado');
        foreach ($estados as $estado)
            $options[$estado->ESTA_ID] = $estado->ESTA_NOME;
        echo form_dropdown('ESTA_ID', $options, '', 'id="estado" class="span6"');
        ?>

        <?php echo form_dropdown('CIDA_ID', array('' => 'Selecione a cidade'), '', 'id="cidade" class="span6"'); ?>

        <?php echo form_dropdown('BAIRRO_ID', array('' => 'Selecione o bairro'), '', 'id="bairro" class="span6"'); ?>

        <?php echo form_dropdown('RUA_ID', array('' => 'Selecione a rua'), '', 'id="rua" class="span6"'); ?>

        <label>Numero:</label>
        <?php echo form_error('END_NUMERO'); ?>
        <input type="text" name="END_NUMERO" value="<?php echo set_value('END_NUMERO'); ?>" class="span1" />

        <label>Referencia:</label>
        <?php echo form_error('END_REFERENCIA'); ?>
        <input type="text" name="END_REFERENCIA" value="<?php echo set_value('END_REFERENCIA'); ?>" class="span6" />

        <input type="hidden" name="PES_DATE" />



        <hr><button type="submit" class="btn">CADASTRAR</button>

    </fieldset>
</form>
<script src="<?php echo base_url('application/views/js/mascaras.js'); ?>"></script>