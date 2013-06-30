<?php

$id_produto = $this->uri->segment(3);

if ($id_produto == NULL) redirect('produto/lista_todas');

	if ($this->session->flashdata('exclui_prod_ok')):
		echo '<div class="alert-box success">'.$this->session->flashdata('exclui_prod_ok').'</div>';
		echo '<script type="text/javascript"> $("#direita").load("produto/lista_todas"); </script>';
	else:

$query = $this->produto_model->pega_id($id_produto)->row();

?>

<form action="produto/excluir/<?php echo $id_produto;?>" method="post" accept-charset="utf-8">
  <input type="text" name="PRO_DESCRICAO" value="<?php echo set_value('PRO_DESCRICAO',$query->PRO_DESCRICAO); ?>" disabled />
  
  <textarea name="PRO_CARAC_TEC" disabled><?php echo set_value('PRO_CARAC_TEC',$query->PRO_CARAC_TEC); ?></textarea>
  
  <div class="row">
    <div class="three columns">
      <input type="text" name="PRO_VAL_CUST" value="<?php echo set_value('PRO_VAL_CUST',$query->PRO_VAL_CUST); ?>" disabled />
    </div>
    <div class="three columns end">
      <input type="text" name="PRO_VAL_VEND" value="<?php echo set_value('PRO_VAL_VEND',$query->PRO_VAL_VEND); ?>" disabled/>
    </div>
  </div>
  
  <input type="hidden" name="id_produto" value="<?php echo $query->PRO_ID ?>" />
  
  <input type="submit" value="EXCLUIR CADASTRO"  />

</form>

<!-- Inicializa o script de menu -->
<script src="<?php echo base_url('application/views/javascripts/mastersis2.scripts.js');?>"></script>

<?php endif; ?>