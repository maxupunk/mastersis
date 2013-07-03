<?php

echo validation_errors('<div class="alert alert-error">','</div>');

	if ($this->session->flashdata('cad_prod_ok')):
		echo '<div class="alert alert-success">'.$this->session->flashdata('cad_prod_ok').'</div>';
	endif;

?>
<form action="" method="post" accept-charset="utf-8">
  <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" size="110" maxlength="45" placeholder="ESCRIÇÃO DO PRODUTO." />
  
  <textarea name="PRO_CARAC_TEC" placeholder="ESPECIFIÇÃO TECNICA"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>
  
      <input type="text" name="PRO_VAL_CUST" value="<?php echo set_value('PRO_VAL_CUST'); ?>" placeholder="CUSTO R$" />
      <input type="text" name="PRO_VAL_VEND" value="<?php echo set_value('PRO_VAL_VEND'); ?>" placeholder="VENDA R$" />
  
  <input type="submit" name="cadastra" value="CADASTRA"  />

</form>