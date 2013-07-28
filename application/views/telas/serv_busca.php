        <?php
        if (isset($_GET['buscar'])) {
            $busca = $_GET['buscar'];

            $query = $this->crud_model->buscar("SERVICOS",array('SERV_ID'=>$busca,'SERV_NOME'=>$busca))->result();

            $this->table->set_heading('COD', 'NOME', "OP's");

            foreach ($query as $linha) {

                $linha->SERV_ESTATUS == 'd' ? $estatus = '<strike>' . $linha->SERV_NOME . '</strike>' : $estatus = $linha->SERV_NOME;

                $this->table->add_row($linha->SERV_ID, $estatus, anchor("servico/editar/$linha->SERV_ID", '<span class="glyphicon glyphicon-edit"></i>') . ' ' . anchor("servico/excluir/$linha->SERV_ID", '<span class="glyphicon glyphicon-trash"></span>'));
            }

            $tmpl = array('table_open' => '<table class="table table-hover">');
            $this->table->set_template($tmpl);

            echo $this->table->generate();
        }
        ?>