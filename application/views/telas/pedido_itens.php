<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
<?php } ?>
    
<?php
if ($LstProd <> NULL) {

    echo validation_errors();

    $this->table->set_heading('COD', 'DESCRIÇÃO (Disponibilidade)', 'QNT', 'VALOR', 'SUBTOTAL');

    foreach ($LstProd as $linha) {
        $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
        $quantidade = '<input type="number" id="quantidade" min="1.00" step="1.00" ListPed="' . $linha->LIST_PED_ID . '" Estoque="' . $linha->ESTOQ_ID . '" value="' . $linha->LIST_PED_QNT . '">';
        $excluir = '<button type="button" class="close" id="excluir-item" ListPed="' . $linha->LIST_PED_ID . '">&times;</button>';
        $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO." ( ".$linha->ESTOQ_ATUAL." )", $quantidade, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total), $excluir);
    }

    $tmpl = array('table_open' => '<table class="lista-produto">');
    $this->table->set_template($tmpl);

    echo $this->table->generate();
    ?>
    <div class="col-sm-12 BordaOs text-right">
        TOTAL: <?php echo $this->convert->em_real($Total->total) ?>
    </div>
    <?php
} else {
    echo "<p align='center'>Não foi usado produto(s)!</p>";
}
?>