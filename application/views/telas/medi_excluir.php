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


        <label>Codigo:</label>
        <input type="text" name="MEDI_ID" value="<?php echo set_value('', $query->MEDI_ID); ?>" readonly />
        
        <label>Nome:</label>
        <input type="text" name="MEDI_NOME" value="<?php echo set_value('MEDI_NOME', $query->MEDI_NOME); ?>" readonly />

        <label>Sigla:</label>
        <input type="text" name="MEDI_SIGLA" value="<?php echo set_value('MEDI_SIGLA', $query->MEDI_SIGLA); ?>" readonly />

        <input type="hidden" name="id_medida" value="<?php echo $query->MEDI_ID ?>" />

        <hr><button type="submit" class="btn btn-danger">SIM, EXCLUIR</button>

    </fieldset>

</form>