<?php
$id_produto = $this->uri->segment(3);

if (isset($mensagem)):
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();

elseif ($id_produto == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div?>';
    exit();
endif;

$query = $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row();

if ($query == NULL):
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>

<form action="produto/excluir/<?php echo $id_produto; ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EXCLUIR O PRODUTO ABAIXO?</legend>


        <label>CODIGO: <?php echo $query->PRO_ID ?></label>

        <label>Descrição:</label>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO', $query->PRO_DESCRICAO); ?>" readonly />

        <label>Caracteristica Tecnicas:</label>
        <textarea name="PRO_CARAC_TEC" readonly rows="10"><?php echo set_value('PRO_CARAC_TEC', $query->PRO_CARAC_TEC); ?></textarea>

        <input type="hidden" name="id_produto" value="<?php echo $query->PRO_ID ?>" />

        <br><button type="submit" class="btn">SIM, EXCLUIR</button>

    </fieldset>

</form>