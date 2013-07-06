        <?php
        #header("Pragma: no-cache"); 
        $this->table->set_heading('', '', 'DESCRIÇÃO', 'VALOR');

        foreach ($produtos as $linha) {
            setlocale(LC_MONETARY, 'pt_BR');
            $valor = money_format('%.2n', $linha->PRO_VAL_VEND);
            $icone = str_replace(".jpg", "_thumb.jpg", $linha->PRO_IMG);
            $this->table->add_row($linha->PRO_ID,"<img src=".APPPATH."views/produto_img/".$icone." >", $linha->PRO_DESCRICAO, $valor);
        }

        $tmpl = array('table_open' => '<table class="table table-hover">');
        $this->table->set_template($tmpl);

        echo $this->table->generate();
        ?>

        <div class="pagination" id="pagination">
            <ul>

                <? if ($paginacao) echo $paginacao; ?>

            </ul>
        </div>