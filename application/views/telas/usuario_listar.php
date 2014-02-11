<?php

echo "<p>Total de usuarios : ".$total."</p>";

$this->table->set_heading('ID', 'APELIDO', 'LOGIN', 'ESTATUS');

foreach ($usuarios as $linha) {
    $linha->USUARIO_ESTATUS != "a" ? $estatus = '<span class="label label-danger">Desativo</span>' : $estatus = '<span class="label label-success">Ativo</span>';
    $this->table->add_row($linha->USUARIO_ID, $linha->USUARIO_APELIDO, $linha->USUARIO_LOGIN, $estatus);
}

$tmpl = array('table_open' => '<table class="table table-hover">');
$this->table->set_template($tmpl);

echo $this->table->generate();
?>

<ul class="pagination" id="pagination">
        <? if ($paginacao) echo $paginacao; ?>
</ul>