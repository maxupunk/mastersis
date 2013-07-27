<?php
$id_medida = $this->uri->segment(3);

if (isset($mensagem)):
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();

elseif ($id_medida == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div?>';
    exit();
endif;

$query = $this->crud_model->pega("MEDIDAS", array('MEDI_ID' => $id_medida))->row();

if ($query == NULL):
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>

<form action="medida/excluir/<?php echo $id_medida; ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EXCLUIR A UNIDADE ABAIXO?</legend>


        <label>CODIGO: <?php echo $query->MEDI_ID ?></label>

        <label>Medida:</label>
        <input type="text" name="MEDI_NOME" value="<?php echo set_value('MEDI_NOME', $query->MEDI_NOME); ?>" readonly class="span4" />

        <label>Sigla:</label>
        <input type="text" name="MEDI_SIGLA" value="<?php echo set_value('MEDI_SIGLA', $query->MEDI_SIGLA); ?>" readonly class="span1" />
        
        <input type="hidden" name="id_medida" value="<?php echo $query->MEDI_ID ?>" />

        <hr><button type="submit" class="btn">SIM, EXCLUIR</button>

    </fieldset>

</form>