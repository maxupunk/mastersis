        <?php
        if (isset($_GET['buscar'])) {
            $busca = $_GET['buscar'];

            $query = $this->crud_model->buscar("CATEGORIA",array('CATE_ID'=>$busca,'CATE_NOME'=>$busca))->result();

            $this->table->set_heading('COD', 'NOME', "OP's");

            foreach ($query as $linha) {

                $linha->CATE_ESTATUS == 'd' ? $estatus = '<strike>' . $linha->CATE_NOME . '</strike>' : $estatus = $linha->CATE_NOME;

                $this->table->add_row($linha->CATE_ID, $estatus, anchor("categoria/editar/$linha->CATE_ID", '<i class="icon-edit"></i>') . ' ' . anchor("categoria/imagem/$linha->CATE_ID", '<i class="icon-picture"></i>'));
            }

            $tmpl = array('table_open' => '<table class="table table-hover">');
            $this->table->set_template($tmpl);

            echo $this->table->generate();
        }
        ?>