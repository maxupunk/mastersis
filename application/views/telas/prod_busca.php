        <?php
        if (isset($_GET['buscar'])) {
            $busca = $_GET['buscar'];

            
            $query = $this->crud_model->buscar("PRODUTOS",array('PRO_ID' => $busca, 'PRO_DESCRICAO' => $busca, 'PRO_CARAC_TEC' => $busca))->result();

            $this->table->set_heading('COD', 'DESCRIÇÃO', "OP's");

            foreach ($query as $linha) {
                $linha->PRO_ESTATUS=='d' ? $estatus = '<strike>'.$linha->PRO_DESCRICAO.'</strike>' : $estatus = $linha->PRO_DESCRICAO;
                
                $this->table->add_row($linha->PRO_ID, $estatus , anchor("produto/editar/$linha->PRO_ID", '<i class="icon-edit"></i>') . ' ' . anchor("produto/excluir/$linha->PRO_ID", '<i class="icon-trash"></i>') . '<br>' . anchor("produto/exibir/$linha->PRO_ID", '<i class="icon-list-alt"></i>') . ' ' . anchor("produto/imagem/$linha->PRO_ID", '<i class="icon-picture"></i>'));
            }

            $tmpl = array('table_open' => '<table class="table table-hover">');
            $this->table->set_template($tmpl);

            echo $this->table->generate();
        }
        ?>