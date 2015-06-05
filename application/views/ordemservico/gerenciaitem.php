<div class="row">
    <div class="col-sm-12">
        <input type="text" name="PRO_DESCRICAO" id="ProdutoServico" autocomplete="off" placeholder="Produto/Serviço"/>
        <input type="hidden" name="OS_ID" id="os_id" value="<?php echo $id_os ?>"/>
    </div>
</div>

<table class="table table-hover" data-sortable>
    <thead>
        <tr>
            <th width="5%">#</th><th>DESCRIÇÃO (Disponibilidade)</th><th width="11%">QNT</th><th width="10%">VALOR</th><th width="8%">SUBTOTAL</th><th width="1%"></th>
        </tr>
    </thead>
    <tbody class="lista-produto"></tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td><td><b>TOTAL:</b></td><td colspan="2"><b id="total"></b></td>
        </tr>
    </tfoot>
</table>

<script>
    $(document).ready(function() {

        $.getJSON("pedido/AbrirLstProdutoOS/" + $('#os_id').val(), function(data) {
            drawTable(data);
        });

        // aplica as configuração do autocomplete
        var ListaProduto = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {url: 'produto/pegaproduto/os?buscar=%QUERY'}
        });

        // inicialisa o autocomplete
        ListaProduto.initialize();

        // inicialisa typeahead UI
        $('#ProdutoServico').typeahead(null, {
            source: ListaProduto.ttAdapter()
        }).on('typeahead:selected', function(object, data) {
            $.getJSON("pedido/AddProdOs/" + $('#os_id').val() + "/" + data.id, function(data) {
                drawTable(data);
            });
            $(this).val('');
        });

        $("#ProdutoServico").click(function() {
            $(this).val('');
        });

        // ALTERA QUATIDADE DE PRODUTOS
        $(document).on('change', '#quantidade', function() {
            ListPedido = $(this).parents('tr').attr('id');
            Estoque_id = $(this).parents('tr').attr('itemref');
            var dados = {Os: $('#os_id').val(), ListPed: ListPedido, Estoq_id: Estoque_id, qtd: $(this).val()};
            $.ajax({
                type: "POST",
                url: "pedido/AtualizaQntItemOs",
                dataType: "json",
                data: dados,
                success: function(response) {
                    drawTable(response);
                }
            });
            return false;
        });
        // EXCLUIR PRODUTOS
        $(document).on('click', '#excluir-item', function() {
            ListPedido = $(this).parents('tr').attr('id');
            $.getJSON("pedido/RemoverItemOs/" + $('#os_id').val() + "/" + ListPedido, function(data) {
                if (data.msn === undefined) {
                    $('#' + ListPedido).remove();
                } else {
                    alert(data.msg);
                }
            });
        });

        function drawTable(data) {
            if (data.msg !== undefined) {
                alert(data.msg);
            } else {
                $.each(data, function(key, value) {
                    if (value.Total) {
                        $("#total").text(value.Total);
                        return false;
                    }
                    lstPedId = value.LIST_PED_ID;
                    if ($('#' + lstPedId).length) {
                        RowId = $('#' + lstPedId).find("td");
                        RowId.eq(4).text(FloatReal(value.LIST_PED_QNT * value.LIST_PED_PRECO));
                    } else {
                        $('.lista-produto').append(
                                $('<tr id=' + lstPedId + ' itemref=' + value.ESTOQ_ID + '>').append(
                                $('<td>').text(value.PRO_ID),
                                $('<td>').html(value.PRO_DESCRICAO),
                                $('<td>').html('<input type=number id=quantidade value=' + value.LIST_PED_QNT + '>'),
                                $('<td>').text(FloatReal(value.LIST_PED_PRECO)),
                                $('<td>').text(FloatReal(value.LIST_PED_QNT * value.LIST_PED_PRECO)),
                                $('<td class="close" id="excluir-item">').html('&times;')
                                ));
                    }
                });
            }
        }

    });
</script>