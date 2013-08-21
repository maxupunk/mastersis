/*
 *
 */

$(document).on('change', '#permissao', function() {
    if ($(this).is(':checked') == true) {
        $("#retorno").load('permissoes/inserir/' + $("#id_usuario").val() + '/' + $(this).val());
        return false;
    } else {
        $("#retorno").load('permissoes/retirar/' + $("#id_usuario").val() + '/' + $(this).val());
        return false;
    }

});

$("#checkAll").click(function() {
    if ($("#checkAll").is(':checked')) {
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