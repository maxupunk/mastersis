$(document).on("submit", 'form[name="grava"]', function() {
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: "html",
        data: $(this).serialize(),
        // enviado com sucesso
        success: function(response) {
            $("#cadastro").html(response);
        },
        // quando houver erro
        error: function() {
            $("#cadastro").append("<p>- Ocoreu um erro na requisição! tente novamente mais tarde</p>");
        }
    });
    return false;
});

$(document).on("submit", '#upload_img', function() {
    $('#upload_img').ajaxForm({
        beforeSubmit: function() {
            $('#cadastro').append('Carregando...<br>');
        },
        success: function(data) {
            $("#cadastro").append(data);
            $("#img_botao").prop('disabled', true);
            $("#arq_select").prop('disabled', true);
        }
    });
    return false;
});
