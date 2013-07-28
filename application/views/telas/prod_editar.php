<?php
$id_produto = $this->uri->segment(3);

if ($id_produto == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row();

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>

<form method="POST" action="<?php echo base_url('produto'); ?>/editar/<?php echo $id_produto; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE PRODUTO</legend>

        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

        <label>Descrição do produto:</label>
        <?php echo form_error('PRO_DESCRICAO'); ?>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO', $query->PRO_DESCRICAO); ?>"/>

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('PRO_CARAC_TEC'); ?>
        <textarea name="PRO_CARAC_TEC" rows="10"><?php echo set_value('PRO_CARAC_TEC', $query->PRO_CARAC_TEC); ?></textarea>

        <label class="radio">
            <input type="radio" name="PRO_ESTATUS" value="a" <?php if ($query->PRO_ESTATUS == "a") echo 'checked="checked"'; ?> />Ativo
        </label>

        <label class="radio">
            <input type="radio" name="PRO_ESTATUS" value="d" <?php if ($query->PRO_ESTATUS == "d") echo 'checked="checked"'; ?> />Desativo
        </label>

        </div>

        <input type="hidden" value="<?php echo $id_produto; ?>" name="id_produto" />

        <hr><button type="submit" class="btn" disabled>ATUALIZAR</button>

    </fieldset>
</form>