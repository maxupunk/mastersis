<?php
    $this->table->set_heading('COD', 'DESCRIÇÃO', "OP's");

    foreach ($query as $linha) {
        $linha->PRO_ESTATUS == 'd' ? $estatus = '<strike>' . $linha->PRO_DESCRICAO . '</strike>' : $estatus = $linha->PRO_DESCRICAO;

        $this->table->add_row($linha->PRO_ID, $estatus, anchor("produto/editar/$linha->PRO_ID", '<span class="glyphicon glyphicon-edit"></span>') . ' ' . anchor("produto/excluir/$linha->PRO_ID", '<span class="glyphicon glyphicon-trash"></span>'). ' ' . anchor("produto/exibir/$linha->PRO_ID", '<span class="glyphicon glyphicon-list-alt"></span>') . ' ' . anchor("produto/imagem/$linha->PRO_ID", '<span class="glyphicon glyphicon-picture"></span>'));
    }

    $tmpl = array('table_open' => '<table class="table table-hover">');
    $this->table->set_template($tmpl);

    echo $this->table->generate();
?>