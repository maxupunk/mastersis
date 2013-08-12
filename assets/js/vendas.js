/* 
 * MasterSis script de vendas
 */
$("#produto_venda").autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "produto/pegaproduto",
            dataType: "json",
            data: { buscar: request.term },
            success: function(data) {
                response($.map( data, function(item) {
                    return {
                        label: item.PRO_DESCRICAO,
                        value: item.PRO_DESCRICAO,
                        pro_id: item.PRO_ID
                    };
                }));
            }
        });
    },
    minLength: 1,
    select: function(event, ui) {
        //$('input[name="ID_PES"]').val(ui.item.pes_id);
        alert(ui.item.pro_id);
        //$("#venda").load("venda/abrir/"+ui.item.pes_id);
    },
});