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
    if ($(this).val().length > 1) {
        $("#resultado").load($(this).attr('url') + encodeURI($(this).val()));
    }
});

//Desbloquea atela preta e o aviso
$(document).on("click", "#screen", function() {
    $("#mensagem").hide();
    $('body').css({"overflow": "visible"});
    $("#screen").hide();
});


//
// Regras de carregamentos
//

$(document).ajaxStart(function() {
    $('body').css({"overflow": "hidden"});
    $("#mensagem").html("<img src='carregando.gif'>");
    $('#screen').show();
    $("#mensagem").show();
});

$(document).ajaxError(function(event, request, settings) {
    $("#mensagem").html("Erro ao carregar a pagina: " + settings.url);
});

$(document).ajaxSuccess(function(event, request, settings) {
    $('body').css({"overflow": "visible"});
    $("#mensagem").hide();
    $('#screen').hide();
});