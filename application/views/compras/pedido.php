<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-5"><label>FORNECEDOR</label><input type="text" name="PES_NOME" value="<?php echo $cliente->PES_NOME ?>" disabled /></div>
        <div class="col-sm-3"><label>DATA</label><input type="text"
                                                        value="<?php echo isset($pedido->PEDIDO_DATA) ? date("d/m/Y - H:i:s", strtotime($pedido->PEDIDO_DATA)) : date("d/m/Y - h:i:s") ?>" disabled /></div>
        <div class="col-sm-2"><label>PEDIDO N.</label><input type="text" name="PEDIDO_ID" id="IdPed" value="<?php echo $IdPed ?>" disabled /></div>
        <div class="col-sm-2"><br>
            <?php echo anchor('pedido/Delete/' . $IdPed . '/compras', 'Excluir', 'class="btn btn-warning"'); ?>
            <?php echo anchor('compras/fecha/' . $IdPed, 'Fechar', 'class="btn btn-primary" data-toggle="modal" data-target="#Modal"'); ?></div>
    </div>
</div>
<div class="well">
    <div class="row">
        <div class="col-sm-9">
            <input type="text" name="PRO_DESCRICAO" id="ProdutoDesc" autocomplete="off"/>
        </div>
        <div class="col-sm-3">
            <?php echo anchor('produto', 'Novo Produto', 'class="btn btn-success" data-toggle="modal" data-target="#Modal"'); ?>
        </div>
    </div>
</div>

<table class="table table-hover" data-sortable>
    <thead>
        <tr>
            <th width="5%"></th><th>DESCRIÇÃO (Disponibilidade)</th><th width="10%">QNT</th><th width="10%">VALOR</th><th width="5%">SUBTOTAL</th><th width="1%"></th>
        </tr>
    </thead>
    <tbody  class="lista-produto">
        <?php if ($LstProd <> NULL) { ?>
            <?php
            foreach ($LstProd as $linha) {
                $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_COMP);
                $estoq_atual = ($linha->PRO_TIPO == "s") ? "Serviço" : $linha->ESTOQ_ATUAL;
                ?>
                <tr id="<?php echo $linha->LIST_PED_ID ?>" itemref="<?php echo $linha->ESTOQ_ID ?>">
                    <td><?php echo $linha->PRO_ID ?></td>
                    <td><?php echo $linha->PRO_DESCRICAO ?> [ <?php echo $estoq_atual ?> ]</td>
                    <td><input type="number" id="quantidade" value="<?php echo $linha->LIST_PED_QNT ?>"></td>
                    <td><input type="text" class="valor ValorCompra" value="<?php echo $this->convert->em_real($linha->LIST_PED_COMP) ?>"></td>
                    <td><?php echo $this->convert->em_real($sub_total) ?></td>
                    <td><button type="button" class="close" id="excluir-item">&times;</button></td></tr>
                <tr>
                    <?php
                }
            }
            ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td><td><b>TOTAL :</b></td><td colspan="2"><b id="total"><?php echo $this->convert->em_real($Total->total); ?></b></td>
        </tr>
    </tfoot>
</table>      
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
            $.getJSON("pedido/AddProdCompra/" + $('#IdPed').val() + "/" + data.id, function(data) {
                drawTable(data);
            });
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
                dataType: "json",
                data: dados,
                success: function(response) {
                    drawTable(response);
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
                    dataType: "json",
                    data: dados,
                    success: function(response) {
                        drawTable(response);
                    }
                });
            }
        });

        // EXCLUIR PRODUTOS
        $(document).on('click', '#excluir-item', function() {
            ListPedido = $(this).parents('tr').attr('id');
            $.getJSON("pedido/removeritem/c/" + $('#IdPed').val() + "/" + ListPedido, function(data) {
                if (data.msn === undefined) {
                    $('#' + ListPedido).remove();
                    drawTable(data);
                } else {
                    alert(data.msg);
                }
            });
        });

        function drawTable(data) {
            if (data.msg !== undefined) {
                alert(data.msg);
            } else {
                Tamanho = (data.length - 1);
                for (var i = 0; i < Tamanho; i++) {
                    drawRow(data[i]);
                }
                $("#total").text(data[data.length - 1].Total);
            }
        }

        function drawRow(rowData) {
            lstPedId = rowData.LIST_PED_ID;
            if ($('#' + lstPedId).length) {
                RowId = $('#' + lstPedId).find("td");
                RowId.eq(4).text(FloatReal(rowData.LIST_PED_QNT * rowData.LIST_PED_PRECO));
            } else {
                $('.lista-produto').append(
                        $('<tr id=' + lstPedId + ' itemref=' + rowData.ESTOQ_ID + '>').append(
                        $('<td>').text(rowData.PRO_ID),
                        $('<td>').html(rowData.PRO_DESCRICAO),
                        $('<td>').html('<input type=number id=quantidade value=' + rowData.LIST_PED_QNT + '>'),
                        $('<td>').html('<input type=text  class="valor ValorCompra" value=' + FloatReal(rowData.LIST_PED_COMP) + '>'),
                        $('<td>').text(FloatReal(rowData.LIST_PED_QNT * rowData.LIST_PED_COMP)),
                        $('<td class="close" id="excluir-item">').html('&times;')
                        ));
            }
        }

    });
</script>