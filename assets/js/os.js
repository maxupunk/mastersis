// aplica as configuração do autocomplete
var ListaProduto = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {url: 'produto/pegaproduto?buscar=%QUERY'}
});

var ListaServico = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {url: 'servico/pegaproduto?buscar=%QUERY'}
});

// inicialisa o autocomplete
ListaProduto.initialize();
ListaServico.initialize();

// inicialisa typeahead UI
$('#ProdutoServico').typeahead(null, {
    source: ListaProduto.ttAdapter(),
    templates: {
        header: '<h4 class="titulo-busca-os">Produto</h3>'
    }
},
{
    source: ListaServico.ttAdapter(),
    templates: {
        header: '<h4 class="titulo-busca-os">Serviço</h3>'
    }
}).on('typeahead:selected', function(object, data) {
    $(this).val('');
});


function printObject(o) {
    var out = '';
    for (var p in o) {
        out += p + ': ' + o[p] + '\n';
    }
    console.log(out);
}