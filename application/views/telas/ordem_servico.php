<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified submenu-os" role="tablist" id="myTab">
            <li><a href="1">Em Abertas</a></li>
            <li><a href="2">Pendente</a></li>
            <li><a href="3">Cocluida</a></li>
            <li><a href="4">Entregue</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    Opções<span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="ordemservico/cadastrar" id="InModel">Nova Ordem</a></li>
                    <li><a href="ordemservico/gerenciaitens" id="Op-Os">Gerenciar Itens/Serviços</a></li>
                    <li><a href="ordemservico/imprimir" id="Op-Os">Imprimir</a></li>
                    <li><a href="ordemservico/editar" id="Op-Os">Editar</a></li>
                    <li><a href="ordemservico/excluir" id="Op-Os">Apagar</a></li>
                    <li><a href="ordemservico/entregar" id="Op-Os">Entregar</a></li>
                    <li><a href="ordemservico/reabrir" id="Op-Os">Reabrir Ordem</a></li>
                </ul>
            </li>
        </ul>

        <input type="hidden" id="OsSelect" value="">
        <input type="hidden" id="MenuSelect" value="1">

        <table class="table table-hover">
            <thead>
            <th>COD</th><th>CLIENTE</th><th>EQUIPAMENTO</th><th>DATA DE ENTRADA</th>
            </thead>
            <tbody id="LstEmOrdens">
            </tbody>
        </table>

    </div>
</div>
<script>
    $(document).ready(function() {
        setInterval(function() {
            CarregaJsonOs($("#MenuSelect").val())
        }, 30000);

        var json = {};

        // comportamento do Model apos fechar
        $('#modal').on('hidden.bs.modal', function() {
                    CarregaJsonOs($("#MenuSelect").val());
        });

        // compoetamento do menu
        $(document).on('click', '.submenu-os>li', function() {
            href = $(this).find("a").attr('href');
            $(this).siblings('li.active').removeClass("active");
            $(this).addClass("active");
            $("#MenuSelect").val(href);
            CarregaJsonOs(href);
            $('.in,.open').removeClass('in open');
            return false;
        });

        // sistema de seleção das ordens
        $(document).on('click', '#LstEmOrdens tr', function() {
            $(this).siblings('tr.active').removeClass("active");
            $(this).addClass("active");
            $("#OsSelect").val($(this).children().first().text());
        });

        // comportamento do menu opções
        $(document).on('click', '#Op-Os', function() {
            if ($("#OsSelect").val() == "") {
                $("#modal-content").text("Você não selecionou uma Ordem de serviço!");
            } else {
                $("#modal-content").load($(this).attr('href') + "/" + $("#OsSelect").val());
            }
            $('.in,.open').removeClass('in open');
            $('#modal').modal('show');
            return false;
        });

        // comportamento dos formularios das ordems
        $(document).on("submit", '#OrdemServicos', function() {
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                dataType: "html",
                data: $(this).serialize(),
                // enviado com sucesso
                success: function(response) {
                    $("#modal-content").html(response);
                    CarregaJsonOs($("#MenuSelect").val());
                }
            });
            return false;
        });
        // Carrega a lista de ordem das tabelas 
        function CarregaJsonOs(href) {
            $.getJSON("ordemservico/ordens/" + href, function(data) {
                var items = [];
                if (!comparaArray(json, data)) {
                    $('#LstEmOrdens').empty();
                    if (data == "") {
                        $('#LstEmOrdens').append('Não ha compras em aberto');
                    } else {
                        $.each(data, function(key, value) {
                            items.push('<tr><td id="ID">' + value.OS_ID + '</td><td>' + value.PES_NOME + '</td><td>' + value.OS_EQUIPAMENT + '</td><td>' + value.OS_DATA_ENT + '</td></tr>');
                        });
                        $('#LstEmOrdens').append(items);
                    }
                    json = data;
                    $("#OsSelect").val("");
                }
            });
        }

    });
</script>