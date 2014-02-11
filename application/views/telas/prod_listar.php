<?php

echo "<p>Total de itens : ".$total."</p>";

$this->table->set_heading('COD', 'IMAGEM', 'DESCRIÇÃO');

foreach ($produtos as $linha) {
    $linha->PRO_IMG != null ? $icone = str_replace(".jpg", "_thumb.jpg", $linha->PRO_IMG) : $icone = "sem_img.gif";
    $this->table->add_row($linha->PRO_ID, '<img src="assets/img_produto/' . $icone . '" class="img-rounded" width="120" height="120">', $linha->PRO_DESCRICAO);
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>

<ul class="pagination" id="pagination">
        <? if ($paginacao) echo $paginacao; ?>
</ul>