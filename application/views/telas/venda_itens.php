<?php
if (isset($mensagem) and $mensagem != NULL) {
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
}

if ($lista_pedido <> NULL){

$this->table->set_heading('', '', 'QNT', 'MEDIDA', 'DESCRIÇÃO', 'PESO(Kg)', 'PREÇO(UN)', 'SUB. TOTAL', '');

foreach ($lista_pedido as $linha) {

    $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);

    $linha->PRO_IMG != null ? $icone = str_replace(".jpg", "_thumb.jpg", $linha->PRO_IMG) : $icone = "sem_img.gif";
    $imagem = '<img src="assets/arquivos/produto/' . $icone . '" class="img-rounded" width="80" height="80">';
    
    $quantidade = '<input type="number" id="quantidade" min="1.00" step="1.00" max="' . $linha->ESTOQ_ATUAL . '" list_ped_id="' . $linha->LIST_PED_ID . '" id_estoque="' . $linha->ESTOQ_ID . '" value="' . $linha->LIST_PED_QNT . '">';
    $excluir = '<button type="button" class="close" id="excluir-item" list_ped_id="' . $linha->LIST_PED_ID . '">&times;</button>';
    
    $this->table->add_row($linha->PRO_ID, $imagem, $quantidade, $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, $linha->PRO_PESO, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total), $excluir);
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate(); ?>
<div class="col-sm-12 BordaOs text-right">
    TOTAL A PAGAR : <?php echo $this->convert->em_real($total->total) ?>
</div>
<?php } ?>