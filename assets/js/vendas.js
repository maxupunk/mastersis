/*
 * MasterSis script de vendas
 * 
 */

//AUTOCOMPLETE PRODUTOS
var produto = $('#produto_venda').typeahead({
    name: 'produtos',
    minLength: 1,
    limit: 10,
    remote: {
        url: 'produto/pegaproduto?buscar=%QUERY'
    },
});
produto.on('typeahead:selected', function(evt, data) {
    $("#lista").load("venda/addproduto/" + $('input[name="PEDIDO_ID"]').val() + "/" + data.id);
    $(this).val('');
});
$("#produto_venda").focus();

// ALTERA QUATIDADE DE PRODUTOS
$(document).on('change', '#quantidade', function() {
    $("#lista").load("venda/atualizar/" + $('input[name="PEDIDO_ID"]').val() + "/" + $(this).attr('list_ped_id') + "/" + $(this).val());
});

// EXCLUIR PRODUTOS
$(document).on('click', '#excluir-produto', function() {
    $("#lista").load("venda/excluir/" + $('input[name="PEDIDO_ID"]').val() + "/" + $(this).attr('list_ped_id'));
});