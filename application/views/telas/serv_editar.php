<?php
$id_servico = $this->uri->segment(3);

if ($id_servico == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->crud_model->pega("SERVICOS", array('SERV_ID' => $id_servico))->row();

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form method="post" action="<?php echo base_url('servico'); ?>/editar/<?php echo $id_servico; ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE SERVIÇO</legend>


        <?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>


        <label>Descrição:</label>
        <?php echo form_error('SERV_NOME'); ?>
        <input type="text" name="SERV_NOME" value="<?php echo set_value('SERV_NOME', $query->SERV_NOME); ?>"/>

        <label>Descrição:</label>
        <?php echo form_error('SERV_DESC'); ?>
        <textarea name="SERV_DESC" rows="10"><?php echo set_value('SERV_DESC', $query->SERV_DESC); ?></textarea>

        <label>Descrição:</label>
        <?php echo form_error('SERV_VALOR'); ?>
        <input type="text" name="SERV_VALOR" value="<?php echo set_value('SERV_VALOR', number_format($query->SERV_VALOR, 2, ',', '.')); ?>" />

        <?php echo form_dropdown('SERV_ESTATUS', array('a' => 'Ativo', 'd' => 'Desativo'), set_value('SERV_ESTATUS', $query->SERV_ESTATUS)); ?>

        </div>

        <input type="hidden" value="<?php echo $id_servico; ?>" name="id_servico" />

        <hr><button type="submit" class="btn btn-default" disabled>SALVA ALTERAÇÕES</button>

    </fieldset>
</form>
<script src="<?php echo base_url('assets/js/mascaras.js'); ?>"></script>
