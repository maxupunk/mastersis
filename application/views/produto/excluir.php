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

<form action="produto/excluir/<?php echo $query->PRO_ID ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>
        <div>
            <legend>Deseja excluir o produto abaixo?</legend>
            <div class="BordaOs">
                <label>COD: <?php echo $query->PRO_ID ?></label><br>

                <label>DSC:</label>
                <label><?php echo set_value('PRO_DESCRICAO', $query->PRO_DESCRICAO); ?></label>
            </div>
            <input type="hidden" name="id_produto" value="<?php echo $query->PRO_ID ?>" />

            <button type="submit" class="btn btn-danger">SIM</button>
        </div>
    </fieldset>

</form>