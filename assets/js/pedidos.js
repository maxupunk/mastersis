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
    $("#ListaPedido").load("pedido/AddProd/" + $('#pedido_id').val() + "/" + data.id);
    $(this).val('');
});

$("#ProdutoDesc").click(function() {
    $(this).val('');
});

// ALTERA QUATIDADE DE PRODUTOS
$(document).on('change', '#quantidade', function() {
    var dados = {Pedido: $('#pedido_id').val(), ListPed: $(this).attr('ListPed'), Estoq: $(this).attr('Estoque'), qtd: $(this).val(), tipo: $('#tipo').val()};
    $.ajax({
        type: "POST",
        url: "pedido/UpdQntPedido",
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
    $("#ListaPedido").load("pedido/DelItemPedido/" + $('#pedido_id').val() + "/" + $(this).attr('ListPed'));
});
// Atualisa
$(document).on("click", "#atualiza-pedido", function() {
    $("#ListaPedido").load("pedido/UpdLstPedido/" + $('#pedido_id').val())
    return false;
});

// Adiciona produto
$(document).on("submit", 'form[name="grava"]', function() {
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: "html",
        data: $(this).serialize(),
        // enviado com sucesso
        success: function(response) {
            $("#modal-content").html(response);
            ConfirmSair(false);
        }
    });
    return false;
});