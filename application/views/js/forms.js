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

$(document).on("submit", '#upload_img', function() {
    $('#upload_img').ajaxForm({
        success: function(data) {
            $("#cadastro").html(data);
        }
    });
    return false;
});

$(document).on('change', 'form[name="grava"]', function() {
    $('button[type="submit"]').removeAttr("disabled");
    $("#mensagem").text("Atenção: Foi feita alterações nessa pagina, salve as alteracoes antes de sai.");
    $("#mensagem").show();
    $(".alert").hide();
});


$(document).on('change', 'select[id="estado"]', function() {
    estado = $(this).val();
    if (estado === '')
        return false;

    $.getJSON('endereco/pegacidades/' + estado, function(data) {
        var option = new Array();
        $.each(data, function(i, obj) {
            option[i] = document.createElement('option');
            $(option[i]).attr({value: obj.id});
            $(option[i]).append(obj.nome);
        });
        $('select[id="cidade"]').html(option);
    });
});

$(document).on('change', 'select[id="cidade"]', function() {
    bairro = $(this).val();
    if (bairro === '')
        return false;

    $.getJSON('endereco/pegabairros/' + bairro, function(data) {
        var option = new Array();
        $.each(data, function(i, obj) {
            option[i] = document.createElement('option');
            $(option[i]).attr({value: obj.id});
            $(option[i]).append(obj.nome);
        });
        $('select[id="bairro"]').html(option);
    });
});

$(document).on('change', 'select[id="bairro"]', function() {
    rua = $(this).val();
    if (rua === '')
        return false;

    $.getJSON('endereco/pegaruas/' + rua, function(data) {
        var option = new Array();
        $.each(data, function(i, obj) {
            option[i] = document.createElement('option');
            $(option[i]).attr({value: obj.id});
            $(option[i]).append(obj.nome);
        });
        $('select[id="rua"]').html(option);
    });
});
