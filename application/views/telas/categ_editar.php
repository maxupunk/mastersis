<?php
$id_categoria = $this->uri->segment(3);

if ($id_categoria == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->crud_model->pega("CATEGORIA", array('CATE_ID' => $id_categoria))->row();

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form method="post" action="<?php echo base_url('categoria'); ?>/editar/<?php echo $id_categoria; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE CATEGORIA</legend>


        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>


        <label>Descrição do produto:</label>
        <?php echo form_error('CATE_NOME'); ?>
        <input type="text" name="CATE_NOME" value="<?php echo set_value('CATE_NOME', $query->CATE_NOME); ?>" class="span6" />

        <label>Caracteristica Tecnicas:</label>
        <?php echo form_error('CATE_DESCRIC'); ?>
        <textarea name="CATE_DESCRIC" rows="10" class="span6"><?php echo set_value('CATE_DESCRIC', $query->CATE_DESCRIC); ?></textarea>


        <label class="radio">
            <input type="radio" name="CATE_ESTATUS" value="a" <?php if ($query->CATE_ESTATUS == "a") echo 'checked="checked"'; ?> />Ativo
        </label>

        <label class="radio">
            <input type="radio" name="CATE_ESTATUS" value="d" <?php if ($query->CATE_ESTATUS == "d") echo 'checked="checked"'; ?> />Desativo
        </label>

        </div>

        <input type="hidden" value="<?php echo $id_categoria; ?>" name="id_categoria" />

        <hr><button type="submit" class="btn" disabled>SALVA ALTERAÇOES</button>

    </fieldset>
</form>
