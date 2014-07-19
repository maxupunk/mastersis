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
    $("#ListaPedido").load("pedido/AddProdOs/" + $('#os_id').val() + "/" + data.id);
    $(this).val('');
});

$("#ProdutoServico").click(function() {
  $(this).val('');
});
// ALTERA QUATIDADE DE PRODUTOS
$(document).on('change', '#quantidade', function() {
    var dados = {Os: $('#os_id').val(), ListPed: $(this).attr('ListPed'), Estoq: $(this).attr('Estoque'), qtd: $(this).val()};
    $.ajax({
        type: "POST",
        url: "pedido/UpdQntOs",
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
    $("#ListaPedido").load("pedido/DelItemOs/" + $('#os_id').val() + "/" + $(this).attr('ListPed'));
});
// Atualisa
$(document).on("click", "#atualiza-lista", function() {
    $("#ListaPedido").load("pedido/UpdLstOs/" + $('#os_id').val())
    return false;
});