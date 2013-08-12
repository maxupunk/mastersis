<?php

//
// BUSCA RUAS
$this->table->add_row();
if ($busca_rua != NULL) {
    $this->table->add_row(array('class' => 'bg_tabela_enderco', 'data' => 'RUA(s)'));
    foreach ($busca_rua as $linha) {
        $this->table->add_row($linha->RUA_ID . ' - ' . $linha->RUA_NOME . ' - ' . $linha->RUA_CEP);
    }
}

//
// BUSCA BAIRROS
if ($busca_bairro != NULL) {
    $this->table->add_row(array('class' => 'bg_tabela_enderco', 'data' => 'BAIRRO(s)'));
    foreach ($busca_bairro as $linha) {
        $this->table->add_row($linha->BAIRRO_ID . ' - ' . $linha->BAIRRO_NOME);
    }
}

//
// BUSCA CIDADE
if ($busca_cidade != NULL) {
    $this->table->add_row(array('class' => 'bg_tabela_enderco', 'data' => 'CIDADE(s)'));
    foreach ($busca_cidade as $linha) {
        $this->table->add_row($linha->CIDA_ID . ' - ' . $linha->CIDA_NOME);
    }
}

//
// BUSCA ESTADOS 
if ($busca_estado != NULL) {
    $this->table->add_row(array('class' => 'bg_tabela_enderco', 'data' => 'ESTADO(s)'));
    foreach ($busca_estado as $linha) {
        $this->table->add_row($linha->ESTA_ID . ' - ' . $linha->ESTA_NOME);
    }
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>