<div class="row">
    <div class="col-sm-12">
        <input type="text" name="PRO_DESCRICAO" id="ProdutoServico" autocomplete="off" placeholder="Produto/Serviço"/>
        <input type="hidden" name="OS_ID" id="os_id" value="<?php echo $id_os ?>"/>
    </div>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th width="5%"></th><th>DESCRIÇÃO (Disponibilidade)</th><th width="11%">QNT</th><th width="10%">VALOR</th><th width="5%">SUBTOTAL</th><th width="1%"></th>
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
            $.getJSON("pedido/removeritem/" + $('#IdPed').val() + "/" + ListPedido, function(data) {
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
                //$('#' + lstPedId).parents("tr").find('input').val(rowData.LIST_PED_QNT);
            } else {
                $('.lista-produto').append(
                        $('<tr id=' + lstPedId + ' itemref=' + rowData.ESTOQ_ID + '>').append(
                        $('<td>').text(rowData.PRO_ID),
                        $('<td>').html(rowData.PRO_DESCRICAO),
                        $('<td>').html('<input type=number id=quantidade value=' + rowData.LIST_PED_QNT + '>'),
                        $('<td>').text(FloatReal(rowData.LIST_PED_PRECO)),
                        $('<td>').text(FloatReal(rowData.LIST_PED_QNT * rowData.LIST_PED_PRECO)),
                        $('<td class="close" id="excluir-item">').html('&times;')
                        ));
            }
        }
    });
</script>