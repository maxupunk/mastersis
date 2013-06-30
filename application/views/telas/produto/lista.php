
<div class="row">
    <div class="twelve columns">
		<input type="text" id="busca" size="110" maxlength="45" placeholder="BUSCAR" autofocus />
    </div>
</div>

<div class="row">
    <div id="resultado" class="twelve columns">
<?php

		$this->table->set_heading('ID','DESCRIÇÃO', 'VALOR', 'SITUAÇÃO', 'OPERAÇÃO');

		foreach ($produtos as $linha)
		{
			$situacao = $linha->PRO_SITUACAO == 0 ? "Desativo" : "Ativo";
			$this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $linha->PRO_VAL_VEND, $situacao, anchor("produto/editar/$linha->PRO_ID",'Editar').' '.anchor("produto/excluir/$linha->PRO_ID",'Excluir'));	
		}

		echo $this->table->generate();

?>
    </div>
</div>
 
<script>
	$("#busca").keyup(function() {
		$("#resultado").load('produto/buscar?buscar='+encodeURIComponent($(this).val()));
	});
</script>

<!-- Inicializa o script -->
<script src="<?php echo base_url('application/views/javascripts/mastersis.scripts.js');?>"></script>