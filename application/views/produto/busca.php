<?php

$this->table->set_heading('COD', 'DESCRIÇÃO ( * = serviço )', "OP's");

foreach ($query as $linha) {
    $linha->PRO_ESTATUS == 'd' ? $estatus = '<strike>' . $linha->PRO_DESCRICAO . '</strike>' : $estatus = $linha->PRO_DESCRICAO;
    $linha->PRO_TIPO == 's' ? $tipo = '<strong>*</strong>' : $tipo = "";

    $this->table->add_row($linha->PRO_ID, $estatus." ".$tipo,
            anchor("produto/editar/$linha->PRO_ID", '<span class="glyphicon glyphicon-edit"></span>', 'id="InContent"').' '.
            anchor("produto/excluir/$linha->PRO_ID", '<span class="glyphicon glyphicon-trash"></span>', 'data-toggle="modal" data-target="#Modal"').' '.
            anchor("produto/exibir/$linha->PRO_ID", '<span class="glyphicon glyphicon-list-alt"></span>', 'id="InContent"').' '.
            anchor("produto/imagem/$linha->PRO_ID", '<span class="glyphicon glyphicon-picture"></span>', 'id="InContent"'));
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>