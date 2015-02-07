$(document).ready(function() {
    $(".modal-footer").empty();
    $('.botoes').clone().appendTo(".modal-footer");
    $('#modal-content').find(".botoes").remove();
});