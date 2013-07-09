<?php
$id_produto = $this->uri->segment(3);

if ($id_produto == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div?>';
    exit();
endif;

if ($this->session->flashdata('exclui_prod_ok')):
    echo '<div class="alert alert-success">' . $this->session->flashdata('exclui_prod_ok') . '</div>';
    exit();
endif;

$query = $this->produto_model->pega_id($id_produto)->row();
if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>

<form action="produto/excluir/<?php echo $id_produto; ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EXCLUIR O PRODUTO ABAIXO?</legend>

        <label>CODIGO: <?php echo $query->PRO_ID ?></label>

        <label>Descrição do produto:</label>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO', $query->PRO_DESCRICAO); ?>" readonly class="span6" />

        <label>Caracteristica Tecnicas:</label>
        <textarea name="PRO_CARAC_TEC" readonly class="span6"><?php echo set_value('PRO_CARAC_TEC', $query->PRO_CARAC_TEC); ?></textarea>

        <label>Valor de Custo:</label>
        <input type="text" name="PRO_VAL_CUST" value="<?php echo set_value('PRO_VAL_CUST', $query->PRO_VAL_CUST); ?>" readonly class="span2" />

        <label>Valor de Venda:</label>
        <input type="text" name="PRO_VAL_VEND" value="<?php echo set_value('PRO_VAL_VEND', $query->PRO_VAL_VEND); ?>" readonly class="span2" />

        <input type="hidden" name="id_produto" value="<?php echo $query->PRO_ID ?>" />

        <br><button type="submit" class="btn">SIM, EXCLUIR</button>

    </fieldset>

</form>