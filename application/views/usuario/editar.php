<?php
$id_usuario = $this->uri->segment(3);

if ($id_usuario == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

if ($usuario == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form action="<?php echo base_url('usuario'); ?>/editar/<?php echo $usuario->USUARIO_ID; ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDITAR DE USUARIO</legend>

        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>LOGIN</label>
        <input type="text" name="USUARIO_LOGIN" value="<?php echo set_value('USUARIO_LOGIN', $usuario->USUARIO_LOGIN); ?>" maxlength="45" />

        <label>APELIDO (como é conhecido)</label>
        <input type="text" name="USUARIO_APELIDO" value="<?php echo set_value('USUARIO_APELIDO', $usuario->USUARIO_APELIDO); ?>" maxlength="45" />


        <label>CARGO:</label>
        <?php
        echo form_error('CARG_ID');
        if ($cargos != NULL) {
            foreach ($cargos as $cargo)
                $options[$cargo->CARG_ID] = $cargo->CARG_NOME;
        } else {
            $options[''] = 'Cadastre um cargo';
        }
        echo form_dropdown('CARG_ID', $options, $cargo->CARG_NOME);
        ?>

        <label>ESTATUS:</label>
        <?php echo form_dropdown('USUARIO_ESTATUS', array('a' => 'Ativo', 'd' => 'Desativo'), set_value('PRO_ESTATUS', $usuario->USUARIO_ESTATUS)); ?>
        
        <input type="hidden" name="usuario_id" value="<?php echo $usuario->USUARIO_ID; ?>"/>


        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>

    </fieldset>

</form>
