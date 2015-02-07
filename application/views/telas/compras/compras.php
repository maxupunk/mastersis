<div class="row">
    <div class="col-sm-12" id="compras-fornecedor">
        <?php
        if ($this->session->flashdata('mensagem'))
            echo '<div class="alert alert-info">' . $this->session->flashdata('mensagem') . '</div>';
        ?>
    </div>
</div>
<div class="row">


    <div class="well">
        <div class="row">
            <div class="col-sm-8">
                <input type="text" name="PES_NOME" id="NomeFornecedor" autocomplete="off" placeholder="Para novas compras digite o nome do fornecedor" />
            </div>
            <div class="col-sm-4">
                <div class="btn-group">
                    <?php echo anchor('pessoa', 'Novo', 'class="btn btn-success" id="InModel"'); ?>
                    <?php echo anchor('compras/listar', 'Pendentes', 'class="btn btn-default" id="lista-compras"'); ?>
                    <?php echo anchor('produto/preco', 'Ajuste de Preços', 'class="btn btn-default" id="lista-compras"'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12" id="ComprasConteiner"></div>

</div>
<script>
    $(document).ready(function() {
        // aplica as configuração do autocomplete
        var NomeDoFornecedor = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {url: 'pessoa/pegapessoa?buscar=%QUERY'}
        });
        // inicialisa o autocomplete
        NomeDoFornecedor.initialize();

        // inicialisa typeahead UI
        $('#NomeFornecedor').typeahead(null, {
            source: NomeDoFornecedor.ttAdapter()
        }).on('typeahead:selected', function(object, data) {
            $("#ComprasConteiner").load("compras/abrir/" + data.id);
        });
        // lista todas as compras
        $(document).on('click', '#lista-compras', function() {
            $("#ComprasConteiner").load($(this).attr('href'));
            return false;
        });
        // PAGINAÇÃO DA LISTA DE PEDIDO
        $(document).on("click", "#PagPedidos a", function() {
            $("#ComprasConteiner").load($(this).attr('href'));
            return false;
        });

        $(document).on("click", "#EditaPedido", function() {
            $("#ComprasConteiner").load($(this).attr('href'));
            return false;
        });

    });
</script>