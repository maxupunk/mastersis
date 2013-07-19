<?php
$this->table->set_heading('COD', 'IMAGEM', 'CATEGORIA');

foreach ($categoria as $linha) {
    $linha->CATE_IMG != null ? $icone = str_replace(".jpg", "_thumb.jpg", $linha->CATE_IMG) : $icone = "sem_img.jpg";
    $this->table->add_row($linha->CATE_ID, '<img src="' . APPPATH . 'views/img_categoria/' . $icone . '" class="img-rounded">', $linha->CATE_NOME);
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