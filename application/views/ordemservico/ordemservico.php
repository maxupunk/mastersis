<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified submenu-os" role="tablist" id="myTab">
            <li><a href="1">Em Abertas</a></li>
            <li><a href="2">Pendente</a></li>
            <li><a href="3">Concluida</a></li>
            <li><a href="4">Entregue</a></li>
        </ul>
        <div class="row">
            <div class="col-sm-9 espacamento">
                <div class="btn-group btn-group-sm btn-group-justified" role="group">
                    <a href="ordemservico/cadastrar" class="btn btn-link" data-toggle="modal" data-target="#Modal">
                        <span class="glyphicon glyphicon-plus"></span> Nova</a>

                    <a href="ordemservico/gerenciaitens" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-shopping-cart"></span> Itens</a>

                    <a href="ordemservico/imprimir" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-print"></span> Imprimir</a>

                    <a href="ordemservico/editar" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-edit"></span> Editar</a>

                    <a href="ordemservico/excluir" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-trash"></span> Excluir</a>

                    <a href="ordemservico/entregar" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-check"></span> Entregar</a>

                    <a href="ordemservico/reabrir" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-open"></span> Reabrir</a>
                </div>
            </div>
            <div class="col-sm-3 espacamento">
                <input type="text" id="buscar" placeholder="Filtrar">
            </div>
        </div>

        <table class="table table-hover" id="LstEmOrdens"></table>

    </div>
</div>
<script>
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
                $("#Modal .modal-content").text("Você não selecionou um item!");
                $('#Modal').modal('show');
            } else {
                $('#Modal').modal({remote: $(this).attr('href') + "/" + idSelect})
            }
            return false;
        });

        // comportamento dos formularios
        $(document).on("submit", '#SubmitAjax', function () {
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                dataType: "html",
                data: $(this).serialize(),
                // enviado com sucesso
                success: function (response) {
                    $("#Modal .modal-content").html(response);
                    CarregaJson(MenuSelect);
                }
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
            // Show only matching TR, hide rest of them
            $.each($("#LstEmOrdens").find("tr"), function () {
                if ($(this).text().toLowerCase().indexOf(input.val().toLowerCase()) === -1) {
                    $(this).hide();
                    if ($(this).children().first().text() === Menu) {
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
        // ALTERA QUATIDADE DE PRODUTOS
        $(document).on('change', '#quantidade', function () {
            ListPedido = $(this).parents('tr').attr('id');
            var dados = {Os: $('#os_id').val(), ListPed: ListPedido, qtd: $(this).val()};
            $.ajax({
                type: "POST",
                url: "pedido/AtualizaQntItemOs",
                dataType: "json",
                data: dados,
                success: function (response) {
                    drawTable(response);
                }
            });
            return false;
        });
        // EXCLUIR PRODUTOS
        $(document).on('click', '#excluir-item', function () {
            ListPedido = $(this).parents('tr').attr('id');
            $.getJSON("pedido/RemoverItemOs/" + $('#os_id').val() + "/" + ListPedido, function (data) {
                if (data.msn === undefined) {
                    $('#' + ListPedido).remove();
                } else {
                    alert(data.msg);
                }
            });
        });


    });
</script>