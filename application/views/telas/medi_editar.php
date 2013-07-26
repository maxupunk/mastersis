<?php
$id_medida = $this->uri->segment(3);

if ($id_medida == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->crud_model->pega("MEDIDAS", array('MEDI_ID' => $id_medida))->row();

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form method="post" action="<?php echo base_url('medida'); ?>/editar/<?php echo $id_medida; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE MEDIDA</legend>


        <?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>


        <label>Medida:</label>
        <?php echo form_error('MEDI_NOME'); ?>
        <input type="text" name="MEDI_NOME" value="<?php echo set_value('MEDI_NOME', $query->MEDI_NOME); ?>" class="span4" />

        <label>Sigla:</label>
        <?php echo form_error('MEDI_SIGLA'); ?>
        <input type="text" name="MEDI_SIGLA" value="<?php echo set_value('MEDI_SIGLA', $query->MEDI_SIGLA); ?>" class="span1" />

        
        <input type="hidden" value="<?php echo $id_medida; ?>" name="id_medida" />

        <hr><button type="submit" class="btn" disabled>SALVA ALTERAÇOES</button>

    </fieldset>
</form>
