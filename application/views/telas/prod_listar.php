<?php
$this->table->set_heading('COD', 'IMAGEM', 'DESCRIÇÃO');

foreach ($produtos as $linha) {
    $linha->PRO_IMG != null ? $icone = str_replace(".jpg", "_thumb.jpg", $linha->PRO_IMG) : $icone = "sem_img.jpg";
    $this->table->add_row($linha->PRO_ID, '<img src="' . APPPATH . 'views/img_produto/' . $icone . '" class="img-rounded">', $linha->PRO_DESCRICAO);
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