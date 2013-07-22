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
