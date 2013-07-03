<div class="row">
    <div class="span8 offset2">
        <?php
        $this->table->set_heading('ID', 'DESCRIÇÃO', 'VALOR', 'OPERAÇÃO');

        foreach ($produtos as $linha) {
            $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $linha->PRO_VAL_VEND, anchor("produto/editar/$linha->PRO_ID", 'Editar') . ' ' . anchor("produto/excluir/$linha->PRO_ID", 'Excluir'));
        }

        $tmpl = array('table_open' => '<table class="table table-hover">');
        $this->table->set_template($tmpl);

        echo $this->table->generate();
        ?>

        <div class="pagination">
            <ul>

                <? if ($paginacao) echo $paginacao; ?>

            </ul>
        </div>

    </div>
</div>