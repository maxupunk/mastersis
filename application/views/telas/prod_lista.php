        <?php
       
        $this->table->set_heading('ID', '-', 'DESCRIÇÃO', 'VALOR');

        foreach ($produtos as $linha) {
            $this->table->add_row($linha->PRO_ID,"<img src=".base_url('produto')."/mostra_img?id=".$linha->PRO_ID."' height='100' width='120'>", $linha->PRO_DESCRICAO, $linha->PRO_VAL_VEND);
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
<?php
function to_img($dados=NULL){
    if ($dados=NULL):
        return;
    else:
        header("Content-type: image/jpeg"); 
        return $dados;
    endif;
    
}