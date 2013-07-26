$(document).on("click", "#resultado a", function() {
    $("#cadastro").load($(this).attr('href'));
    return false;
});

$(document).on("click", "#sub_menu button", function() {
    $("#cadastro").load($(this).attr('url'));
    return false;
});

$(document).on("click", "#pagination a", function() {
    $("#cadastro").load($(this).attr('href'));
    return false;
});

$(document).on("keyup", "#busca", function() {
    if ($(this).val().length > 0) {
        $("#resultado").load($(this).attr('url') + encodeURI($(this).val()));
    }
});

//Desbloquea atela preta e o aviso
$(document).on("click", "#screen", function() {
    $("#mensagem").hide();
    $("#screen").hide();
});

//
// Regras de carregamentos
//

$(document).ajaxStart(function() {
    $("#mensagem").html("<img src='carregando.gif'>");
    $('#screen').show();
    $("#mensagem").show();
});

$(document).ajaxError(function(event, request, settings) {
    $("#mensagem").html("Erro ao carregar a pagina: " + settings.url);
});

$(document).ajaxSuccess(function(event, request, settings) {
    $("#mensagem").hide();
    $('#screen').hide();
});