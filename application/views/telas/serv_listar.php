<?php

echo "<p>Total de categoria: ".$total."</p>";

$this->table->set_heading('COD', 'SERVICO', 'VALOR');

foreach ($servico as $linha) {
    $this->table->add_row($linha->SERV_ID, $linha->SERV_NOME, number_format($linha->SERV_VALOR, 2, ',', '.'));
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>

<div class="pagination" id="pagination">
    <ul>

        <? if ($paginacao) echo $paginacao; ?>

    </ul>
</div>