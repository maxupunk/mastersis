<div class="row">
    <div class="col-sm-12">
        <input type="text" name="PRO_DESCRICAO" id="ProdutoServico" autocomplete="off" placeholder="Produto/Serviço"/>
        <input type="hidden" name="OS_ID" id="os_id" value="<?php echo $id_os ?>"/>
    </div>
</div>

<div class="row"><br>
    <div class="col-sm-12" id="ListaPedido">
        <?php
        $this->load->view("telas/pedido/itens");
        ?>
    </div>
</div>
<script>
    // aplica as configuração do autocomplete
    var ListaProduto = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {url: 'produto/pegaproduto/os?buscar=%QUERY'}
    });

    // inicialisa o autocomplete
    ListaProduto.initialize();

    // inicialisa typeahead UI
    $('#ProdutoServico').typeahead(null, {
        source: ListaProduto.ttAdapter()
    }).on('typeahead:selected', function(object, data) {
        $("#ListaPedido").load("pedido/AddProdOs/" + $('#os_id').val() + "/" + data.id);
        $(this).val('');
    });

    $("#ProdutoServico").click(function() {
        $(this).val('');
    });
    // ALTERA QUATIDADE DE PRODUTOS
    $(document).on('change', '#quantidade', function() {
        ListPedido = $(this).parents('tr').attr('id');
        Estoque_id = $(this).parents('tr').attr('itemref');
        var dados = {Os: $('#os_id').val(), ListPed: ListPedido, Estoq_id: Estoque_id, qtd: $(this).val()};
        $.ajax({
            type: "POST",
            url: "pedido/AtualizaQntItemOs",
            dataType: "html",
            data: dados,
            // enviado com sucesso
            success: function(response) {
                $("#ListaPedido").html(response);
            }
        });
        return false;
    });
    // EXCLUIR PRODUTOS
    $(document).on('click', '#excluir-item', function() {
        ListPedido = $(this).parents('tr').attr('id');
        $("#ListaPedido").load("pedido/removeitemos/" + $('#os_id').val() + "/" + ListPedido);
    });
</script>