/*
 * MasterSis script comportamento dos forms
 */

////////////////////////////////////////////////////////////////////////////////
// Comportamento Geral
////////////////////////////////////////////////////////////////////////////////

$(document).ready(function() {

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
                    console.log(e.loaded / e.total * 100 + '%');
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

// In model
    $(document).on('click', '#InModel', function() {
        $('.modal-title').text($(this).text());
        $('.in,.open').removeClass('in open');
        $("#modal-content").load($(this).attr('href'));
        $('#modal').modal('show');
        return false;
    });

    $(document).on("submit", '#confirmacao', function() {
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            dataType: "html",
            data: $(this).serialize(),
            success: function(response) {
                $('#modal').modal('hide');
            }
        });
        return false;
    });


// Ativador de mascaras
    $(document).on("focus", "input", function() {
        $('.fone').mask('(00)0000-0000');
        $('.valor').mask('0.000.000.000,00', {reverse: true});
        $('.cpf').mask('000.000.000-00', {reverse: true});
        $('.cnpj').mask('00.000.000.0000-00', {reverse: true});
        $('.data').datepicker({
            format: "dd/mm/yyyy",
            orientation: "top auto",
            language: 'pt-BR',
            autoclose: true
        });

    });

// FUNÇÃO PARA IMPRESÃO IN DIV
    $(document).on('click', '#imprimir', function() {
        var extraCss = "assets/css/mastersis.css";
        var keepAttr = ["id", "class", "style"];
        var options = {mode: 'iframe', extraCss: extraCss, retainAttr: keepAttr};
        $('.impresao').printArea(options);
        return false;
    });

////////////////////////////////////////////////////////////////////////////////
// Scripts de cadastros
////////////////////////////////////////////////////////////////////////////////
    $(document).on("submit", 'form[name="grava"]', function() {
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            dataType: "html",
            data: $(this).serialize(),
            // enviado com sucesso
            success: function(response) {
                if ($("#modal-content").is(':visible')) {
                    $("#modal-content").html(response);
                } else {
                    $("#content-sub-menu").html(response);
                }
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
            $('#cpf-cnpj').attr("class", "cpf");
            $('.cpf-cnpj-label').html('CPF *:');
            $('input[name="PES_NASC_DATA"]').prop('disabled', false);
            $('input[name="PES_NOME_PAI"]').prop('disabled', false);
            $('input[name="PES_NOME_MAE"]').prop('disabled', false);
            $('input[name="PES_NASC_DATA"]').prop('required', true);
        } else {
            $('#cpf-cnpj').attr("class", "cnpj");
            $('.cpf-cnpj-label').html('CNPJ *:');
            $('input[name="PES_NASC_DATA"]').prop('disabled', true);
            $('input[name="PES_NOME_PAI"]').prop('disabled', true);
            $('input[name="PES_NOME_MAE"]').prop('disabled', true);
            $('input[name="PES_NASC_DATA"]').empty();
            $('input[name="PES_NOME_PAI"]').empty();
            $('input[name="PES_NOME_MAE"]').empty();
            $('input[name="PES_NASC_DATA"]').prop('required', false);
        }
        $(".cpf-cnpj").focus();
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
}); // Verifica se a pagina foi carregada.

///////////////////////////////////////////////////////////
// Funcões
///////////////////////////////////////////////////////////

function comparaArray(a1, a2) {
    return JSON.stringify(a1) == JSON.stringify(a2);
}
// Converte Float em Moeda real
function FloatReal(num) {
    valor = parseFloat(num);
    return valor.toFixed(2).replace(".", ",").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
}
// Aviso de alterações de dados
function ConfirmSair(on) {
    var message = "As mudanças deste formulário não foram salvas. \nSaindo desta página, todas as mudanças serão perdidas.";
    window.onbeforeunload = (on) ? function() {
        return message;
    } : null;
}
// Ferramenta de debuga objetos
function debug(o) {
    var out = '';
    for (var p in o) {
        out += p + ': ' + o[p] + '\n';
    }
    console.log(out);
}
