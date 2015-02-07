<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified submenu-financeiro" role="tablist" id="myTab">
            <li><a href="1">Receitas</a></li>
            <li><a href="2">Despeza</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    Opções<span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="ordemservico/cadastrar" id="InModel">Nova Receita/Despesa</a></li>
                    <li><a href="ordemservico/gerenciaitens" id="Op-Os">Baixa</a></li>
                    <li><a href="ordemservico/imprimir" id="Op-Os">Imprimir</a></li>
                    <li><a href="ordemservico/editar" data-titulo="Editar" id="Op-Os">Editar</a></li>
                    <li><a href="ordemservico/excluir" id="Op-Os">Excluir ?</a></li>
                </ul>
            </li>
        </ul>

        <div class="well-sm"><input type="text" id="buscar" placeholder="Filtrar"></div>
        
        <table class="table table-hover" id="LstEmOrdens"></table>

    </div>
</div>
<script>
    $(document).ready(function() {
        setInterval(function() {
            CarregaJsonOs(MenuSelect)
        }, 3000);

        var json = {};
        var OsMenu = null;
        var MenuSelect = 1;

        // comportamento do Model apos fechar
        $(document).on('hidden.bs.modal', function() {
            CarregaJsonOs(MenuSelect);
        });

        // compoetamento do menu
        $(document).on('click', '.submenu-financeiro>li', function() {
            href = $(this).find("a").attr('href');
            $(this).siblings('li.active').removeClass("active");
            $(this).addClass("active");
            MenuSelect = href;
            CarregaJsonOs(href);
            $('.in,.open').removeClass('in open');
            return false;
        });

        // sistema de seleção das ordens
        $(document).on('click', '#LstEmOrdens tr', function() {
            $(this).siblings('tr.active').removeClass("active");
            $(this).addClass("active");
            OsMenu = $(this).children().first().text();
        });

        // comportamento do menu opções
        $(document).on('click', '#Op-Os', function() {
            if (OsMenu == null) {
                $("#modal-content").text("Você não selecionou uma Ordem de serviço!");
            } else {
                $("#modal-content").load($(this).attr('href') + "/" + OsMenu);
            }
            $('.modal-title').text($(this).text());
            $('.in,.open').removeClass('in open');
            $('#modal').modal('show');
            return false;
        });

        $(document).on('click', '.Model-Submit', function() {
            $('#modal-content > form').submit();
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
                    CarregaJsonOs(MenuSelect);
                }
            });
            return false;
        });
        // Carrega a lista de ordem das tabelas 
        function CarregaJsonOs(href) {
            $.getJSON("ordemservico/ordens/" + href, function(data) {
                if (!comparaArray(json, data)) {
                    $('#LstEmOrdens').empty();
                    if (data != "") {
                        $.each(data, function(key, value) {
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
                    OsMenu = null;
                }
            });
        }

        $("#buscar").keyup(function() {
            input = this;
            // Show only matching TR, hide rest of them
            $.each($("#LstEmOrdens").find("tr"), function() {
                if ($(this).text().toLowerCase().indexOf($(input).val().toLowerCase()) === -1) {
                    $(this).hide();
                    if ($(this).children().first().text() === OsMenu) {
                        $(this).siblings('tr.active').removeClass("active");
                        OsMenu = null;
                    }
                } else {
                    $(this).show();
                }
            });
        });

    });
</script>