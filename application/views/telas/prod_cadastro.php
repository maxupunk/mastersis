<form action="<?php echo base_url('produto'); ?>/cadastrar" method="post" name="grava" accept-charset="utf-8">

                <fieldset>

                    <legend>CADASTRO DE PRODUTO</legend>

                    <?php
                    echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

                    if ($this->session->flashdata('cad_prod_ok')):
                        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('cad_prod_ok') . '</div>';
                    endif;
                    ?>

                    <label>Descrição do produto:</label>
                    <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" maxlength="45" class="span6" />

                    <label>Caracteristica Tecnicas:</label>
                    <textarea name="PRO_CARAC_TEC" rows="10" class="span6"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>

                    <label>Valor de Custo:</label>
                    <input type="text" name="PRO_VAL_CUST" maxlength="12" id="valor" value="<?php echo set_value('PRO_VAL_CUST'); ?>" class="span2" />

                    <label>Valor de Venda:</label>
                    <input type="text" name="PRO_VAL_VEND" maxlength="12" id="valor" value="<?php echo set_value('PRO_VAL_VEND'); ?>" class="span2" />
                    

                    <hr><button type="submit" class="btn">CADASTRAR</button>

                </fieldset>

            </form>

	<script type="text/javascript">$(".span2").maskMoney({thousands:'.', decimal:','});</script>
