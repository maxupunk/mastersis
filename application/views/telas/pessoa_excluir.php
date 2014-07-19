<?php
if (isset($mensagem) and $mensagem != NULL){
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();
}

if ($query == NULL):
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>

<form action="pessoa/excluir/<?php echo $query->PES_ID ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EXCLUIR A PESSOA ABAIXO?</legend>


        <label>Nome: <?php echo set_value('PES_NOME', $query->PES_NOME); ?></label><br>

        <label>CPF/CNPJ: <?php echo set_value('PES_CPF_CNPJ', $query->PES_CPF_CNPJ); ?></label>

        <input type="hidden" name="id_pessoa" value="<?php echo $query->PES_ID ?>" />

        <hr><button type="submit" class="btn btn-danger">SIM</button>

    </fieldset>

</form>