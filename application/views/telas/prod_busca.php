        <div class="row">
            <div class="span6" id="resultado">
                <?php
                if (isset($_GET['buscar'])) {
                    $id_produto = $_GET['buscar'];

                $query = $this->produto_model->buscar("$id_produto")->result();

                $this->table->set_heading('COD', 'DESCRIÇÃO', 'VALOR', "OP's");

                foreach ($query as $linha) {
                    setlocale(LC_MONETARY, 'pt_BR');
                    $valor = money_format('%.2n', $linha->PRO_VAL_VEND);
                    $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $valor, anchor("produto/editar/$linha->PRO_ID", '<i class="icon-edit"></i>').' '.anchor("produto/excluir/$linha->PRO_ID", '<i class="icon-trash"></i>') . '<br>' .anchor("produto/exibir/$linha->PRO_ID", '<i class="icon-list-alt"></i>').' '.anchor("produto/imagem/$linha->PRO_ID", '<i class="icon-picture"></i>'));
                }

                $tmpl = array('table_open' => '<table class="table table-hover">');
                $this->table->set_template($tmpl);

                echo $this->table->generate();
                }
                ?>
            </div>
        </div>