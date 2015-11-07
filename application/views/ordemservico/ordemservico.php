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

                    <a href="" class="btn btn-link" data-toggle="modal" data-target="#ModalGrcItens">
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
<div class="modal fade" id="ModalGrcItens">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">
                <div class="col-sm-12">
                    <input type="text" name="PRO_DESCRICAO" id="ProdutoServico" autocomplete="off" placeholder="Produto/Serviço"/>
                    <input type="hidden" name="OS_ID" id="os_id" value=""/>
                </div>
            </div>

            <table class="table table-hover" data-sortable>
                <thead>
                    <tr>
                        <th width="5%">#</th><th>DESCRIÇÃO (Disponibilidade)</th><th width="14%">QNT</th><th width="10%">VALOR</th><th width="8%">SUBTOTAL</th><th width="1%"></th>
                    </tr>
                </thead>
                <tbody class="lista-produto"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td><td><b>TOTAL:</b></td><td colspan="2"><b id="total"></b></td>
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo base_url('assets/js/ordemservico.js'); ?>"></script>
