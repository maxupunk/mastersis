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
