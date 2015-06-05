<?php
if (isset($mensagem) and $mensagem != NULL) {
    echo $mensagem;
    exit();
}

if ($query == NULL):
    echo 'Esse item não existe ou foi excluido!';
    exit();
endif;
?>

<form action="produto/ImagemExcluir/<?php echo $query->PROIMG_ID ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>
        <div>
            <legend>Deseja excluir a imagem?</legend>
            <div class="BordaOs">
                <img src="assets/arquivos/produto/<?php echo $query->PROIMG_NOME ?>" width="20%">
            </div>
            <input type="hidden" name="id" value="<?php echo $query->PROIMG_ID ?>" />

            <button type="submit" class="btn btn-danger">SIM</button>
        </div>
    </fieldset>

</form>