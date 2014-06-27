// Auto completa produto
var Produto = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {url: 'produto/pegaproduto?buscar=%QUERY'}
});
// inicialisa o autocomplete
Produto.initialize();

// inicialisa typeahead UI
$('#produto_venda').typeahead(null, {
    source: Produto.ttAdapter()
}).on('typeahead:selected', function(object, data) {
    $("#ListaVenda").load("venda/addproduto/" + $('#pedido_id').val() + "/" + data.id);
    $(this).val('');
});

$("#produto_venda").click(function() {
  $(this).val('');
});

$("#atualiza-exibir").click(function() {
  $("#ListaVenda").load("venda/atualizar/" + $('#pedido_id').val() );
  return false;
});
// ALTERA QUATIDADE DE PRODUTOS
$(document).on('change', '#quantidade', function() {
    $("#ListaVenda").load("venda/atualizar/" + $('input[name="PEDIDO_ID"]').val() + "/" + $(this).attr('list_ped_id') + "/" + $(this).attr('id_estoque') + "/" + $(this).val());
});
// EXCLUIR PRODUTOS
$(document).on('click', '#excluir-item', function() {
    $("#ListaVenda").load("venda/excluiritem/" + $('input[name="PEDIDO_ID"]').val() + "/" + $(this).attr('list_ped_id'));
});
// Atualisa
$(document).on("click", "#atualiza-pedido", function() {
    $("#ListaVenda").load("venda/updlista/" + $('#pedido_id').val())
    return false;
});