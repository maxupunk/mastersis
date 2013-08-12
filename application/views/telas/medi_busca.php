<?php
    $this->table->set_heading('MEDIDA', 'SIGLA', "OP's");

    foreach ($query as $linha) {
        $this->table->add_row($linha->MEDI_NOME, $linha->MEDI_SIGLA, anchor("medida/editar/$linha->MEDI_ID", '<i class="glyphicon glyphicon-edit"></i>') . ' ' . anchor("medida/excluir/$linha->MEDI_ID", '<i class="glyphicon glyphicon-trash"></i>'));
    }

    $tmpl = array('table_open' => '<table class="table table-hover">');
    $this->table->set_template($tmpl);

    echo $this->table->generate();
?>