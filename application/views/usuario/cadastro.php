<form action="<?php echo base_url('usuario'); ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <?php
        if (isset($mensagem) and $mensagem != NULL)
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
        ?>


        <label>NOME DA PESSOA</label>  | <span id="pessoa-selec"></span>
        <?php echo form_error('PES_ID'); ?>
        <input type="text" name="PES_NOME" autocomplete="off" id="pessoa" value="<?php echo set_value('PES_NOME'); ?>"/>

        <label>APELIDO (como é conhecido)</label>
        <?php echo form_error('USUARIO_APELIDO'); ?>
        <input type="text" name="USUARIO_APELIDO" value="<?php echo set_value('USUARIO_APELIDO'); ?>" maxlength="45" />

        <label>LOGIN</label>
        <?php echo form_error('USUARIO_LOGIN'); ?>
        <input type="text" name="USUARIO_LOGIN" value="<?php echo set_value('USUARIO_LOGIN'); ?>" maxlength="45" />

        <div class="row">
            <div class="col-lg-6">
                <label>SENHA</label>
                <?php echo form_error('USUARIO_SENHA'); ?>
                <input type="password" name="USUARIO_SENHA" value="<?php echo set_value('USUARIO_SENHA'); ?>" maxlength="45" />
            </div>
            <div class="col-lg-6">
                <label>REPITA A SENHA</label>
                <?php echo form_error('USUARIO_SENHA_RE'); ?>
                <input type="password" name="USUARIO_SENHA_RE" value="<?php echo set_value('USUARIO_SENHA_RE'); ?>" maxlength="45" />
            </div>
        </div>


        <label>CARGO:</label>
        <?php
        echo form_error('CARG_ID');
        if ($cargos != NULL) {
            foreach ($cargos as $cargo)
                $options[$cargo->CARG_ID] = $cargo->CARG_NOME;
        } else {
            $options[''] = 'Cadastre um cargo';
        }
        echo form_dropdown('CARG_ID', $options, $this->input->post('CARG_ID'));
        ?>

        <input type="hidden" name="PES_ID" id="PES_ID" value="<?php echo set_value('PES_ID'); ?>"/>


        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>

</form>
<script src="<?php echo base_url('assets/js/pessoa.js'); ?>"></script>