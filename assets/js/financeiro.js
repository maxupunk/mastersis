var cacheRD = {};
var idSelecRD = null;

FiltroRecDes();

// comportamento do Model apos fechar
$(document).on('hidden.bs.modal', function () {
    FiltroRecDes();
});

// sistema de seleção a lista
$(document).on('click', '#TabelaRecDes tr', function () {
    $(this).siblings('tr.active').removeClass("active");
    $(this).addClass("active");
    idSelecRD = $(this).children().first().text();
});
// comportamento do menu opções
$(document).on('click', '#OpRD', function () {
    if (idSelecRD === null) {
        MensagemModal("Você não selecionou um item!");
    } else {
        $('#Modal').modal({remote: $(this).attr('href') + "/" + idSelecRD})
    }
    return false;
});
// comportamento dos formularios
$(document).on("submit", '#SubmitAjax', function () {
    $.post($(this).attr('action'), $(this).serialize(), function (response) {
        $("#Modal .modal-content").html(response);
        FiltroRecDes();
    });
    return false;
});
// Menu Novo
$(document).on('change', '#ADICIONA', function () {
    $this = $('#PED_OS_ID');
    if ($(this).val() > "1") {
        $this.prop('disabled', false);
        $this.prop('required', true);
        $this.focus();
    } else {
        $this.prop('disabled', true);
        $this.prop('required', false);
        $this.val(null);
    }
});

$(document).on('change', '#DESCRE_ESTATUS', function () {
    $this = $('#DESCRE_DATA_PG');
    if ($(this).val() === "pg") {
        $this.prop('disabled', false);
        $this.prop('required', true);
        $this.focus();
    } else {
        $this.prop('disabled', true);
        $this.prop('required', false);
        $this.val(null);
    }
});

$(document).on('keypress', '#busca', function () {
    if ($(this).val().length >= 3) {
        FiltroRecDes();
    }
});

$(document).on('change', '#estatus, #qtd, #natureza', function () {
    FiltroRecDes();
});


function FiltroRecDes() {
    var dados = {
        busca: $('#busca').val(),
        estatus: $('#estatus').val(),
        qtd: $('#qtd').val(),
        natureza: $('#natureza').val()
    };
    $.post('financeiro/filtro', dados, function (response) {
        AddTabelaRecDes(response);
    });
    return false;
}

function AddTabelaRecDes(data) {
    if (!comparaArray(cacheRD, data)) {
        $('#TabelaRecDes').empty();
        if (data !== "") {
            $.each(data, function (key, value) {
                $('#TabelaRecDes').append(
                        $('<tr>').append(
                        $('<td>').text(value.DESREC_ID),
                        $('<td>').text(value.PES_NOME),
                        $('<td>').text(Data(value.DESREC_VECIMENTO)),
                        $('<td>').text(FloatReal(value.DESREC_VALOR)),
                        $('<td>').text(value.DESCRE_ESTATUS)
                        ));
            });
        }
        cacheRD = data;
        idSelecRD = null;
    }
}
///////////////////////////////////////////////////////////////////////
// SCRIPT DO MENU PREÇO
///////////////////////////////////////////////////////////////////////
var id_estoque = null;

$('[data-toggle="tooltip"]').tooltip();

// Auto completa produto
var ProdutoPreco = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: 'produto/pegaproduto?buscar=%QUERY',
        wildcard: '%QUERY'
    }
});
// inicializa typeahead UI
$('#ProdutoPreco').typeahead(null, {
    display: 'value',
    source: ProdutoPreco
}).on('typeahead:selected typeahead:autocompleted', function (object, data) {
    $.getJSON("Financeiro/TodosDados/" + data.id, function (data) {
        id_estoque = data.ESTOQ_ID;
        $('.PrecoCusto').val(FloatReal(data.ESTOQ_CUSTO));
        $('.PrecoVenda').val(FloatReal(data.ESTOQ_PRECO));
        $('.Lucro').val(GetLucro(data.ESTOQ_CUSTO, data.ESTOQ_PRECO));
        $('.EstoqAtual').val(data.ESTOQ_ATUAL);
        $('.tipo option').removeAttr('selected')
                .filter('[value=' + data.PRO_TIPO + ']')
                .attr('selected', true);
        $('.estatus option').removeAttr('selected')
                .filter('[value=' + data.PRO_ESTATUS + ']')
                .attr('selected', true);
        $('.ProPeso').val(data.PRO_PESO);
        $('.PRO_CARAC_TEC').html(data.PRO_CARAC_TEC);
        $('.PrecoVenda, .PrecoCusto').removeClass("alert-success");
    });
});

$(document).on("keyup", ".PrecoCusto", function (event) {
    $('.Lucro').val(GetLucro($(this).val(), $('.PrecoVenda').val()));
    $(this).removeClass("alert-success");
    if (event.which === 13) {
        PrecoVC("financeiro/VlCstProduto", $(this))
        return false;
    }
});

$('#ProdutoPreco').click(function () {
    $(this).val('');
});

// Altera o valor
$(document).on("keyup", ".PrecoVenda", function (event) {
    $('.Lucro').val(GetLucro($('.PrecoCusto').val(), $(this).val()));
    $(this).removeClass("alert-success");
    if (event.which === 13) {
        PrecoVC("financeiro/VlVndProduto", $(this))
        return false;
    }
});

$(document).on("keyup", ".Lucro", function (event) {
    $('.PrecoVenda').val(SetLucro($('.PrecoCusto').val(), $(this).val()));
    $('.PrecoVenda').removeClass("alert-success");
    if (event.which === 13) {
        PrecoVC("financeiro/VlVndProduto", $('.PrecoVenda'));
        return false;
    }
});

function PrecoVC(url, botao) {
    var dados = {IdEstq: id_estoque, Valor: botao.val()};
    $.post(url, dados, function (retorno) {
        $('input').eq($('input').index(botao) + 1).focus();
        botao.addClass("alert-success");
    });
}
///////////////////////////////////////////////////////////////////////
// SCRIPT Forma de pagamento
///////////////////////////////////////////////////////////////////////
var cacheFPG = {};
var idSelecFPG = null;
var idFPG = null;

CarregarFPG();

$(document).on("click", ".AddFormPG", function () {
    var dados = {
        FPG_ID: idFPG,
        FPG_DESCR: $('.DescrFPG').val(),
        FPG_PARCE: $('.ParceFPT').val(),
        FPG_AJUSTE: $('.JurusFPG').val()
    };
    $.post('financeiro/GrcFormaPG', dados, function (retorno) {
        if (retorno) {
            MensagemModal(retorno);
        } else {
            $('.DescrFPG, .ParceFPT, .JurusFPG').val('');
            CarregarFPG();
        }
    });
    return false;
});

$(document).on("keyup", ".DescrFPG, .ParceFPT", function (event) {
    if (event.which === 13) {
        $('input').eq($('input').index($(this)) + 1).focus();
        return false;
    }
});

$(document).on("keyup", ".JurusFPG", function (event) {
    if (event.which === 13) {
        $('.AddFormPG').click();
        return false;
    }
});


// sistema de seleção a lista
$(document).on('click', '#TabelaFPG tr', function () {
    $(this).siblings('tr.active').removeClass("active");
    $(this).addClass("active");
    idSelecFPG = $(this).children().first().text();
});

// comportamento do menu opções
$(document).on('click', '#OpFPGEdit', function () {
    if (idSelecFPG === null) {
        MensagemModal("Você não selecionou um item!");
    } else {
        $.getJSON("financeiro/PegaFormaPG/" + idSelecFPG, function (data) {
            $('.DescrFPG').val(data.FPG_DESCR);
            $('.ParceFPT').val(data.FPG_PARCE);
            $('.JurusFPG').val(data.FPG_AJUSTE);
            idFPG = data.FPG_ID;
        });
    }
    return false;
});

// comportamento do menu opções
$(document).on('click', '#OpFPGAtDe', function () {
    if (idSelecFPG === null) {
        MensagemModal("Você não selecionou um item!");
    } else {
        $.getJSON("financeiro/AtiDesFormaPG/" + idSelecFPG, function (data) {
            CarregarFPG();
        });
    }
    return false;
});

function CarregarFPG() {
    $.getJSON("financeiro/LstFormaPGs", function (data) {
        AddTabelaFPG(data);
    });
}

function AddTabelaFPG(data) {
    if (!comparaArray(cacheFPG, data)) {
        $('#TabelaFPG').empty();
        if (data !== "") {
            $.each(data, function (key, value) {
                $('#TabelaFPG').append(
                        $('<tr>').append(
                        $('<td>').text(value.FPG_ID),
                        $('<td>').text(value.FPG_DESCR),
                        $('<td>').text(value.FPG_PARCE),
                        $('<td>').text(value.FPG_AJUSTE + '%'),
                        $('<td>').text(value.FPG_STATUS === 'a' ? 'Ativo' : 'Desativo')
                        ));
            });
        }
        cacheFPG = data;
        idSelecFPG = null;
    }
}

///////////////////////////////////////////////
//  SCRIPT MENU AVARIA
///////////////////////////////////////////////
var pro_id = null;
var idSelecAVARIA = null;

CarregarAvarias();

// Auto completa produto
var Produto = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: 'produto/pegaproduto?buscar=%QUERY',
        wildcard: '%QUERY'
    }
});
// inicialisa typeahead UI
$('#ProdutoDesc').typeahead(null, {
    display: 'value',
    source: Produto
}).on('typeahead:selected typeahead:autocompleted', function (object, data) {
    pro_id = data.id;
    $('input').eq($('input').index($(this)) + 1).focus();
    //return false;
});

// sistema de seleção a lista
$(document).on('click', '#TabelaAvaria tr', function () {
    $(this).siblings('tr.active').removeClass("active");
    $(this).addClass("active");
    idSelecAVARIA = $(this).children().first().text();
});

$(document).on("keypress", ".MotivoAvaria", function (event) {
    if (event.which === 13) {
        $('input').eq($('input').index($(this)) + 1).focus();
        return false;
    }
});

$(document).on("keypress", ".QntAvaria", function (event) {
    if (event.which === 13) {
        $('.AddAvaria').click();
        return false;
    }
});

$(document).on("click", ".AddAvaria", function () {
    var dados = {
        PRO_ID: pro_id,
        AVA_QNT: $('.QntAvaria').val(),
        AVA_MOTIVO: $('.MotivoAvaria').val()
    };
    $.post('financeiro/AddAvaria', dados, function (retorno) {
        $('#ProdutoDesc, .QntAvaria, .MotivoAvaria').val('');
        pro_id = null;
        CarregarAvarias();
        MensagemModal(retorno);
    });
    return false;
});

$(document).on("click", ".RmAvaria", function () {
    var dados = {AVA_ID: idSelecAVARIA};
    $.post('financeiro/RmAvaria', dados, function () {
        CarregarAvarias();
    });
});

function CarregarAvarias() {
    $.getJSON("financeiro/LstAvarias", function (data) {
        AddTabAvaria(data);
    });
}

function AddTabAvaria(data) {
    if (!comparaArray(cacheFPG, data)) {
        $('#TabelaAvaria').empty();
        if (data !== "") {
            $.each(data, function (key, value) {
                $('#TabelaAvaria').append(
                        $('<tr>').append(
                        $('<td>').text(value.AVA_ID),
                        $('<td>').text(value.PRO_DESCRICAO),
                        $('<td>').text(value.AVA_MOTIVO),
                        $('<td>').text(value.AVA_QNT),
                        $('<td>').text(value.USUARIO_APELIDO),
                        $('<td>').text(Data(value.AVA_DATA))
                        ));
            });
        }
        cacheAVARIA = data;
        idSelecAVARIA = null;
    }
}