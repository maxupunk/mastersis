<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified submenu-financeiro" role="tablist">
            <li><a href="1">Receitas</a></li>
            <li><a href="2">Despeza</a></li>
        </ul>

        <div class="row espacamento">
            <div class="col-sm-7">
                <input type="text" id="buscar" placeholder="Buscar no servidor">
            </div>
            <div class="col-sm-5">
                <div class="btn-group-sm SubMenuBotao" role="group">
                    <a href="financeiro/novo" class="btn btn-default" id="InModel">Nova</a>
                    <button type="button" class="btn btn-default">Baixar</button>
                    <button type="button" class="btn btn-default">Detales</button>
                    <button type="button" class="btn btn-default">Imprimir</button>
                    <button type="button" class="btn btn-default">Editar</button>
                    <button type="button" class="btn btn-default">Excluir</button>
                </div>
            </div>
        </div>


        <table class="table table-hover">
            <tbody id="LstEmOrdens"></tbody>
        </table>


    </div>
</div>
<script>
    $(document).ready(function() {

        setInterval(function() {
            $('.nav-tabs a[href="' + MenuSelect + '"]').parents('li').addClass('active');
            CarregaJson(MenuSelect)
        }, 3000);

        var json = {};
        var Menu = null;
        var MenuSelect = 1;

        // comportamento do Model apos fechar
        $(document).on('hidden.bs.modal', function() {
            CarregaJson(MenuSelect);
        });

        // compoetamento do menu
        $(document).on('click', '.submenu-financeiro>li', function() {
            href = $(this).find("a").attr('href');
            $(this).tab('show');
            MenuSelect = href;
            CarregaJson(href);
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
            $('.modal-title').text($(this).text());
            $('.in,.open').removeClass('in open');
            $('#modal').modal('show');
            return false;
        });

        // comportamento dos formularios das ordems
        $(document).on("submit", '#finanSubmit', function() {
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                dataType: "html",
                data: $(this).serialize(),
                // enviado com sucesso
                success: function(response) {
                    $("#modal-content").html(response);
                    CarregaJson(MenuSelect);
                }
            });
            return false;
        });
        // Carrega a lista de ordem das tabelas 
        function CarregaJson(href) {
            $.getJSON("financeiro/ReceitaDespesaLst/" + href, function(data) {
                if (!comparaArray(json, data)) {
                    $('#LstEmOrdens').empty();
                    if (data != "") {
                        $.each(data, function(key, value) {
                            if (value.PES_NOME != null) {
                                Descricao = value.PES_NOME;
                            } else {
                                Descricao = value.DESREC_DESCR;
                            }
                            $('#LstEmOrdens').append(
                                    $('<tr>').append(
                                    $('<td>').text(value.DESREC_ID),
                                    $('<td>').text(Descricao),
                                    $('<td>').text(value.DESREC_VECIMENTO),
                                    $('<td>').text(FloatReal(value.DESREC_VALOR))
                                    ));
                        });
                    }
                    json = data;
                    Menu = null;
                }
            });
        }

        // Menu Novo
        $(document).on('change', 'select[name="ADICIONA"]', function() {
        $this = $('input[name="PED_OS_ID"]');
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
        
        $(document).on('change', 'select[name="DESCRE_ESTATUS"]', function() {
            $this = $('input[name="DESCRE_DATA_PG"]');
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


    });
</script>