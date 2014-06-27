<div class="row">
    <div class="col-sm-12" id="venda">
        <?php
        if ($this->session->flashdata('mensagem'))
            echo '<div class="alert alert-info">' . $this->session->flashdata('mensagem') . '</div>';
        ?>
        <div class="well">
            <input type="text" name="PES_NOME" id="nome_pes" autocomplete="off" placeholder="Nome do cliente" />
        </div>
    </div>
</div>
