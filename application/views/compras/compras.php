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
                    <?php echo anchor('pessoa', 'Nova pessoa', 'class="btn btn-success" data-toggle="modal" data-target="#Modal"'); ?>
                    <?php echo anchor('pedido/pendentes', 'Pendentes', 'class="btn btn-default" id="lista-compras"'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12" id="ComprasConteiner"></div>

</div>
<script>
    $(document).ready(function () {
        // aplica as configuração do autocomplete
        var NomeDoFornecedor = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: 'pessoa/pegapessoa?buscar=%QUERY',
                wildcard: '%QUERY'
            }
        });
        // inicializa typeahead UI
        $('#NomeFornecedor').typeahead(null, {
            display: 'value',
            source: NomeDoFornecedor
        }).on('typeahead:selected typeahead:autocompleted', function (object, data) {
            $("#ComprasConteiner").load("compras/abrir/" + data.id);
        });
        // lista todas as compras
        $(document).on('click', '#lista-compras', function () {
            $("#ComprasConteiner").load($(this).attr('href'));
            return false;
        });

        $(document).on("click", "#EditaPedido", function () {
            $("#ComprasConteiner").load($(this).attr('href'));
            return false;
        });

        ///////////////// comportamento despesa/abs
        $(document).on("submit", '#SalvaDespesas', function () {
            $.post($(this).attr('action'), $(this).serialize(), function (response) {
                $(".modal-content").html(response);
            });
            return false;
        });

        //////////////// comportamento Receber compras
        $(document).on("submit", '#SubmitPedido', function () {
            $.post($(this).attr('action'), $(this).serialize(), function (response) {
                $("#ComprasConteiner").load("pedido/pendentes");
                $(".modal-content").html(response);
            });
            return false;
        });

    });
</script>