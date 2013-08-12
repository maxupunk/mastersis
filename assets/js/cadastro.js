/* 
 * MasterSis script do cadastro
 */
$(document).on("click", "#resultado a, #pagination a", function() {
    $("#cadastro").load($(this).attr('href'));
    return false;
});

$(document).on("click", "#sub_menu button", function() {
    $("#cadastro").load($(this).attr('url'));
    return false;
});

$(document).on("keyup", "#busca", function() {
    if ($(this).val().length > 0) {
        $("#resultado").load($(this).attr('url') + encodeURI($(this).val()));
    }
});