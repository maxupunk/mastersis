<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-5"><label>FORNECEDOR</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>DATA</label><input type="text"
                                                        value="<?php echo isset($pedido->PEDIDO_DATA) ? date("d/m/Y - H:i:s", strtotime($pedido->PEDIDO_DATA)) : date("d/m/Y - h:i:s") ?>" disabled /></div>
        <div class="col-sm-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" id="IdPed" value="<?php echo $IdPed ?>" disabled /></div>
        <div class="col-sm-2"><br>
            <?php echo anchor('pedido/Delete/' . $IdPed . '/compras', 'Excluir', 'class="btn btn-warning"'); ?>
            <?php echo anchor('compras/fecha/' . $IdPed, 'Fechar', 'class="btn btn-primary" id="InModel"'); ?></div>
    </div>
</div>
<div class="well">
    <div class="row">
        <div class="col-sm-9">
            <input type="text" name="PRO_DESCRICAO" id="ProdutoDesc" autocomplete="off"/>
        </div>
        <div class="col-sm-3">
            <?php echo anchor('produto', 'Novo Produto', 'class="btn btn-success" id="InModel"'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" id="ListaPedido">
        <?php $this->load->view("telas/compras/lstitens"); ?> 
    </div>
</div>
<script>
    $(document).ready(function() {
        // Auto completa produto
        var Produto = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {url: 'produto/pegaproduto?buscar=%QUERY'}
        });
        // inicialisa o autocomplete
        Produto.initialize();

        // inicialisa typeahead UI
        $('#ProdutoDesc').typeahead(null, {
            source: Produto.ttAdapter()
        }).on('typeahead:selected', function(object, data) {
            $("#ListaPedido").load("pedido/AddProdCompra/" + $('#IdPed').val() + "/" + data.id);
            $(this).val('');
        });

        $("#ProdutoDesc").click(function() {
            $(this).val('');
        });

        // ALTERA QUATIDADE DE PRODUTOS
        $(document).on('change', '#quantidade', function() {
            ListPedido = $(this).parents('tr').attr('id');
            Estoque_id = $(this).parents('tr').attr('itemref');
            var dados = {Pedido: $('#IdPed').val(), ListPed: ListPedido, Estoq_id: Estoque_id, qtd: $(this).val(), tipo: "c"};
            $.ajax({
                type: "POST",
                url: "pedido/AtualizaQntItems",
                dataType: "html",
                data: dados,
                // enviado com sucesso
                success: function(response) {
                    $("#ListaPedido").html(response);
                }
            });
            return false;
        });

        // Altera o valor
        $(document).on("keypress", ".ValorCompra", function(event) {
            if (event.which === 13) {
                ListPedido = $(this).parents('tr').attr('id');
                Estoque_id = $(this).parents('tr').attr('itemref');
                var dados = {Pedido: $('#IdPed').val(), ListPed: ListPedido, Valor: $(this).val()};
                $.ajax({
                    type: "POST",
                    url: "financeiro/ValorCompra",
                    dataType: "html",
                    data: dados,
                    success: function(response) {
                        $("#ListaPedido").html(response);
                    }
                });
            }
        });

        // EXCLUIR PRODUTOS
        $(document).on('click', '#excluir-item', function() {
            ListPedido = $(this).parents('tr').attr('id');
            $("#ListaPedido").load("pedido/RemoverItemComp/" + $('#IdPed').val() + "/" + ListPedido);
        });
        
    });
</script>