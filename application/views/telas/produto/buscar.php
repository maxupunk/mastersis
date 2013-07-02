<?php

$id_produto = $_GET['buscar'];

if (strlen($id_produto) >= 3):

$query = $this->produto_model->buscar("$id_produto")->result();

$this->table->set_heading('ID','DESCRIÇÃO', 'VALOR', 'SITUAÇÃO', 'OPERAÇÃO');

		foreach ($query as $linha)
		{
			$situacao = $linha->PRO_SITUACAO == 0 ? "Desativo" : "Ativo";
			$this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $linha->PRO_VAL_VEND, $situacao, anchor("produto/editar/$linha->PRO_ID",'Editar').' '.anchor("produto/excluir/$linha->PRO_ID",'Excluir'));	
		}

		echo $this->table->generate();

endif; ?>

<!-- Inicializa o script -->
<script src="<?php echo base_url('application/views/javascripts/mastersis.scripts.js');?>"></script>
