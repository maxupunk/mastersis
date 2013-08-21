<?php
$id_servico = $this->uri->segment(3);

if (isset($mensagem) and $mensagem != NULL) {
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();
}

if ($query == NULL):
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>

<form action="<?php echo base_url('servico'); ?>/excluir/<?php echo $query->SERV_ID ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EXCLUIR O SERVIÇO ABAIXO?</legend>

        <label>Servço:</label>
        <input type="text" name="SERV_NOME" value="<?php echo set_value('SERV_NOME', $query->SERV_NOME); ?>" readonly />

        <label>Descrição:</label>
        <textarea name="SERV_DESC" readonly rows="10"><?php echo set_value('SERV_DESC', $query->SERV_DESC); ?></textarea>

        <input type="hidden" name="id_servico" value="<?php echo $query->SERV_ID ?>" />

        <br><button type="submit" class="btn btn-default">SIM, EXCLUIR</button>

    </fieldset>

</form>