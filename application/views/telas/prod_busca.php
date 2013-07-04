        <div class="row">
            <div class="span6" id="resultado">
                <?php
                if (isset($_GET['buscar'])) {
                    $id_produto = $_GET['buscar'];

                $query = $this->produto_model->buscar("$id_produto")->result();

                $this->table->set_heading('COD', 'DESCRIÇÃO', 'VALOR', 'OPERAÇÃO');

                foreach ($query as $linha) {
                    $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $linha->PRO_VAL_VEND, anchor("produto/editar/$linha->PRO_ID", 'Editar') . ' ' . anchor("produto/excluir/$linha->PRO_ID", 'Excluir'));
                }

                $tmpl = array('table_open' => '<table class="table table-hover">');
                $this->table->set_template($tmpl);

                echo $this->table->generate();
                }
                ?>
            </div>
        </div>
<script>
    $("a").click(function() {
        var href = $(this).attr('href');
        $("#cadastro").load(href);
        return false;
    });
</script>