<?php

	$this->table->set_heading('ID|', 'DESCRIÇÃO|', 'CARACTERISTICAS|', 'VALOR R$|', 'SITUAÇÃO|', 'OPERAÇÃO');

	foreach ($produtos as $linha)
	{
		if ($linha->PRO_SITUACAO != '1'){ $situacao="Desativo"; }else{ $situacao="Ativo"; }
		
		$this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $linha->PRO_CARAC_TEC, $linha->PRO_VAL_VEND, $situacao, anchor("produto/editar/$linha->PRO_ID",'Editar').' - '.anchor("produto/excluir/$linha->PRO_ID",'Excluir'));	
	}
	
	echo $this->table->generate();

?>