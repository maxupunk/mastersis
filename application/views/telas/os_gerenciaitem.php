<div class="row">
    <div class="col-sm-12">
        <input type="text" name="PRO_DESCRICAO" id="ProdutoServico" autocomplete="off" placeholder="Produto/Serviço"/>
        <input type="hidden" name="OS_ID" id="os_id" value="<?php echo $id_os ?>"/>
    </div>
</div>

<div class="row"><br>
    <div class="col-sm-12" id="ListaPedido">
        <?php
        $this->load->view("telas/pedido_itens");
        ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/os.js'); ?>"></script>