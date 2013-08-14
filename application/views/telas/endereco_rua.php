<script src="<?php echo base_url('assets/js/mascaras.js'); ?>"></script>
<form action="<?php echo base_url('endereco'); ?>/rua" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE RUA</legend>

        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <?php
        $options = array('' => 'Escolha o Estado');
        foreach ($estados as $estado)
            $options[$estado->ESTA_ID] = $estado->ESTA_NOME;
        echo form_dropdown('ESTA_ID', $options, '' ,'autofocus');
        ?>

        <?php echo form_dropdown('CIDA_ID', array('' => 'Escolha a cidade')); ?>

        <?php echo form_dropdown('BAIRRO_ID', array('' => 'Escolha o bairro')); ?>

        </div>
        <label>Nome:</label>
        <?php echo form_error('RUA_NOME'); ?>
        <input type="text" name="RUA_NOME" value="<?php echo set_value('RUA_NOME'); ?>" maxlength="45" />

        <label>Cep:</label>
        <?php echo form_error('RUA_CEP'); ?>
        <input type="text" name="RUA_CEP" value="<?php echo set_value('RUA_CEP'); ?>" maxlength="45" class="cep" />

        <hr><button type="submit" class="btn" disabled>CADASTRAR</button>

    </fieldset>

</form>