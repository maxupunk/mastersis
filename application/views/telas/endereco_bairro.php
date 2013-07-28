<form action="<?php echo base_url('endereco'); ?>/bairro" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>CADASTRO DE BAIRRO</legend>

        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <?php
        $options = array('' => 'Escolha o Estado');
        foreach ($estados as $estado)
            $options[$estado->ESTA_ID] = $estado->ESTA_NOME;
        echo form_dropdown('ESTA_ID', $options, '', 'autofocus');
        ?>


        <?php echo form_dropdown('CIDA_ID', array('' => 'Escolha a cidade')); ?>

        <label>Nome:</label>
        <?php echo form_error('BAIRRO_NOME'); ?>
        <input type="text" name="BAIRRO_NOME" value="<?php echo set_value('BAIRRO_NOME'); ?>" maxlength="45" />

        <hr><button type="submit" class="btn" disabled>CADASTRAR</button>

    </fieldset>

</form>