$(document).ready(function() {
    $('form').change(function() {
        $('button[type="submit"]').removeAttr("disabled");
        $("#mensagem").text("Atenção: Foi feita alterações nessa pagina, salve as alteracoes antes de sai.");
        $("#mensagem").show();
        $(".alert").hide();
        
    });
});