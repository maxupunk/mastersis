/* 
 * MasterSis script comportamento dos forms
 */
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

$(document).on('change', 'form[name="grava"]', function() {
    $('button[type="submit"]').removeAttr("disabled");
    $("#mensagem").text("Atenção: Foi feita alterações nessa pagina, salve as alterações antes de sai.");
    $("#mensagem").show();
    $(".alert").hide();
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
});

$("#nome_pes").autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "pessoa/pegapessoa",
            dataType: "json",
            data: { buscar: request.term },
            success: function(data) {
                response($.map( data, function(item) {
                    return {
                        label: item.PES_NOME + " - " + item.PES_CPF_CNPJ,
                        value: item.PES_NOME,
                        pes_id: item.PES_ID
                    };
                }));
            }
        });
    },
    minLength: 1,
    select: function(event, ui) {
        //$('input[name="ID_PES"]').val(ui.item.pes_id);
        $("#venda").load("venda/abrir/"+ui.item.pes_id);
    },
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
    $("#mensagem").html("<img src='assets/img/carregando.gif'>");
    $('#screen').show();
    $("#mensagem").show();
});

$(document).ajaxError(function(settings) {
    $("#mensagem").html("Erro ao carregar a pagina: " + settings.url);
});

$(document).ajaxSuccess(function() {
    $("#mensagem").hide();
    $('#screen').hide();
});