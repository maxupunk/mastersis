<?php if (isset($mensagem)) echo '<div class="alert alert-info">' . $mensagem . '</div>';
echo "Cliente: ".$cliente->PES_NOME."<br>";
echo "VENDA COD.: ".$id_venda."<br>";
?>

<label>PRODUTO (DESCRIÇÃO OU ID) :</label>
<input type="text" name="PRO_NOME" id="produto_venda" autofocus />
<script src="<?php echo base_url('assets/js/vendas.js'); ?>"></script>
