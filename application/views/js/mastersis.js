$(document).ready(function() {
    // Busca
    $(".sub_menu1").click(function() {
        var href = $(this).attr('href');
        $("#direira").load(href);
        return false;
    });
    
    $("#busca_produto").keyup(function() {
      var value = $(this).val();
      $("#resultado").load("http://localhost/produto/exibirbusca?buscar=".value);
    })
    
    //$("form").submit(function() {
    //    $("#centro").load($(this).attr('action')+'?'+$(this).serialize());
    //    return false;
    //});
    $("form").submit(function() {
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            dataType: "html",
            data: $(this).serialize(),
            // enviado com sucesso
            success: function(response) {
                $("#esquerda").html(response);
            },
            // quando houver erro
            error: function() {
                $("#esquerda").append("<p>- Ocoreu um erro na requisição! tente novamente mais tarde</p>");
            }
        });
        return false;
    });
});
