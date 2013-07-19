<div class="row">
    <div class="span6" id="resultado">
        <?php
        if (isset($_GET['buscar'])) {
            $id_categoria = $_GET['buscar'];


            $query = $this->categoria_model->buscar("$id_categoria")->result();

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
    </div>
</div>