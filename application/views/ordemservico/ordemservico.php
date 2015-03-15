<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified submenu-os" role="tablist" id="myTab">
            <li><a href="1">Em Abertas</a></li>
            <li><a href="2">Pendente</a></li>
            <li><a href="3">Cocluida</a></li>
            <li><a href="4">Entregue</a></li>
        </ul>
        <div class="row">
            <div class="col-sm-9 espacamento">
                <div class="btn-group btn-group-sm btn-group-justified" role="group">
                    <a href="ordemservico/cadastrar" class="btn btn-link" id="InModel">
                    <span class="glyphicon glyphicon-plus"></span> Nova</a>
                    
                    <a href="ordemservico/gerenciaitens" class="btn btn-link" id="Op-Os">
                        <span class="glyphicon glyphicon-shopping-cart"></span> Itens</a>
                        
                    <a href="ordemservico/imprimir" class="btn btn-link" id="Op-Os">
                        <span class="glyphicon glyphicon-print"></span> Imprimir</a>
                        
                    <a href="ordemservico/editar" class="btn btn-link" id="Op-Os">
                        <span class="glyphicon glyphicon-edit"></span> Editar</a>
                        
                    <a href="ordemservico/excluir" class="btn btn-link" id="Op-Os">
                        <span class="glyphicon glyphicon-trash"></span> Excluir</a>
                        
                    <a href="ordemservico/entregar" class="btn btn-link" id="Op-Os">
                        <span class="glyphicon glyphicon-check"></span> Entregar</a>
                        
                    <a href="ordemservico/reabrir" class="btn btn-link" id="Op-Os">
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
    $(document).ready(function() {

        setInterval(function() {
            $('.nav-tabs a[href="' + MenuSelect + '"]').tab('show');
            CarregaJsonOs(MenuSelect);
        }, 3000);

        var json = {};
        var Menu = null;
        var MenuSelect = 1;

        // comportamento do Model apos fechar
        $(document).on('hidden.bs.modal', function() {
            CarregaJsonOs(MenuSelect);
        });

        // compoetamento do menu
        $(document).on('click', '.submenu-os>li', function() {
            href = $(this).find("a").attr('href');
            $(this).tab('show');
            MenuSelect = href;
            CarregaJsonOs(href);
            $('.in,.open').removeClass('in open');
            return false;
        });

        // sistema de seleção das ordens
        $(document).on('click', '#LstEmOrdens tr', function() {
            $(this).siblings('tr.active').removeClass("active");
            $(this).addClass("active");
            Menu = $(this).children().first().text();
        });

        // comportamento do menu opções
        $(document).on('click', '#Op-Os', function() {
            if (Menu == null) {
                $("#modal-content").text("Você não selecionou uma Ordem de serviço!");
            } else {
                $("#modal-content").load($(this).attr('href') + "/" + Menu);
            }
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
                    Menu = null;
                }
            });
        }

        $("#buscar").keyup(function() {
            input = $(this);
            // Show only matching TR, hide rest of them
            $.each($("#LstEmOrdens").find("tr"), function() {
                if ($(this).text().toLowerCase().indexOf(input.val().toLowerCase()) === -1) {
                    $(this).hide();
                    if ($(this).children().first().text() === Menu) {
                        $(this).removeClass("active");
                        Menu = null;
                    }
                } else {
                    $(this).show();
                }
            });
        });

    });
</script>