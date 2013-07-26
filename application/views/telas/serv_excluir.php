<?php
$id_servico = $this->uri->segment(3);

if (isset($mensagem)):
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();

elseif ($id_servico == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div?>';
    exit();
endif;

$query = $this->crud_model->pega("SERVICOS", array('SERV_ID' => $id_servico))->row();

if ($query == NULL):
    echo '<div class="alert alert-error">Esse item não existe ou foi excluido!</div>';
    exit();
endif;
?>

<form action="<?php echo base_url('servico'); ?>/excluir/<?php echo $id_servico; ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EXCLUIR O SERVIÇO ABAIXO?</legend>


        <label>CODIGO: <?php echo $query->SERV_ID ?></label>

        <label>Servço:</label>
        <input type="text" name="SERV_NOME" value="<?php echo set_value('SERV_NOME', $query->SERV_NOME); ?>" readonly class="span6" />

        <label>Descrição:</label>
        <textarea name="SERV_DESC" readonly rows="10" class="span6"><?php echo set_value('SERV_DESC', $query->SERV_DESC); ?></textarea>

        <input type="hidden" name="id_servico" value="<?php echo $query->SERV_ID ?>" />

        <br><button type="submit" class="btn">SIM, EXCLUIR</button>

    </fieldset>

</form>