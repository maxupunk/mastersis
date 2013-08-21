/*
 * MasterSis script comportamento dos forms
 */

// minha função de debuga objeto

var alteracao = false;

//
// Aviso de alterações de dados
//
$(window).on('beforeunload', function() {
    if (alteracao == true) {
        return "As mudanças deste formulário não foram salvas.\n\
        Saindo desta página, todas as mudanças serão perdidas.";
    }
});

//
// Regras de carregamentos
//
$(document).ajaxStart(function() {
    $("#mensagem").html("<img src='assets/img/carregando.gif'>");
    $('#screen').show();
    $("#mensagem").show();
});

$(document).ajaxError(function(event, request, settings) {
    $("#mensagem").html(request.responseText);
    $("#mensagem").append("<h4>" + settings.url + "</h4>");
});

$(document).ajaxSuccess(function() {
    $("#mensagem").hide();
    $('#screen').hide();
});

//
// FUNÇÃO DA POPUP DE MENSAGEM
//
var offset = $("#mensagem").offset();
$(window).scroll(function() {
    if ($(window).scrollTop() > offset.top) {
        $("#mensagem").stop().animate({
            marginTop: $(window).scrollTop(),
        }, 0);
    }
});

//
// MasterSis script do CRUD
//
$(document).on("click", "#resultado a, #pagination a", function() {
    $("#cadastro").load($(this).attr('href'));
    return false;
});

$(document).on("click", "#sub_menu button", function() {
    $("#cadastro").load($(this).attr('url'));
    return false;
});

$(document).on("keyup", "#busca", function() {
    if ($(this).val().length > 0) {
        $("#resultado").load($(this).attr('url') + encodeURI($(this).val()));
    }
});

//
// Tooltip do menu
//
$('.dropdown-toggle').tooltip()
//
//

$(document).on("submit", 'form[name="grava"]', function() {
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: "html",
        data: $(this).serialize(),
        // enviado com sucesso
        success: function(response) {
            $("#cadastro").html(response);
        }
    });
    return false;
});

$(document).on("submit", 'form[name="form-data"]', function() {
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $("#cadastro").html(response);
        }
    });
    return false;
});

$(document).on('keypress', 'form[name="grava"]', function() {
    $(this).change(function() {
        $('button[type="submit"]').removeAttr("disabled");
        $(".alert").hide();
        alteracao = true;
    });
});

$(document).on('change', 'select[name="ESTA_ID"]', function() {
    estado = $(this).val();
    if (estado == '')
        return false;

    $.getJSON('endereco/pegacidades/' + estado, function(data) {
        var option = new Array();
        $.each(data, function(i, obj) {
            option[i] = document.createElement('option');
            $(option[i]).attr({value: obj.CIDA_ID});
            $(option[i]).append(obj.CIDA_NOME);
        });
        $('select[name="CIDA_ID"]').html(option);
    });
});

$(document).on('change', 'select[name="CIDA_ID"]', function() {
    bairro = $(this).val();
    if (bairro == '')
        return false;

    $.getJSON('endereco/pegabairros/' + bairro, function(data) {
        var option = new Array();
        $.each(data, function(i, obj) {
            option[i] = document.createElement('option');
            $(option[i]).attr({value: obj.BAIRRO_ID});
            $(option[i]).append(obj.BAIRRO_NOME);
        });
        $('select[name="BAIRRO_ID"]').html(option);
    });
});

$(document).on('change', 'select[name="BAIRRO_ID"]', function() {
    rua = $(this).val();
    if (rua == '')
        return false;

    $.getJSON('endereco/pegaruas/' + rua, function(data) {
        var option = new Array();
        $.each(data, function(i, obj) {
            option[i] = document.createElement('option');
            $(option[i]).attr({value: obj.RUA_ID});
            $(option[i]).append(obj.RUA_NOME);
        });
        $('select[name="RUA_ID"]').html(option);
    });
});

$(document).on('change', 'select[name="PES_TIPO"]', function() {
    if ($(this).val() == "f") {
        $('.cpf-cnpj').mask('999.999.999-99', {reverse: true});
        $('.cpf-cnpj-label').html('CPF *:');
        $('input[name="PES_NASC_DATA"]').prop('disabled', false);
        $('input[name="PES_NOME_PAI"]').prop('disabled', false);
        $('input[name="PES_NOME_MAE"]').prop('disabled', false);
    } else {
        $('.cpf-cnpj').mask('99.999.999.9999-99', {reverse: true});
        $('.cpf-cnpj-label').html('CNPJ *:');
        $('input[name="PES_NASC_DATA"]').prop('disabled', true);
        $('input[name="PES_NOME_PAI"]').prop('disabled', true);
        $('input[name="PES_NOME_MAE"]').prop('disabled', true);
        $('input[name="PES_NASC_DATA"]').val('');
        $('input[name="PES_NOME_PAI"]').val('');
        $('input[name="PES_NOME_MAE"]').val('');
    }
    $(".cpf-cnpj").focus();
});

// autocomplete venda
var cliente = $('#nome_pes').typeahead({
    name: 'cliente',
    minLength: 1,
    limit: 10,
    remote: {
        url: 'pessoa/pegapessoa?buscar=%QUERY'
    },
});
cliente.on('typeahead:selected', function(evt, data) {
    $("#venda").load("venda/abrir/" + data.id);
});
$("#nome_pes").focus();
//
//


// autocomplete
var usuario = $('#usuario').typeahead({
    name: 'usuario',
    minLength: 1,
    limit: 10,
    remote: {
        url: 'usuario/pegausuario?buscar=%QUERY'
    },
});
usuario.on('typeahead:selected', function(evt, data) {
    $("#permissoes").load("permissoes/gerenciar/" + data.id);
});
$("#usuario").focus();
//
//

//
// Submenu abrir no corpo
//
$(document).on("click", ".nocorpo", function() {
    $("#corpo").load($(this).attr('href'));
    return false;
});

//Desbloquea atela preta e o aviso
$(document).on("click", "#screen", function() {
    $("#mensagem").hide();
    $("#screen").hide();
});

function printObject(o) {
    var out = '';
    for (var p in o) {
        out += p + ': ' + o[p] + '\n';
    }
    console.log(out);
}