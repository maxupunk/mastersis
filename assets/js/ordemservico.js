$(document).ready(function () {

    setInterval(function () {
        CarregaJson(MenuSelect);
    }, 3000);

    var json = {};
    var idSelect = 1;
    var MenuSelect = 1;

    CarregaJson(MenuSelect);

    // comportamento do Model apos fechar
    $(document).on('hidden.bs.modal', function () {
        CarregaJson(MenuSelect);
    });
    // compoetamento do menu
    $(document).on('click', '.submenu-os>li', function () {
        href = $(this).find("a").attr('href');
        $(this).tab('show');
        MenuSelect = href;
        CarregaJson(href);
        return false;
    });
    // sistema de seleção das ordens
    $(document).on('click', '#LstEmOrdens tr', function () {
        $(this).siblings('tr.active').removeClass("active");
        $(this).addClass("active");
        idSelect = $(this).children().first().text();
    });
    // comportamento do menu opções
    $(document).on('click', '#Opcao', function () {
        if (idSelect === null) {
            MensagemModal("Você não selecionou um item!");
        } else {
            $('#Modal').modal({remote: $(this).attr('href') + "/" + idSelect})
        }
        return false;
    });
    // comportamento dos formularios
    $(document).on("submit", '#SubmitAjax', function () {
        $.post($(this).attr('action'), $(this).serialize(), function (response) {
            $("#Modal .modal-content").html(response);
            CarregaJson(MenuSelect);
        });
        return false;
    });
    // Carrega a lista de ordem das tabelas 
    function CarregaJson(href) {
        $.getJSON("ordemservico/ordens/" + href, function (data) {
            if (!comparaArray(json, data)) {
                $('#LstEmOrdens').empty();
                if (data !== "") {
                    $.each(data, function (key, value) {
                        $('#LstEmOrdens').append(
                                $('<tr>').append(
                                $('<td>').text(value.OS_ID),
                                $('<td>').text(value.PES_NOME),
                                $('<td>').text(value.OS_EQUIPAMENT),
                                $('<td>').text(value.OS_DATA_ENT)
                                ));
                    });
                }
                json = data;
                idSelect = null;
                $('.nav-tabs a[href="' + MenuSelect + '"]').tab('show');
            }
        });
    }

    $("#buscar").keyup(function () {
        input = $(this);
        // Mostra somente a TR, ocuta o restante
        $.each($("#LstEmOrdens").find("tr"), function () {
            if ($(this).text().toLowerCase().indexOf(input.val().toLowerCase()) === -1) {
                $(this).hide();
                if ($(this).children().first().text() === idSelect) {
                    $(this).removeClass("active");
                    idSelect = null;
                }
            } else {
                $(this).show();
            }
        });
    });

    ////////////////////////////////////
    // Gerenciar itens
    ///////////////////////////////////

    // aplica as configuração do autocomplete
    var ListaProduto = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: 'produto/pegaproduto/os?buscar=%QUERY',
            wildcard: '%QUERY'
        }
    });
    // inicialisa typeahead UI
    $('#ProdutoServico').typeahead(null, {
        display: 'value',
        source: ListaProduto
    }).on('typeahead:selected typeahead:autocompleted', function (object, data) {
        $.getJSON("pedido/AddProdOs/" + idSelect + "/" + data.id, function (data) {
            AddGrcIten(data);
            $("#ProdutoServico").val('');
        });
    });

    // ALTERA QUATIDADE DE PRODUTOS
    $(document).on('change', '#quantidade', function () {
        ListPedido = $(this).parents('tr').attr('id');
        var dados = {Os: idSelect, ListPed: ListPedido, qtd: $(this).val()};
        $.ajax({
            type: "POST",
            url: "pedido/AtualizaQntItemOs",
            dataType: "json",
            data: dados,
            success: function (response) {
                AddGrcIten(response);
            }
        });
        return false;
    });
    // EXCLUIR PRODUTOS
    $(document).on('click', '#excluir-item', function () {
        ListPedido = $(this).parents('tr').attr('id');
        $.getJSON("pedido/RemoverItemOs/" + idSelect + "/" + ListPedido, function (data) {
            if (!data.msn) {
                $('#' + ListPedido).remove();
                $("#total").text(data.Total);
            } else {
                alert(data.msg);
            }
        });
    });
    // Gerenciar itens
    $('#ModalGrcItens').on('show.bs.modal', function (event) {
        if (idSelect === null) {
            MensagemModal('Você não selecionou um item!');
            return false;
        } else {
            $('.lista-produto').empty();
            $.get("pedido/AbrirLstProdutoOS/" + idSelect, function (data) {
                AddGrcIten(data);
            });
        }
    });

    function AddGrcIten(data) {
        if (data.msg !== undefined) {
            alert(data.msg);
        } else {
            Total = data.pop();
            $("#total").text(Total.Total);
            $.each(data, function (key, value) {
                lstPedId = value.LIST_PED_ID;
                if ($('#' + lstPedId).length) {
                    RowId = $('#' + lstPedId).find("td");
                    RowId.eq(4).text(FloatReal(value.LIST_PED_QNT * value.LIST_PED_PRECO));
                } else {
                    $('.lista-produto').append(
                            $('<tr id=' + lstPedId + '>').append(
                            $('<td>').text(value.PRO_ID),
                            $('<td>').html(value.PRO_DESCRICAO),
                            $('<td>').html('<input type=number id=quantidade value=' + value.LIST_PED_QNT + '>'),
                            $('<td>').text(FloatReal(value.LIST_PED_PRECO)),
                            $('<td>').text(FloatReal(value.LIST_PED_QNT * value.LIST_PED_PRECO)),
                            $('<td class="close" id="excluir-item">').html('&times;')
                            ));
                }
            });
        }
    }
});
