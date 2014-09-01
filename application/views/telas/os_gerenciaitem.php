<div class="row">
    <div class="col-sm-12">
        <input type="text" name="PRO_DESCRICAO" id="ProdutoServico" autocomplete="off" placeholder="Produto/Serviço"/>
        <input type="hidden" name="OS_ID" id="os_id" value="<?php echo $id_os ?>"/>
    </div>
</div>

<div class="row"><br>
    <div class="col-sm-12" id="ListaPedido">
        <?php
        if ($ListaProduto <> NULL) {

            $this->table->set_heading('COD', 'DESCRIÇÃO', 'QNT', 'VALOR', 'SUBTOTAL');

            foreach ($ListaProduto as $linha) {
                $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
                $quantidade = '<input type="number" id="quantidade" min="1.00" step="1.00" ListPed="' . $linha->LIST_PED_ID . '" Estoque="' . $linha->ESTOQ_ID . '" value="' . $linha->LIST_PED_QNT . '">';
                $excluir = '<button type="button" class="close" id="excluir-item" ListPed="' . $linha->LIST_PED_ID . '">&times;</button>';
                $this->table->add_row($linha->PRO_ID, $linha->PRO_DESCRICAO, $quantidade, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total), $excluir);
            }

            $tmpl = array('table_open' => '<table class="lista-produto">');
            $this->table->set_template($tmpl);

            echo $this->table->generate();
        } else {
            echo "<p align='center'>Não foi usado produto(s)!</p>";
        }
        ?>

        <div class="col-sm-12 text-right">
            TOTAL : <?php echo $this->convert->em_real($total->total) ?>
        </div>

    </div>
</div>
<script src="<?php echo base_url('assets/js/os.js'); ?>"></script>