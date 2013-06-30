<<<<<<< HEAD:application/views/telas/produto/editar.php
<?php

$id_produto = $this->uri->segment(3);

if ($id_produto == NULL) redirect('produto/lista_todas');

$query = $this->produto_model->pega_id($id_produto)->row();

echo validation_errors('<div class="alert-box alert">','</div>');

	if ($this->session->flashdata('edit_prod_ok')):
		echo '<div class="alert-box success">'.$this->session->flashdata('edit_prod_ok').'</div>';
	endif;

?>


<form action="produto/editar/<?php echo $id_produto;?>" method="post" accept-charset="utf-8">
  <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO',$query->PRO_DESCRICAO); ?>" size="110" maxlength="45" placeholder="ESCRIÇÃO DO PRODUTO." />
  
  <textarea name="PRO_CARAC_TEC" placeholder="ESPECIFIÇÃO TECNICA"><?php echo set_value('PRO_CARAC_TEC',$query->PRO_CARAC_TEC); ?></textarea>
  
  <div class="row">
    <div class="three columns">
      <input type="text" name="PRO_VAL_CUST" value="<?php echo set_value('PRO_VAL_CUST',$query->PRO_VAL_CUST); ?>" placeholder="CUSTO R$" />
    </div>
    <div class="three columns end">
      <input type="text" name="PRO_VAL_VEND" value="<?php echo set_value('PRO_VAL_VEND',$query->PRO_VAL_VEND); ?>" placeholder="VENDA R$" />
    </div>
  </div>
  
  <input type="submit" name="cadastra" value="ATUALIZAR"  />

</form>

<!-- Inicializa o script de menu -->
<script src="<?php echo base_url('application/views/javascripts/mastersis.scripts.js');?>"></script>
=======
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.:application/views/telas/prod_editar.php
