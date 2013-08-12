<?php
if (isset($mensagem)){
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


        <label>Nome:</label>
        <input type="text" name="PES_NOME" value="<?php echo set_value('PES_NOME', $query->PES_NOME); ?>" readonly />

        <label>CPF/CNPJ:</label>
        <input type="text" name="PES_CPF_CNPJ" value="<?php echo set_value('PES_CPF_CNPJ', $query->PES_CPF_CNPJ); ?>" readonly />

        <input type="hidden" name="id_pessoa" value="<?php echo $query->PES_ID ?>" />

        <hr><button type="submit" class="btn">SIM, EXCLUIR</button>

    </fieldset>

</form>