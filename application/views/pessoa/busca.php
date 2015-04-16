<?php

$this->table->set_heading('ID', 'NOME', 'CEL.', "OP's");

foreach ($query as $linha) {
    $linha->PES_ESTATUS == 'd' ? $estatus = '<strike>' . $linha->PES_NOME . '</strike>' : $estatus = $linha->PES_NOME;

    $this->table->add_row($linha->PES_ID, $estatus, $linha->PES_CEL1,
            anchor("pessoa/editar/$linha->PES_ID", '<span class="glyphicon glyphicon-edit"></span>', 'id="InContent"') . ' ' .
            anchor("pessoa/excluir/$linha->PES_ID", '<span class="glyphicon glyphicon-trash"></span>', 'data-toggle="modal" data-target="#Modal"') . ' ' .
            anchor("venda/listar/$linha->PES_ID", '<span class="glyphicon glyphicon-list-alt"></span>', 'id="InContent"'));
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>