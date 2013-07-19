<?php
$id_categoria = $this->uri->segment(3);

if ($id_categoria == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->categoria_model->pega_id($id_categoria)->row();

echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

if ($this->session->flashdata('edit_cate_ok')):
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('edit_cate_ok') . '</div>';
endif;

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form method="get" action="<?php echo base_url('categoria'); ?>/editar/<?php echo $id_categoria; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE CATEGORIA</legend>


        <label>Descrição do produto:</label>
        <input type="text" name="CATE_NOME" value="<?php echo set_value('CATE_NOME', $query->CATE_NOME); ?>" class="span6" readonly/>

        <label>Caracteristica Tecnicas::</label>
        <textarea name="CATE_DESCRIC" rows="10" class="span6"><?php echo set_value('CATE_DESCRIC', $query->CATE_DESCRIC); ?></textarea>


                <label class="radio">
                    <input type="radio" name="CATE_ESTATUS" value="a" <?php if ($query->CATE_ESTATUS == "a") echo 'checked="checked"'; ?> />Ativo
                </label>

                <label class="radio">
                    <input type="radio" name="CATE_ESTATUS" value="d" <?php if ($query->CATE_ESTATUS == "d") echo 'checked="checked"'; ?> />Desativo
                </label>

        </div>

        <input type="hidden" value="<?php echo $id_categoria; ?>" name="id_categoria" />

        <hr><button type="submit" class="btn">ATUALIZAR</button>

    </fieldset>
</form>