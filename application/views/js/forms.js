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
            $("#cadastro").append("Ocoreu um erro na requisição! tente novamente mais tarde");
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
