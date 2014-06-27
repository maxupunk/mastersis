// aplica as configuração do autocomplete
var ListaProduto = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {url: 'produto/pegaproduto?buscar=%QUERY'}
});

// inicialisa o autocomplete
ListaProduto.initialize();

// inicialisa typeahead UI
$('#ProdutoServico').typeahead(null, {
    source: ListaProduto.ttAdapter()
}).on('typeahead:selected', function(object, data) {
    $("#ListaProduto").load("ordemservico/addproduto/" + $('#os_id').val() + "/" + data.id);
    $(this).val('');
});

$("#ProdutoServico").click(function() {
  $(this).val('');
});
// ALTERA QUATIDADE DE PRODUTOS
$(document).on('change', '#quantidade', function() {
    $("#ListaProduto").load("ordemservico/updproduto/" + $('#os_id').val() + "/" + $(this).attr('list_ped_id') + "/" + $(this).attr('id_estoque') + "/" + $(this).val());
});
// EXCLUIR PRODUTOS
$(document).on('click', '#excluir-item', function() {
    $("#ListaProduto").load("ordemservico/excluiritem/" + $('#os_id').val() + "/" + $(this).attr('list_ped_id'));
});
// Atualisa
$(document).on("click", "#atualiza-lista", function() {
    $("#ListaProduto").load("ordemservico/updlista/" + $('#os_id').val())
    return false;
});