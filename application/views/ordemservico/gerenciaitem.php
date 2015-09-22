<div class="row">
    <div class="col-sm-12">
        <input type="text" name="PRO_DESCRICAO" id="ProdutoServico" autocomplete="off" placeholder="Produto/Serviço"/>
        <input type="hidden" name="OS_ID" id="os_id" value="<?php echo $id_os ?>"/>
    </div>
</div>

<table class="table table-hover" data-sortable>
    <thead>
        <tr>
            <th width="5%">#</th><th>DESCRIÇÃO (Disponibilidade)</th><th width="14%">QNT</th><th width="10%">VALOR</th><th width="8%">SUBTOTAL</th><th width="1%"></th>
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
    $(document).ready(function () {

        $.getJSON("pedido/AbrirLstProdutoOS/" + $('#os_id').val(), function (data) {
            drawTable(data);
        });

        // aplica as configuração do autocomplete
        var ListaProduto = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: 'produto/pegaproduto/os?buscar=%QUERY',
                wildcard: '%QUERY'
            }
        });
        // inicialisa typeahead UI
        $('#ProdutoServico').typeahead(null, {
            display: 'value',
            source: ListaProduto
        }).on('typeahead:selected typeahead:autocompleted', function (object, data) {
            $.getJSON("pedido/AddProdOs/" + $('#os_id').val() + "/" + data.id, function (data) {
                drawTable(data);
                $("#ProdutoServico").val('');
            });
        });

        function drawTable(data) {
            if (data.msg !== undefined) {
                alert(data.msg);
            } else {
                Total = data.pop();
                $("#total").text(Total.Total);
                $.each(data, function (key, value) {
                    lstPedId = value.LIST_PED_ID;
                    if ($('#' + lstPedId).length) {
                        RowId = $('#' + lstPedId).find("td");
                        RowId.eq(4).text(FloatReal(value.LIST_PED_QNT * value.LIST_PED_PRECO));
                    } else {
                        $('.lista-produto').append(
                                $('<tr id=' + lstPedId + '>').append(
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