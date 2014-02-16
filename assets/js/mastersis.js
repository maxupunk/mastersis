/*
 * MasterSis script comportamento dos forms
 */

// minha função de debuga objeto

var alteracao = false;

////////////////////////////////////////////////////////////////////////////////
// Aviso de alterações de dados
//
$(window).on('beforeunload', function() {
    if (alteracao == true) {
        return "As mudanças deste formulário não foram salvas.\n\
        Saindo desta página, todas as mudanças serão perdidas.";
    }
});

$(document).on('click', '.alert', function() {
    $(this).hide();
});

$('.TooltipMenu').tooltip();


////////////////////////////////////////////////////////////////////////////////
// Ativador de mascaras
//
$(document).on("click", ".valor", function() {
    $('.valor').mask('0.000.000.000,00', {reverse: true});
    return false;
});
////////////////////////////////////////////////////////////////////////////////
// Regras de carregamentos
//
$(document).ajaxStart(function() {
    $("#modal-ajax-content").html("Aguarde carregando..."); //<img src='assets/img/carregando.gif'>
    $('#modal-ajax').modal('show');
});

$(document).ajaxError(function(event, request, settings) {
    $("#modal-ajax-content").html(request.responseText);
    $("#modal-ajax-content").append(settings.url);
});

$(document).ajaxSuccess(function() {
    $('#modal-ajax').modal('hide');
});


//
// Submenu abrir no corpo
//
$(document).on("click", ".nocorpo", function() {
    $("#corpo").load($(this).attr('href'));
    return false;
});

//
// MasterSis script do CRUD
//
$(document).on("click", "#resultado a, #pagination a", function() {
    $("#cadastro").load($(this).attr('href'));
    return false;
});

$(document).on("click", "#SubMenu", function() {
    $("#cadastro").load($(this).attr('url')+'/cadastrar');
    $("#busca").attr("url",$(this).attr('url-busca')+'/busca?buscar=');
    $(".active").attr("class","");
    $(this).attr("class","active");
    $(".BordaCad").show();
    return false;
});

$(document).on("click", "#MenuInterno", function() {
    $("#cadastro").load($(this).attr('url'));
    return false;
});

$(document).on("keyup", "#busca", function() {
    if ($(this).val().length > 0) {
        $("#resultado").load($(this).attr('url') + encodeURI($(this).val()));
    }
});

////////////////////////////////////////////////////////////////////////////////
// Comportamento dos formulario do CRUD
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
            alteracao = false;
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
        $('.cpf-cnpj').mask('000.000.000-00', {reverse: true});
        $('.cpf-cnpj-label').html('CPF *:');
        $('input[name="PES_NASC_DATA"]').prop('disabled', false);
        $('input[name="nome_pes_PAI"]').prop('disabled', false);
        $('input[name="PES_NOME_MAE"]').prop('disabled', false);
    } else {
        $('.cpf-cnpj').mask('00.000.000.0000-00', {reverse: true});
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

////////////////////////////////////////////////////////////////////////////////
// SCRIPTS DE VENDAS
////////////////////////////////////////////////////////////////////////////////
//AUTOCOMPLETAR
var cliente = $('#nome_pes').typeahead({
    name: 'cliente',
    minLength: 1,
    limit: 10,
    remote: {
        url: 'pessoa/pegapessoa?buscar=%QUERY'
    },
});
cliente.on('typeahead:selected', function(evt, data) {
    $("#venda").load("venda/cliente/" + data.id);
});
$("#nome_pes").focus();
/////////
// NOVA VENDA
$(document).on("click", "#AbrirVenda", function() {
    $("#venda").load($(this).attr('href'));
    $("#lista").html('');
    return false;
});
/////////
// LISTAR VENDAS
/////////
$(document).on("click", "#ListarVenda", function() {
    $("#lista").load($(this).attr('href'));
    return false;
});
//
// PAGINAÇÃO DA LISTA DE PEDIDO
//
$(document).on("click", "#PagPedidos a", function() {
    $("#lista").load($(this).attr('href'));
    return false;
});

////////////////////////


////////////////////////////////////////////////////////////////////////////////
// AUTOCOMPLETE USUARIO
////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '#pessoa', function() {
    var usuario = $('#pessoa').typeahead({
        name: 'pessoa',
        minLength: 1,
        limit: 10,
        remote: {
            url: 'pessoa/pegapessoa?buscar=%QUERY'
        },
    });
    usuario.on('typeahead:selected', function(evt, data) {
        $("#PES_ID").val(data.id);
    });
    usuario.on('typeahead:autocompleted', function(evt, data) {
        $("#PES_ID").val(data.id);
    });
    $("#pessoa").focus();
});

////////////////////////////////////////////////////////////////////////////////
// AUTOCOMPLETE PRODUTOS
////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '#produto_venda', function() {
    var produto = $('#produto_venda').typeahead({
        name: 'produtos',
        minLength: 1,
        limit: 10,
        remote: {
            url: 'produto/pegaproduto?buscar=%QUERY'
        },
    });
    produto.on('typeahead:selected', function(evt, data) {
        $("#lista").load("venda/addproduto/" + $('input[name="PEDIDO_ID"]').val() + "/" + data.id);
        $(this).val('');
    });
    $(this).val('');
    $("#produto_venda").focus();
});

////////////////////////////////////////////////////////////////////////////////
// Menu permicoes
////////////////////////////////////////////////////////////////////////////////
// autocomplete usuario
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

// Selecione uma permisão
$(document).on('change', '#permissao', function() {
    if ($(this).is(':checked') == true) {
        $("#retorno").load('permissoes/inserir/' + $("#id_usuario").val() + '/' + $(this).val());
        return false;
    } else {
        $("#retorno").load('permissoes/retirar/' + $("#id_usuario").val() + '/' + $(this).val());
        return false;
    }

});
// marca e/ou desmarca todoas as permisoes
$(document).on('click', '#selec-all-permi', function() {
    if ($("#selec-all-permi").is(':checked')) {
        $(".selecao").each(function() {
            $(this).prop("checked", true);
            $("#retorno").load('permissoes/inserir/' + $("#id_usuario").val() + '/' + $(this).val());
        });
    } else {
        $(".selecao").each(function() {
            $(this).prop("checked", false);
            $("#retorno").load('permissoes/retirar/' + $("#id_usuario").val() + '/' + $(this).val());
        });
    }
});
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// VENDAS
////////////////////////////////////////////////////////////////////////////////
// ALTERA QUATIDADE DE PRODUTOS
$(document).on('change', '#quantidade', function() {
    $("#lista").load("venda/atualizar/" + $('input[name="PEDIDO_ID"]').val() + "/" + $(this).attr('list_ped_id') + "/" + $(this).attr('id_estoque') + "/" + $(this).val());
});
// EXCLUIR PRODUTOS
$(document).on('click', '#excluir-item', function() {
    $("#lista").load("venda/excluiritem/" + $('input[name="PEDIDO_ID"]').val() + "/" + $(this).attr('list_ped_id'));
});
//  INICIA A FINALIZAÇÃO DA VENDA
$(document).on('click', '#pagamento', function() {
    $("#modal-content").load($(this).attr('url') + "/" + $('input[name="PEDIDO_ID"]').val());
    $('#modal').modal('show');
});
// CONCLUI A VENDA
$(document).on('click', '#finaliza-venda', function() {
    $("#modal-content").load("venda/fechapedido/" + $('input[name="PEDIDO_ID"]').val());
});
// IMPRESÃO DE RECIBO
$(document).on('click', '#imprimir', function() {
    $(".impresao").printThis({
        debug: false,
        importCSS: true,
        printContainer: true,
        loadCSS: "assets/css/mastersis.css",
        pageTitle: "IMPRESSAO DE RECIBO",
        removeInline: false
    });
});
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
// ORDEM DE SERVIÇO
////////////////////////////////////////////////////////////////////////////////

// NOVO SERVIÇO
$(document).on('click', '#NovoOs', function() {
    $("#modal-content").load('ordemservico/cadastrar');
    $('#modal').modal('show');
});

// GRAVA OS - FORMULARIO
$(document).on("submit", 'form[name="GravaOs"]', function() {
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: "html",
        data: $(this).serialize(),
        // enviado com sucesso
        success: function(response) {
            $("#modal-content").html(response);
            alteracao = false;
        }
    });
    return false;
});

// DETAHLES DO OS
$(document).on('click', '#LinkOS', function() {
    $("#modal-content").load($(this).attr('href'));
    $('#modal').modal('show');
    return false;
});


//
// Ferramenta de debuga objetos
//
function printObject(o) {
    var out = '';
    for (var p in o) {
        out += p + ': ' + o[p] + '\n';
    }
    console.log(out);
}