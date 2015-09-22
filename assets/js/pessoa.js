$(document).ready(function() {
    var ListaUsuario = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: 'pessoa/pegapessoa?buscar=%QUERY',
            wildcard: '%QUERY'
        }
    });
    // inicialisa typeahead UI
    $('#pessoa').typeahead(null, {
        display: 'value',
        source: ListaUsuario
    }).on('typeahead:selected typeahead:autocompleted', function(object, data) {
        $("#PES_ID").val(data.id);
        $("#pessoa-selec").text(data.id + " - " + data.value);
    });
});