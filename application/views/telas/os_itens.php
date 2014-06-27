<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
    <?php
}

if ($ListaProduto <> NULL) {

    $this->table->set_heading('COD', 'DESCRIÇÃO', 'QNT', 'VALOR', 'SUBTOTAL');

    foreach ($ListaProduto as $linha) {
        $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
        $quantidade = '<input type="number" id="quantidade" min="1.00" step="1.00" max="' . $linha->ESTOQ_ATUAL . '" list_ped_id="' . $linha->LIST_PED_ID . '" id_estoque="' . $linha->ESTOQ_ID . '" value="' . $linha->LIST_PED_QNT . '">';
        $excluir = '<button type="button" class="close" id="excluir-item" list_ped_id="' . $linha->LIST_PED_ID . '">&times;</button>';
        $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $quantidade, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total), $excluir);
    }

    $tmpl = array('table_open' => '<table class="lista-produto">');
    $this->table->set_template($tmpl);

    echo $this->table->generate();
} else {
    echo "<p align='center'>Não foi usado produto(s)!</p>";
}
?>
<div class="col-sm-12 BordaOs text-right">
    TOTAL A PAGAR : <?php echo $this->convert->em_real($total->total) ?>
</div>