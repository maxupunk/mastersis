<form action="<?php echo base_url('servico'); ?>" method="post" name="grava" accept-charset="utf-8">
    <fieldset>

        <legend>CADASTRO DE SERVIÇO</legend>

        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
        
        <label>Nome:</label>
        <?php echo form_error('SERV_NOME'); ?>
        <input type="text" name="SERV_NOME" value="<?php echo set_value('SERV_NOME'); ?>" maxlength="45" autofocus />

        <label>Descrição:</label>
        <?php echo form_error('SERV_DESC'); ?>
        <textarea name="SERV_DESC" rows="10"><?php echo set_value('SERV_DESC'); ?></textarea>                    

        <label>Valor:</label>
        <?php echo form_error('SERV_VALOR'); ?>
        <input type="text" name="SERV_VALOR" value="<?php echo set_value('SERV_VALOR'); ?>" class="valor" />

        
        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" disabled>Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>
</form>