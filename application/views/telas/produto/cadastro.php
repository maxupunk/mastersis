<?php

<<<<<<< HEAD:application/views/telas/produto/cadastro.php
	echo validation_errors('<div class="alert-box alert">','</div>');
=======
echo form_open('produto/cadastro');

echo validation_errors('<p>','</p>');
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.:application/views/telas/prod_cadastro.php

	if ($this->session->flashdata('cad_prod_ok')):
		echo '<p>'.$this->session->flashdata('cad_prod_ok').'</p>';
	endif;

<<<<<<< HEAD:application/views/telas/produto/cadastro.php
?>

<form action="produto/cadastrar" method="post" accept-charset="utf-8">
  <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO'); ?>" size="110" maxlength="45" placeholder="ESCRIÇÃO DO PRODUTO." autofocus />
  
  <textarea name="PRO_CARAC_TEC" placeholder="ESPECIFIÇÃO TECNICA"><?php echo set_value('PRO_CARAC_TEC'); ?></textarea>
  
  <div class="row">
    <div class="three columns">
      <input type="text" name="PRO_VAL_CUST" id="valor" value="<?php echo set_value('PRO_VAL_CUST'); ?>" placeholder="CUSTO R$" />
    </div>
    <div class="three columns end">
      <input type="text" name="PRO_VAL_VEND" id="valor1" value="<?php echo set_value('PRO_VAL_VEND'); ?>" placeholder="VENDA R$" />
    </div>
  </div>
  
  <input type="submit" name="cadastra" value="CADASTRA"  />
</form>

<script src="<?php echo base_url('application/views/javascripts/mastersis.scripts.js');?>"></script>
<!-- Inicializa o script de mascara -->
<script src="<?php echo base_url('application/views/javascripts/jquery.maskMoney.js');?>"></script>

<script type="text/javascript">
$("#valor").maskMoney({thousands:'', decimal:'.'});
$("#valor1").maskMoney({thousands:'', decimal:'.'});
</script>
=======
echo form_label(' ESCRIÇÃO DO PRODUTO: ');
echo form_input(array('name' => 'PRO_DESCRICAO','size' => '110','maxlength' => '45'),set_value('PRO_DESCRICAO'));

echo form_label(' ESPECIFIÇÃO TECNICA: ');
echo form_textarea(array('name' => 'PRO_CARAC_TEC'),set_value('PRO_CARAC_TEC'));

echo form_label(' PREÇO DE CUSTO: ');
echo form_input(array('name' => 'PRO_VAL_CUST'),set_value('PRO_VAL_CUST'));

echo form_label(' PREÇO DE VENDA: ');
echo form_input(array('name' => 'PRO_VAL_VEND'),set_value('PRO_VAL_VEND'));

echo form_submit(array('name'=>'cadastra'),'Cadastrar');

echo form_close();
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.:application/views/telas/prod_cadastro.php
