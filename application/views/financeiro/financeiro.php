<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified submenu-financeiro" role="tablist">
            <li><a href="1">Receitas</a></li>
            <li><a href="2">Despeza</a></li>
        </ul>

        <div class="row">
            <div class="col-sm-6 espacamento">
                <div class="btn-group btn-group-justified" role="group">
                    <a href="financeiro/novo" class="btn btn-link" data-toggle="modal" data-target="#Modal">
                        <span class="glyphicon glyphicon-plus"></span> Nova</a>

                    <a href="financeiro/baixar" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-piggy-bank"></span> Baixar</a>

                    <a href="financeiro/detalhes" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-sunglasses"></span> Detalhes</a>

                    <a type="button" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-print"></span> Imprimir</a>

                    <a href="financeiro/editar" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-edit"></span> Editar</a>

                    <a href="financeiro/canselar" class="btn btn-link" id="Opcao">
                        <span class="glyphicon glyphicon-trash"></span> Canselar</a>
                </div>
            </div>
            <div class="col-sm-3 espacamento">
                <input type="text" id="busca" placeholder="Buscar">
            </div>
            <div class="col-sm-1 espacamento">
                <div class="form-inline">
                    <div class="form-group">
                        <select name="qtd" id="qtd">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="0">Tudo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 espacamento">
                <div class="form-inline">
                    <div class="form-group">
                        <select name="estatus" id="estatus">
                            <option value="ab">ABERTO</option>
                            <option value="pg">PAGO</option>
                            <option value="cn">CANSELADO</option>
                        </select>
                    </div>
                    &nbsp;&nbsp;<span class="glyphicon glyphicon-filter" id="filtro"></span>
                </div>
            </div>
        </div>


        <table class="table table-hover" data-sortable>
            <thead>
                <tr>
                    <th width="5%">#</th><th>DESCRIÇÃO/CLIENTE/FORNECEDOR</th><th width="15%">VENCIMENTO</th><th width="10%">VALOR</th><th width="10%">ESTATUS</th>
                </tr>
            </thead>
            <tbody id="LstRecDes"></tbody>
        </table>


    </div>
</div>
<script>
    $(document).ready(function () {

        setInterval(function () {
            if (AutoCarrega === 1) {
                CarregaJson(MenuSelect);
            }
        }, 30000);

        var json = {};
        var idSelect = null;
        var MenuSelect = 1;
        var AutoCarrega = 1;

        CarregaJson(MenuSelect);

        // comportamento do Model apos fechar
        $(document).on('hidden.bs.modal', function () {
            if (AutoCarrega === 1) {
                CarregaJson(MenuSelect);
            }
        });
        // compoetamento do menu
        $(document).on('click', '.submenu-financeiro>li', function () {
            href = $(this).find("a").attr('href');
            $(this).tab('show');
            AutoCarrega = 1;
            MenuSelect = href;
            CarregaJson(href);
            $('.in,.open').removeClass('in open');
            return false;
        });
        // sistema de seleção das ordens
        $(document).on('click', '#LstRecDes tr', function () {
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
                buscar();
            }
        });
        $(document).on('click', '#filtro', function () {
            buscar();
        });
        $(document).on('change', '#estatus, #qtd', function () {
            buscar();
        });


        function buscar() {
            var dados = {busca: $('#busca').val(), estatus: $('#estatus').val(), qtd: $('#qtd').val(), natureza: MenuSelect};
            $.ajax({
                type: "POST",
                url: "financeiro/busca",
                dataType: "json",
                data: dados,
                success: function (response) {
                    AutoCarrega = 0;
                    AddTabela(response);
                }
            });
            return false;
        }

        // Carrega a lista de ordem das tabelas
        function CarregaJson(href) {
            $.getJSON("financeiro/ReceitaDespesaLst/" + href, function (data) {
                AddTabela(data);
                $('.nav-tabs a[href="' + MenuSelect + '"]').parents('li').addClass('active');
            });
        }

        function AddTabela(data) {
            if (!comparaArray(json, data)) {
                $('#LstRecDes').empty();
                if (data !== "") {
                    $.each(data, function (key, value) {
                        $('#LstRecDes').append(
                                $('<tr>').append(
                                $('<td>').text(value.DESREC_ID),
                                $('<td>').text(value.PES_NOME),
                                $('<td>').text(Data(value.DESREC_VECIMENTO)),
                                $('<td>').text(FloatReal(value.DESREC_VALOR)),
                                $('<td>').text(value.DESCRE_ESTATUS)
                                ));
                    });
                }
                json = data;
                idSelect = null;
            }
        }

    });
</script>