<?php
$id_produto = $this->uri->segment(3);

if ($id_produto == NULL)
    redirect('produto/lista_todas');

$query = $this->produto_model->pega_id($id_produto)->row();

echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

if ($this->session->flashdata('edit_prod_ok')):
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('edit_prod_ok') . '</div>';
endif;
?>

<form method="post" id="editar" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE PRODUTO</legend>

        <label>Descrição do produto:</label>
        <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO', $query->PRO_DESCRICAO); ?>" class="span5" />

        <label>Caracteristica Tecnicas::</label>
        <textarea name="PRO_CARAC_TEC" class="span5"><?php echo set_value('PRO_CARAC_TEC', $query->PRO_CARAC_TEC); ?></textarea>

        <label>Valor de Custo:</label>
        <input type="text" name="PRO_VAL_CUST" value="<?php echo set_value('PRO_VAL_CUST', $query->PRO_VAL_CUST); ?>" class="span2" />

        <label>Valor de Venda:</label>
        <input type="text" name="PRO_VAL_VEND" value="<?php echo set_value('PRO_VAL_VEND', $query->PRO_VAL_VEND); ?>" class="span2" />

        <input type="hidden" value="<?php echo $id_produto; ?>" name="id_produto" />

        <br><button type="submit" class="btn">ATUALIZAR</button>

    </fieldset>
    <script>
        $("form").submit(function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('produto'); ?>/editar/<?php echo $id_produto; ?>",
                dataType: "html",
                data: $(this).serialize(),
                // enviado com sucesso
                success: function(response) {
                    $("#cadastro").html(response);
                },
                // quando houver erro
                error: function() {
                    $("#cadastro").append("<p>- Ocoreu um erro na requisição! tente novamente mais tarde</p><?php echo base_url('produto'); ?>/editar/<?php echo $id_produto; ?>");
                }
            });
            return false;
        });
    </script>