<?php
echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

if ($this->session->flashdata('cad_prod_ok')):
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('cad_prod_ok') . '</div>';
endif;
?>

<div class="row">
    <div class="span6">
        <div class="well" id="cadastro"><!-- tabela de cadastro -->
            <form action="" method="post" accept-charset="utf-8">

                <fieldset>

                    <legend>CADASTRO DE PRODUTO</legend>

                    <label>Descrição do produto:</label>
                    <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" maxlength="45" placeholder="DESCRIÇÃO DO PRODUTO." class="span5" />

                    <label>Caracteristica Tecnicas:</label>
                    <textarea name="PRO_CARAC_TEC" placeholder="ESPECIFIÇÃO TECNICA" class="span5"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>

                    <label>Valor de Custo:</label>
                    <input type="text" name="PRO_VAL_CUST" value="<?php echo set_value('PRO_VAL_CUST'); ?>" placeholder="CUSTO R$" class="span2" />

                    <label>Valor de Venda:</label>
                    <input type="text" name="PRO_VAL_VEND" value="<?php echo set_value('PRO_VAL_VEND'); ?>" placeholder="VENDA R$" class="span2" />


                    <hr><button type="submit" class="btn">CADASTRAR</button>

                </fieldset>

            </form>
        </div>
    </div>

    <div class="span6">
        <div class="well">
                <input type="text" name="buscar" id="busca"class="search-query span5" placeholder="Busca produto">
        </div>
        
        <div id="resultado"></div><!--resultado da busca -->

    </div>
</div>
<script>
    $("#busca").keyup(function() {
        
        if ( $(this).val().length > 0 ){
        $("#resultado").load("<?php echo base_url('produto'); ?>/busca?buscar="+encodeURI($(this).val()));
        }
    });
</script>