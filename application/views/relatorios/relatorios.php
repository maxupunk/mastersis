<div class="row">
    <div class="relatorio-list">
        <a href="relatorios/vendas">
            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
            <span class="titulo">Vendas</span>
        </a>
        <a>
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
            <span class="titulo">Ordem de Serviço</span>
        </a>
        <a>
            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
            <span class="titulo">Compras</span>
        </a>

        <a>
            <span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span>
            <span class="titulo">Financeiro</span>
        </a>

        <a>
            <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
            <span class="titulo">Produtos</span>
        </a>

        <a>
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            <span class="titulo">Clientes/Fornecedor</span>
        </a>

        <a>
            <span class="glyphicon glyphicon-paste" aria-hidden="true"></span>
            <span class="titulo">Avaria</span>
        </a>

        <a>
            <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
            <span class="titulo">Log de acesso</span>
        </a>

        <a>
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
            <span class="titulo">Historico</span>
        </a>
    </div>
</div>
<br>

<script>
    // compoetamento excluir e padrão
    $(document).on('click', '.relatorio-list > a', function () {
        $("#Modal .modal-content").load($(this).attr('href'));
        $('#Modal').modal('show');
        return false;
    });
</script>