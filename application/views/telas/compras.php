<div class="row">
    <div class="col-sm-12" id="compras-fornecedor">
        <?php
        if ($this->session->flashdata('mensagem'))
            echo '<div class="alert alert-info">' . $this->session->flashdata('mensagem') . '</div>';
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12" id="ComprasConteiner">

        <div class="well">
            <div class="row">
                <div class="col-sm-9">
                    <input type="text" name="PES_NOME" id="NomeFornecedor" autocomplete="off" placeholder="Para novas compras digite o nome do fornecedor" />
                </div>
                <div class="col-sm-3">
                    <?php echo anchor('pessoa', 'Add Fornecedor', 'class="btn btn-success" id="InModel"'); ?>
                    <?php echo anchor('compras/listar', 'Pendentes', 'class="btn btn-default" id="lista-compras"'); ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="<?php echo base_url('assets/js/pessoa.js'); ?>"></script>