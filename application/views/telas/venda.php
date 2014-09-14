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

<div class="row">
    <div class="col-sm-12" id="ListaPedido">

    </div>
</div>
<script>
    $(document).ready(function() {

        var json = {};
        // abri um novo pedido
        $(document).on("click", "#NovoPedido", function() {
            $.getJSON('venda/novo', function(data) {
                $('#IdPed').val(data);
                $('#ProdutoDesc').prop('disabled', false);
                $('#Finalizar').prop('disabled', false);
                $('#EmAbList').empty();
            });
        });
        // atualiza o pedido conforme digitado no compo Pedido
        $(document).on('change', '#IdPed', function() {
            $("#ListaPedido").load("pedido/abrir/" + $('#IdPed').val());
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
                    $('#EmAbList').append('Não ha compras em aberto');
                }
                $.each(data, function(key, value) {
                    descr = value.PEDIDO_ID + ' - ' + value.PEDIDO_DATA
                    if (value.PEDIDO_ID === $('#IdPed').val()) {
                        descr = '<u>' + descr + '</u>';
                    }
                    $('#EmAbList').append('<li><a href="' + value.PEDIDO_ID + '">' + descr + '</a></li>');

                });
            });
        });
        // Função do dropdown na lista em pedido em aberto. 
        $(document).on("click", "#EmAbList>li", function() {
            href = $(this).find("a").attr('href');
            $("#IdPed").val(href);
            $("#ListaPedido").load("pedido/abrir/" + $('#IdPed').val());
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

        // inicialisa typeahead UI
        $('#ProdutoDesc').typeahead(null, {
            source: Produto.ttAdapter()
        }).on('typeahead:selected', function(object, data) {
            $("#ListaPedido").load("pedido/AddProdVenda/" + $('#IdPed').val() + "/" + data.id);
            $(this).val('');
        });

        $("#ProdutoDesc").click(function() {
            $(this).val('');
        });

        // ALTERA QUATIDADE DE PRODUTOS
        $(document).on('change', '#quantidade', function() {
            ListPedido = $(this).parents('tr').attr('itemid');
            Estoque_id = $(this).parents('tr').attr('itemref');
            var dados = {Pedido: $('#IdPed').val(), ListPed: ListPedido, Estoq_id: Estoque_id, qtd: $(this).val()};
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
        // EXCLUIR PRODUTOS
        $(document).on('click', '#excluir-item', function() {
            $("#ListaPedido").load("pedido/removeritem/" + $('#IdPed').val() + "/" + $(this).attr('ListPed'));
        });

    });

</script>