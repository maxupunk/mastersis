<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="well">
    <div class="row">
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" id="NovoPedido" class="btn btn-default btn-sm">Nova</button>
                <button type="button" id="Finalizar" class="btn btn-default btn-sm" disabled>Finalizar</button>
                <a href="pedido/LmpLstEmAberto" id="InModel" class="btn btn-danger btn-sm">Limpa</a>
                <button type="button" id="EmAberto" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="EmAbList" role="menu">
                </ul>
            </div>
        </div>
        <div class="col-sm-7">
            <input type="text" name="PRO_DESCRICAO" id="ProdutoDesc" autocomplete="off" placeholder="Nome ou descrição ou codigo do produtos" disabled/>
            <input type="hidden" id="tipo" value="v">
        </div>
        <div class="col-sm-2">
            <input type="number" id="IdPed" class="IdPed" placeholder="Pedido" autocomplete="off"/>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12" id="ListaPedido">
    </div>
</div>
<script>
    $(document).ready(function() {
        // abri um novo pedido
        $(document).on("click", "#NovoPedido", function() {
            $.getJSON('pedido/novo', function(data) {
                $('#IdPed').val(data);
                $('#ProdutoDesc').prop('disabled', false);
                $('#Finalizar').prop('disabled', false);
                $('#EmAbList').empty();
            });
        });
        // atualiza o pedido conforme digitado no compo Pedido
        $(document).on('change', '#IdPed', function() {
            $("#ListaPedido").load("pedido/UpdLstPedido/" + $('#IdPed').val());
            $('#ProdutoDesc').prop('disabled', false);
            $('#Finalizar').prop('disabled', false);
            return false;
        });
        //Finaliza o pedido
        $(document).on('click', '#Finalizar', function() {
            $("#modal-content").load("venda/pagamento/" + $("#IdPed").val());
            $('#modal').modal('show');
            return false;
        });
        //Lista o pedido em Aberto
        $(document).on('click', '#EmAberto', function() {
            $.getJSON('pedido/emaberto', function(data) {
                $('#EmAbList').empty();
                if (data == "") {
                    $('#EmAbList').append('Não ha compras em aberto');
                }
                $.each(data, function(key, value) {
                    descr = value.PEDIDO_ID + ' - ' + value.PEDIDO_DATA
                    if (value.PEDIDO_ID === $('#IdPed').val()) {
                        descr = '<u>' + descr + '</u>'
                    }
                    $('#EmAbList').append('<li><a href="' + value.PEDIDO_ID + '">' + descr + '</a></li>');

                });
            });
        });
        // Função do dropdown na lista em pedido em aberto. 
        $(document).on("click", "#EmAbList>li", function() {
            href = $(this).find("a").attr('href');
            $("#IdPed").val(href);
            $("#ListaPedido").load("pedido/UpdLstPedido/" + $('#IdPed').val());
            $('#ProdutoDesc').prop('disabled', false);
            $('#Finalizar').prop('disabled', false);
            $('.in,.open').removeClass('in open');
            return false;
        });
        
    });

</script>
<script src="<?php echo base_url('assets/js/pedidos.js'); ?>"></script>