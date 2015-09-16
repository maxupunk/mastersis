<div class="row">
    <div class="col-sm-12">

        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#receita-despesa" data-toggle="tab">Receita/Despeza</a></li>
            <li><a href="#preco" data-toggle="tab">Gerenciar Preço/Formas PG</a></li>
            <li><a href="#avaria" data-toggle="tab">Avaria</a></li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane active" id="receita-despesa">
                <div class="row">
                    <div class="col-sm-6 espacamento">
                        <div class="btn-group btn-group-justified" role="group">
                            <a href="financeiro/novo" class="btn btn-link" data-toggle="modal" data-target="#Modal">
                                <span class="glyphicon glyphicon-plus"></span> Nova</a>

                            <a href="financeiro/baixar" class="btn btn-link" id="OpRD">
                                <span class="glyphicon glyphicon-piggy-bank"></span> Baixar</a>

                            <a href="financeiro/detalhes" class="btn btn-link" id="OpRD">
                                <span class="glyphicon glyphicon-sunglasses"></span> Detalhes</a>

                            <a type="button" class="btn btn-link" id="OpRD">
                                <span class="glyphicon glyphicon-print"></span> Imprimir</a>

                            <a href="financeiro/editar" class="btn btn-link" id="OpRD">
                                <span class="glyphicon glyphicon-edit"></span> Editar</a>

                            <a href="financeiro/canselar" class="btn btn-link" id="OpRD">
                                <span class="glyphicon glyphicon-trash"></span> Canselar</a>
                        </div>
                    </div>
                    <div class="col-sm-6 espacamento form-inline">
                        <div class="form-group">
                            <select id="natureza">
                                <option value="1">Receita</option>
                                <option value="2">Despesa</option>
                            </select>
                        </div>
                        <div class="form-group form-group-lg">
                            <input type="text" id="busca" placeholder="Buscar">
                        </div>
                        <div class="form-group">
                            <select name="qtd" id="qtd">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="estatus" id="estatus">
                                <option value="ab">ABERTO</option>
                                <option value="pg">PAGO</option>
                                <option value="cn">CANSELADO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <table class="table table-hover" data-sortable>
                    <thead>
                        <tr>
                            <th width="5%">#</th><th>CLIENTE/FORNECEDOR</th><th width="15%">VENCIMENTO</th><th width="10%">VALOR</th><th width="10%">ESTATUS</th>
                        </tr>
                    </thead>
                    <tbody id="TabelaRecDes"></tbody>
                </table>
            </div><!-- Menu Receita despesa -->

            <div class="tab-pane" id="preco">

                <div class="row espacamento">
                    <div class="col-sm-6"><!-- Esquerda Gerenciar preço -->
                        <div class="row">
                            <div class="col-sm-12"><input type="text" id="ProdutoPreco" placeholder="Digite o nome do produto para gerenciar o preço!"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Preço Custo</label>
                                        <input type="text" name="ESTOQ_CUSTO" class="valor PrecoCusto" value="" data-toggle="tooltip" data-placement="bottom" title="Enter para gravar"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Preço Venda</label>
                                        <input type="text" name="ESTOQ_PRECO" value="" class="valor PrecoVenda" data-toggle="tooltip" data-placement="bottom" title="Enter para gravar" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Lucro(%)</label>
                                        <input type="text" value="" class="Lucro" data-toggle="tooltip" data-placement="bottom" title="Enter para gravar"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Estoque</label>
                                        <input type="text" value="" class="EstoqAtual" name="ESTOQ_ATUAL" disabled/>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Tipo:</label>
                                        <select name="PRO_TIPO" class="tipo" disabled>
                                            <option value="p">Produto</option>
                                            <option value="s">Serviço</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Peso(Kg):</label>
                                        <input type="text" name="PRO_PESO" value="" class="peso ProPeso" disabled />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Estatus:</label>
                                        <select name="PRO_ESTATUS" class="estatus" disabled>
                                            <option value="a">Ativo</option>
                                            <option value="d">Desativo</option>
                                        </select>
                                    </div>
                                </div>


                                <label>Caracteristica Tecnicas:</label>
                                <pre class="PRO_CARAC_TEC"></pre>

                                <input type="hidden" value="" class="id_estoque"/>

                            </div>
                        </div>
                    </div><!-- Esquerda Gerenciar preço -->

                    <div class="col-sm-6"><!-- Direita Gerenciar Forma de pagamento -->
                        <div class="row BordaOs">
                            <div class="col-sm-6">
                                <label>Forma de agamento</label>
                                <input type="text" value="" class="DescrFPG" placeholder="Descrição"/>
                            </div>
                            <div class="col-sm-2">
                                <label>Parcela(s)</label>
                                <input type="text" value="" class="ParceFPT" placeholder="maxi."/>
                            </div>
                            <div class="col-sm-2">
                                <label>Juros</label>
                                <input type="text" value="" class="Porcento JurusFPG" placeholder="ao ano"/>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-success btn-financ-add">Add/Salva</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 BordaOs">
                                <div class="btn-group btn-group-justified" role="group">
                                    <a href="" class="btn btn-link" id="OpFPGEdit">
                                        <span class="glyphicon glyphicon-edit"></span> Editar</a>

                                    <a href="" class="btn btn-link" id="OpFPGAtDe">
                                        <span class="glyphicon glyphicon-off"></span> Ativa/Desativa</a>
                                </div>
                            </div>
                        </div>

                        <table class="table table-hover" data-sortable>
                            <thead>
                                <tr>
                                    <th width="10%">#</th><th>DESCRIÇÃO</th><th width="22%">PARCELAS</th><th width="22%">JUROS A.M</th><th width="15%">EST.</th>
                                </tr>
                            </thead>
                            <tbody id="TabelaFPG"></tbody>
                        </table>
                    </div><!-- Direita Gerenciar Forma de pagamento -->
                </div>

            </div><!-- Menu Preço -->

            <div class="tab-pane" id="avaria">avaria</div><!-- Menu Avaria -->
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        /////////////////////////////////////////////////////////////
        /// SCRIPT RECEITA/DESPESA
        /////////////////////////////////////////////////////////////
        setInterval(function () {
            FiltroRecDes();
        }, 10000);

        var json = {};
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
                $("#Modal .modal-content").text("Você não selecionou um item!");
                $('#Modal').modal('show');
            } else {
                $('#Modal').modal({remote: $(this).attr('href') + "/" + idSelecRD})
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
                    FiltroRecDes();
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
                FiltroRecDes();
            }
        });

        $(document).on('change', '#estatus, #qtd, #natureza', function () {
            FiltroRecDes();
        });


        function FiltroRecDes() {
            var dados = {busca: $('#busca').val(), estatus: $('#estatus').val(), qtd: $('#qtd').val(), natureza: $('#natureza').val()};
            $.ajax({
                type: "POST",
                url: "financeiro/filtro",
                dataType: "json",
                data: dados,
                success: function (response) {
                    AddTabelaRecDes(response);
                }
            });
            return false;
        }

        function AddTabelaRecDes(data) {
            if (!comparaArray(json, data)) {
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
                json = data;
                idSelecRD = null;
            }
        }
        ///////////////////////////////////////////////////////////////////////
        // SCRIPT DO MENU PREÇO
        ///////////////////////////////////////////////////////////////////////

        $('#ProdutoPreco').click(function () {
            $(this).val('');
        });
        $('[data-toggle="tooltip"]').tooltip();

        // Auto completa produto
        var ProdutoPreco = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {url: 'produto/pegaproduto?buscar=%QUERY'}
        });
        ProdutoPreco.clearPrefetchCache();
        // inicialisa o autocomplete
        ProdutoPreco.initialize();
        // inicialisa typeahead UI
        $('#ProdutoPreco').typeahead(null, {
            source: ProdutoPreco.ttAdapter()
        }).on('typeahead:selected typeahead:autocompleted', function (object, data) {
            $.getJSON("Financeiro/TodosDados/" + data.id, function (data) {
                $('.id_estoque').val(data.ESTOQ_ID);
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
            var dados = {IdEstq: $('.id_estoque').val(), Valor: botao.val()};
            $.ajax({
                type: "POST",
                url: url,
                data: dados,
                success: function () {
                    $('input').eq($('input').index(botao) + 1).focus();
                    botao.addClass("alert-success");
                }
            });
        }
        ///////////////////////////////////////////////////////////////////////
        // SCRIPT Forma de pagamento
        ///////////////////////////////////////////////////////////////////////
        var jsonFPG = {};
        var idSelecFPG = null;

        CarregarFPG();

        $(document).on("click", ".btn-financ-add", function () {
            var dados = {
                FPG_ID: idFPG,
                FPG_DESCR: $('.DescrFPG').val(),
                FPG_PARCE: $('.ParceFPT').val(),
                FPG_AJUSTE: $('.JurusFPG').val()
            };
            $.ajax({
                type: "POST",
                url: "financeiro/GrcFormaPG",
                dataType: "json",
                data: dados,
                success: function (e) {
                    if (e !== 'ok') {
                        MensagemModal(e);
                    } else {
                        $('.DescrFPG, .ParceFPT, .JurusFPG').val("");
                        CarregarFPG();
                    }
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
                $('.btn-financ-add').click();
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
            if (!comparaArray(jsonFPG, data)) {
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
                jsonFPG = data;
                idSelecFPG = null;
            }
        }

    });
</script>