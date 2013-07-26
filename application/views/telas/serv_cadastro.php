<form action="<?php echo base_url('servico'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">
    <fieldset>

        <legend>CADASTRO DE SERVIÇO</legend>

        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
        
        <label>Nome:</label>
        <?php echo form_error('SERV_NOME'); ?>
        <input type="text" name="SERV_NOME" value="<?php echo set_value('SERV_NOME'); ?>" maxlength="45" class="span6" />

        <label>Descrição:</label>
        <?php echo form_error('SERV_DESC'); ?>
        <textarea name="SERV_DESC" rows="10" class="span6"><?php echo set_value('SERV_DESC'); ?></textarea>                    

        <label>Valor:</label>
        <?php echo form_error('SERV_VALOR'); ?>
        <input type="text" name="SERV_VALOR" value="<?php echo set_value('SERV_VALOR'); ?>" class="valor" />

        
        <hr><button type="submit" class="btn">CADASTRAR</button>

    </fieldset>
</form>
<script src="<?php echo base_url('application/views/js/mascaras.js'); ?>"></script>
