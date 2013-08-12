<?php

$this->table->set_heading('COD', 'NOME', "OP's");

foreach ($query as $linha) {

    $linha->CATE_ESTATUS == 'd' ? $estatus = '<strike>' . $linha->CATE_NOME . '</strike>' : $estatus = $linha->CATE_NOME;

    $this->table->add_row($linha->CATE_ID, $estatus, anchor("categoria/editar/$linha->CATE_ID", '<span class="glyphicon glyphicon-edit"></span>') . ' ' . anchor("categoria/imagem/$linha->CATE_ID", '<span class="glyphicon glyphicon-picture"></span>'));
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>