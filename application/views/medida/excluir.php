<?php

if (isset($mensagem) and $mensagem != NULL) {
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();
}

if ($query == NULL):
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>

<form action="medida/excluir/<?php echo $query->MEDI_ID ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EXCLUIR A UNIDADE ABAIXO?</legend>


        <label>Codigo: <?php echo set_value('', $query->MEDI_ID); ?></label><br>
        
        <label>Nome: <?php echo set_value('MEDI_NOME', $query->MEDI_NOME); ?></label><br>
        
        <label>Sigla: <?php echo set_value('MEDI_SIGLA', $query->MEDI_SIGLA); ?></label>

        <input type="hidden" name="id_medida" value="<?php echo $query->MEDI_ID ?>" />

        <hr><button type="submit" class="btn btn-danger">SIM</button>

    </fieldset>

</form>