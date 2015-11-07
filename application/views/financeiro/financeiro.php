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
                                        <input type="text" class="valor PrecoCusto" value="" data-toggle="tooltip" data-placement="bottom" title="Enter para gravar"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Preço Venda</label>
                                        <input type="text" value="" class="valor PrecoVenda" data-toggle="tooltip" data-placement="bottom" title="Enter para gravar" />
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
                                <input type="text" value="" class="NumInt ParceFPT" maxlength="2" placeholder="maxi."/>
                            </div>
                            <div class="col-sm-2">
                                <label>Juros</label>
                                <input type="text" value="" class="NumFloat JurusFPG" placeholder="ao ano"/>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-success btn-label AddFormPG">Add/Salva</button>
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

            <div class="tab-pane" id="avaria"><!-- menu avaria -->
                <div class="row espacamento">
                    <div class="col-sm-4">
                        <label>PRODUTO</label>
                        <input type="text" id="ProdutoDesc" placeholder="Digite o nome do produto para avaria!">
                    </div>
                    <div class="col-sm-5">
                        <label>Motivo</label>
                        <input type="text" class="MotivoAvaria" value="" placeholder="Motivo do produtos está em avaria"/>
                    </div>
                    <div class="col-sm-1">
                        <label>Quant.</label>
                        <input type="text" value="" class="NumFloat QntAvaria"/>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-success btn-label AddAvaria">Avariar</button>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-danger btn-label RmAvaria">Remover</button>
                    </div>

                </div>

                <div class="row">
                    <table class="table table-hover" data-sortable>
                        <thead>
                            <tr>
                                <th width="10%">#</th><th>PODUTO</th><th>MOTIVO</th><th width="8%">QNT.</th><th>USUARIO<th width="10%">DATA</th>
                            </tr>
                        </thead>
                        <tbody id="TabelaAvaria"></tbody>
                    </table>
                </div>
            </div><!-- Menu Avaria -->
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

        $.getScript("<?php echo base_url('assets/js/financeiro.js'); ?>", function (data, textStatus, jqxhr) {
            //console.log(data); // Data returned
            //console.log("Carregando scripts: "+textStatus); // Success
            //console.log(jqxhr.status); // 200
        });

    });
</script>