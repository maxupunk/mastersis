<div class="row">
    <ul class="relatorio-list">
        <li itemref="teste">
            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
            <span class="titulo">Vendas</span><!-- periodo, por cliente, por vendedor, produto, pot tipo de cliente -->
        </li>
        <li>
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
            <span class="titulo">Ordem de Serviço</span>
        </li>
        <li>
            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
            <span class="titulo">Compras</span>
        </li>

        <li>
            <span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span>
            <span class="titulo">Financeiro</span>
        </li>

        <li>
            <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
            <span class="titulo">Produtos</span>
        </li>

        <li>
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            <span class="titulo">Clientes/Fornecedor</span>
        </li>

        <li>
            <span class="glyphicon glyphicon-paste" aria-hidden="true"></span>
            <span class="titulo">Avaria</span>
        </li>

        <li>
            <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
            <span class="titulo">Log de acesso</span>
        </li>

        <li>
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
            <span class="titulo">Historico</span>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-lg-4">
        <label>Pessoa</label>
        <input type="text" id="Pessoa" placeholder="Pessoa">
    </div>
    <div class="col-lg-4">
        <label>Produto</label>
        <input type="text" id="ProdutoDesc" placeholder="Produto">
    </div>
    <div class="col-lg-2">
        <label>Periodo de</label>
        <input type="text" class="data" name="PES_NASC_DATA" value="<?php echo set_value('PES_NASC_DATA'); ?>"/>
    </div>
    <div class="col-lg-2">
        <label>ate</label>
        <input type="text" class="data" name="PES_NASC_DATA" value="<?php echo set_value('PES_NASC_DATA'); ?>"/>
    </div>
</div><hr>
<div class="row">
    <div class="col-lg-12">
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="options" id="option1" autocomplete="off"> Vendas
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option2" autocomplete="off"> Ordem de Serviço
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Compras
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Financeiro
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Produtos
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Clientes/Fornecedor
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Avaria
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Log de acesso
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Historico
            </label>
        </div>
    </div>
</div>
<br>

<script>
    // compoetamento excluir e padrão
    $(document).on('click', '.relatorio-list > li', function () {
        menu = $(this).attr('itemref');
        $("#Modal .modal-content").load(menu);
        $('#Modal').modal('show');
        return false;
    });
</script>