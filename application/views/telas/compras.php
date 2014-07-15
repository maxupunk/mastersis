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
                <div class="col-sm-10">
                    <input type="text" name="PES_NOME" id="NomeFornecedor" autocomplete="off" placeholder="Para novas compras digite o nome do fornecedor" />
                </div>
                <div class="col-sm-2">
                    <?php echo anchor('compras/listar', 'Compras Pendentes', 'class="btn btn-warning" id="lista-compras"'); ?>
                </div>
            </div>
        </div>

    </div>
</div>