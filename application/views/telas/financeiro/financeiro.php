<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified submenu-os" role="tablist" id="myTab">
            <li><a href="1">Contas a receber</a></li>
            <li><a href="2">Contas a pagar</a></li>
            <li><a href="3">Receita/Despesa avulsa</a></li>
            <li><a href="4">Baixa pagamento</a></li>
        </ul>

        <input type="hidden" id="MenuSelect" value="1">
        
        <table class="table table-hover">
            <thead>
            <th>DATA</th><th>CLIENTE</th><th>VALOR</th><th>OPÇÕES</th>
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

        // comportamento do menu
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
                        $('#LstEmOrdens').append('Não á ordens');
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