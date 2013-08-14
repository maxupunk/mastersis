<?php

if ($mensagem == "1") {
    echo "Produto sem estoque";
    die();
}

if (isset($mensagem)) {
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
}

setlocale(LC_MONETARY, "pt_BR", "ptb");

$this->table->set_heading('', '', 'QUANTIDADE', 'MEDIDA', 'DESCRIÇÃO', 'PESO(Kg)', 'PREÇO(UN)', 'SUB. TOTAL');

$total = 0;
foreach ($lista_pedido as $linha) {

    $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
    $total = ($total + $sub_total);

    $linha->PRO_IMG != null ? $icone = str_replace(".jpg", "_thumb.jpg", $linha->PRO_IMG) : $icone = "sem_img.gif";

    $this->table->add_row($linha->PRO_ID, '<img src="assets/img_produto/' . $icone . '" class="img-rounded" width="80" height="80">', '<input type="number" id="quantidade" min="0.00" step="1.00" max="' . $linha->ESTOQ_ATUAL . '" list_ped_id="' . $linha->LIST_PED_ID . '" value="' . $linha->LIST_PED_QNT . '">', $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, $linha->PRO_PESO, money_format('%n', $linha->LIST_PED_PRECO), money_format('%n', $sub_total));
}

$this->table->add_row('', '', '', '', '', '', 'TOTAL:', money_format('%n', $total));

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>