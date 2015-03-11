<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" id="NovoPedido" class="btn btn-default btn-sm">Nova</button>
                <button type="button" id="Finalizar" class="btn btn-default btn-sm" disabled>Finalizar</button>
                <a href="pedido/LmpLstEmAberto" id="InModel" class="btn btn-danger btn-sm">Limpa</a>
                <button type="button" id="EmAberto" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="EmAbList" role="menu">
                </ul>
            </div>
        </div>
        <div class="col-sm-7">
            <input type="text" name="PRO_DESCRICAO" id="ProdutoDesc" autocomplete="off" placeholder="Nome ou descrição ou codigo do produtos" disabled/>
        </div>
        <div class="col-sm-2">
            <input type="number" id="IdPed" class="IdPed" placeholder="Pedido" autocomplete="off"/>
        </div>
    </div>
</div>

<table class="table table-hover" data-sortable>
    <thead>
        <tr>
            <th width="5%">#</th><th>DESCRIÇÃO (Disponibilidade)</th><th width="7%">QNT</th><th width="10%">VALOR</th><th width="10%">SUBTOTAL</th><th width="1%"></th>
        </tr>
    </thead>
    <tbody class="lista-produto"></tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td><td><b>TOTAL :</b></td><td colspan="2"><b id="total"></b></td>
        </tr>
    </tfoot>
</table>

<script>
    $(document).ready(function() {

        // abri um novo pedido
        $(document).on("click", "#NovoPedido", function() {
            $.getJSON('venda/novo', function(data) {
                $('#IdPed').val(data);
                $('#ProdutoDesc').prop('disabled', false);
                $('#Finalizar').prop('disabled', false);
                $('#EmAbList').empty();
                $('.lista-produto').empty();
            });
        });
        // atualiza o pedido conforme digitado no compo Pedido
        $(document).on('change', '#IdPed', function() {
            $.getJSON("pedido/abrir/" + $('#IdPed').val(), function(data) {
                $('.lista-produto').empty();
                drawTable(data);
            });
            $('#ProdutoDesc').prop('disabled', false);
            $('#Finalizar').prop('disabled', false);
            return false;
        });
        //Finaliza o pedido
        $(document).on('click', '#Finalizar', function() {
            $("#modal-content").load("venda/pagamento/" + $("#IdPed").val());
            $('#modal').modal('show');
            return false;
        });
        //Lista o pedido em Aberto
        $(document).on('click', '#EmAberto', function() {
            $.getJSON('pedido/emaberto', function(data) {
                $('#EmAbList').empty();
                if (data == "") {
                    $('#EmAbList').append(' Não ha pedido em aberto ');
                } else {
                    $.each(data, function(key, value) {
                        descr = value.PEDIDO_ID + ' - ' + value.PEDIDO_DATA
                        if (value.PEDIDO_ID === $('#IdPed').val()) {
                            descr = '<u>' + descr + '</u>';
                        }
                        $('#EmAbList').append('<li><a href="' + value.PEDIDO_ID + '">' + descr + '</a></li>');

                    });
                }
            });
        });
        // Função do dropdown na lista em pedido em aberto. 
        $(document).on("click", "#EmAbList>li", function() {
            href = $(this).find("a").attr('href');
            $("#IdPed").val(href);
            $.getJSON("pedido/abrir/" + $('#IdPed').val(), function(data) {
                $('.lista-produto').empty();
                drawTable(data);
            });
            $('#ProdutoDesc').prop('disabled', false);
            $('#Finalizar').prop('disabled', false);
            $('.in,.open').removeClass('in open');
            return false;
        });


        // Auto completa produto
        var Produto = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {url: 'produto/pegaproduto?buscar=%QUERY'}
        });
        // inicialisa o autocomplete
        Produto.initialize();
        //Produto.clearPrefetchCache();

        // inicialisa typeahead UI
        $('#ProdutoDesc').typeahead(null, {
            source: Produto.ttAdapter()
        }).on('typeahead:selected', function(object, data) {
            $.getJSON("pedido/AddProdVenda/" + $('#IdPed').val() + "/" + data.id, function(data) {
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
            var dados = {Pedido: $('#IdPed').val(), ListPed: ListPedido, Estoq_id: Estoque_id, qtd: $(this).val()};
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
        // EXCLUIR PRODUTOS
        $(document).on('click', '#excluir-item', function() {
            ListPedido = $(this).parents('tr').attr('id');
            $.getJSON("pedido/removeritem/v/"+ $('#IdPed').val() + "/" + ListPedido, function(data) {
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
                        $('<td>').text(FloatReal(rowData.LIST_PED_PRECO)),
                        $('<td>').text(FloatReal(rowData.LIST_PED_QNT * rowData.LIST_PED_PRECO)),
                        $('<td class="close" id="excluir-item">').html('&times;')
                        ));
            }
        }

    });

</script>