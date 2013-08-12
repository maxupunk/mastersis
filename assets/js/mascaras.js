$('.data').mask('11/11/1111');
$('.tempo').mask('00:00:00');
$('.date_tempo').mask('99/99/9999 00:00:00');
$('.cep').mask('99999-999');
$('.fone').mask('(99)9999-9999');
$('.cpf-cnpj').mask('999.999.999-99', {reverse: true});
$('.valor').mask('000.000,00', {reverse: true});
$('.peso').mask('000000.000', {reverse: true});


// Jquery UI
$('.data').datepicker();

// Abas
$( "#tabs" ).tabs();