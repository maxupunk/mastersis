<?php

$this->table->set_heading('ID','APELIDO', 'LOGIN', "OP's");

foreach ($query as $linha) {

    $linha->USUARIO_ESTATUS == 'd' ? $estatus = '<strike>' . $linha->USUARIO_LOGIN . '</strike>' : $estatus = $linha->USUARIO_LOGIN;

    $this->table->add_row($linha->USUARIO_ID, $linha->USUARIO_APELIDO, $estatus, anchor("usuario/editar/$linha->USUARIO_ID", '<span class="glyphicon glyphicon-edit"></i>'));
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();

?>