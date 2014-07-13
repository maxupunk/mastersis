/*
 * MasterSis script comportamento dos forms
 */

////////////////////////////////////////////////////////////////////////////////
// Aviso de alterações de dados
//

function ConfirmSair(on) {
    var message = "As mudanças deste formulário não foram salvas. \nSaindo desta página, todas as mudanças serão perdidas.";
    window.onbeforeunload = (on) ? function() {
        return message;
    } : null;
}

// ocuta alertas
$(document).on('click', '.alert', function() {
    $(this).hide();
});

// regra do ajax
$.ajaxSetup({
    cache: false,
    error: function(x, request, settings)
    {
        $('#modal').modal('show');
        $("#modal-content").html(x.responseText);
        $("#modal-content").append("Para mais informações: Sistema > Log de sistema");
    },
    xhrFields: {
        onprogress: function(e) {
            if (e.lengthComputable) {
                console.log(e.loaded / e.total * 100 + '%')
            }
        }
    },
    complete: function()
    {
        $(".carregando").hide();
    }
});
$(document).ajaxStart(function() {
    $(".carregando").show();
});


////////////////////////////////////////////////////////////////////////////////
// Ativador de mascaras
////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".valor", function() {
    $('.valor').mask('0.000.000.000,00', {reverse: true});
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
    $("#content-sub-menu").load($(this).attr('href'));
    return false;
});
// Menu do cadastro de endereço
$(document).on("click", "#MenuEndereco", function() {
    $("#endereco").load($(this).attr('href'));
    return false;
});

$(document).on("keyup", "#busca", function() {
    url = $(this).attr('itemref');
    valor = $(this).val();
    if (valor.length > 0 && url != "#") {
        $("#resultado").load(url + encodeURI(valor));
    }
});

$(document).on("click", ".submenu-cadastro>li", function() {
    href = $(this).find("a").attr('href');
    $(this).siblings('li.active').removeClass("active");
    $(this).addClass("active");
    $("#busca").attr("itemref", href + '/busca?buscar=');
    $("#content-sub-menu").load(href);
    $(".BordaCad").show();
    $("#busca").val("");
    return false;
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
            $("#content-sub-menu").html(response);
            ConfirmSair(false);
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
            $("#content-sub-menu").html(response);
        }
    });
    return false;
});

$(document).on('keypress', 'form[name="grava"]', function() {
    $(this).change(function() {
        $('button[type="submit"]').removeAttr("disabled");
        $(".alert").hide();
        ConfirmSair(true);
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
// aplica as configuração do autocomplete
var NomeDoCliente = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {url: 'pessoa/pegapessoa?buscar=%QUERY'}
});
// inicialisa o autocomplete
NomeDoCliente.initialize();

// inicialisa typeahead UI
$('#nome_pes').typeahead(null, {
    source: NomeDoCliente.ttAdapter()
}).on('typeahead:selected', function(object, data) {
    $("#venda").load("venda/cliente/" + data.id);
});
// NOVA VENDA
$(document).on("click", "#AbrirVenda", function() {
    $("#venda").load($(this).attr('href'));
    $("#ListaVenda").html('');
    return false;
});
// LISTAR VENDAS
$(document).on("click", "#MostraVendas", function() {
    $("#venda").load($(this).attr('href'));
    return false;
});
// PAGINAÇÃO DA LISTA DE PEDIDO
$(document).on("click", "#PagPedidos a", function() {
    $("#venda").load($(this).attr('href'));
    return false;
});
// INICIA A FINALIZAÇÃO DA VENDA
$(document).on('click', '#pagamento', function() {
    $("#modal-content").load($(this).attr('href') + "/" + $('input[name="PEDIDO_ID"]').val());
    $('#modal').modal('show');
    return false;
});
// CONCLUI A VENDA
$(document).on('click', '#finaliza-venda', function() {
    $("#modal-content").load("venda/fechapedido/" + $('input[name="PEDIDO_ID"]').val());
});
// FUNÇÃO PARA IMPRESÃO IN DIV
$(document).on('click', '#imprimir', function() {
    var extraCss = "assets/css/mastersis.css";
    var keepAttr = ["id", "class", "style"];
    var options = {mode: 'iframe', extraCss: extraCss, retainAttr: keepAttr};
    $('.impresao').printArea(options);
    return false;
});
// FINALIZA A ORDEM
$(document).on('click', '#finaliza-os', function() {
    $("#modal-content").load("ordemservico/entrega/" + $('#id_pedido').val());
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
// ORDEM DE SERVIÇO
////////////////////////////////////////////////////////////////////////////////
// NOVO SERVIÇO
$(document).on('click', '#NovoOs', function() {
    $("#modal-content").load('ordemservico/cadastrar');
    $('#modal').modal('show');
    return false;
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
            ConfirmSair(false);
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

////////////////////////////////////////////////////////////////////////////////
// COMPRAS
////////////////////////////////////////////////////////////////////////////////

// aplica as configuração do autocomplete
var NomeDoFornecedor = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {url: 'pessoa/pegapessoa?buscar=%QUERY'}
});
// inicialisa o autocomplete
NomeDoFornecedor.initialize();

// inicialisa typeahead UI
$('#NomeFornecedor').typeahead(null, {
    source: NomeDoFornecedor.ttAdapter()
}).on('typeahead:selected', function(object, data) {
    $("#ComprasConteiner").load("compras/abrir" + data.id);
});

$(document).on('click', '#lista-compras', function() {
    $("#ComprasConteiner").load($(this).attr('href'));
    return false;
});
// PAGINAÇÃO DA LISTA DE PEDIDO
$(document).on("click", "#PagPedidos a", function() {
    $("#ComprasConteiner").load($(this).attr('href'));
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