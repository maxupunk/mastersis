<?php
setlocale(LC_MONETARY, 'pt_BR');
$this->table->set_heading('COD', 'IMAGEM', 'DESCRIÇÃO', 'VALOR');

foreach ($produtos as $linha) {
    $valor = money_format('%.2n', $linha->PRO_VAL_VEND);
    $linha->PRO_IMG != null ? $icone = str_replace(".jpg", "_thumb.jpg", $linha->PRO_IMG) : $icone = "sem_img.jpg";
    $this->table->add_row($linha->PRO_ID, '<img src="' . APPPATH . 'views/produto_img/' . $icone . '" class="img-rounded">', $linha->PRO_DESCRICAO, $valor);
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