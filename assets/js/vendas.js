/*
 * MasterSis script de vendas
 */

$('#produto_venda').typeahead({
    source: function(query, process) {
        $.ajax({
            url: "produto/pegaproduto",
            type: 'POST',
            data: {buscar: query},
            dataType: 'json',
            success: function(data) {
                produto = [];
                map = {};
                $.each(data, function(i, state) {
                    map[state.PRO_DESCRICAO] = state;
                    produto.push(state.PRO_DESCRICAO);
                });
                process(produto);
            }
        });
    },
    updater: function(item) {
        $("#lista").load("venda/addproduto/" + $('input[name="PEDIDO_ID"]').val() + "/" + map[item].PRO_ID);
        $(this).val('');
    },
    minLength: 1,
});

$(document).on('change', '#quantidade', function() {
    $("#lista").load("venda/atualizar/" + $('input[name="PEDIDO_ID"]').val() + "/" + $(this).attr('list_ped_id') + "/" + $(this).val());
});