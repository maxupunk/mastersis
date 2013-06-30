<?php

echo form_open('produto/cadastro');

echo validation_errors('<p>','</p>');

	if ($this->session->flashdata('cad_prod_ok')):
		echo '<p>'.$this->session->flashdata('cad_prod_ok').'</p>';
	endif;

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