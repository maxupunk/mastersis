<?php

		$this->table->set_heading('DESCRIÇÃO', 'VALOR', 'OPERAÇÃO');

		foreach ($produtos as $linha)
		{
			$this->table->add_row($linha->PRO_DESCRICAO, $linha->PRO_VAL_VEND, anchor("produto/editar/$linha->PRO_ID",'Editar').' '.anchor("produto/excluir/$linha->PRO_ID",'Excluir'));	
		}
	
		echo $this->table->generate();
 
 ?>
 
<!-- Inicializa o script de menu -->
<script src="<?php echo base_url('application/views/javascripts/mastersis2.scripts.js');?>"></script>
