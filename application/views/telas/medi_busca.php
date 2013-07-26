<?php

if (isset($_GET['buscar'])) {
    $busca = $_GET['buscar'];

    $query = $this->crud_model->buscar("MEDIDAS", array('MEDI_NOME' => $busca))->result();

    $this->table->set_heading('MEDIDA', 'SIGLA', "OP's");

    foreach ($query as $linha) {
        $this->table->add_row($linha->MEDI_NOME, $linha->MEDI_SIGLA, anchor("medida/editar/$linha->MEDI_ID", '<i class="icon-edit"></i>') . ' ' . anchor("medida/excluir/$linha->MEDI_ID", '<i class="icon-trash"></i>'));
    }

    $tmpl = array('table_open' => '<table class="table table-hover">');
    $this->table->set_template($tmpl);

    echo $this->table->generate();
}
?>