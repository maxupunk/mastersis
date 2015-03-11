<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
<?php } ?>
<form action="<?php echo base_url('pedido'); ?>/Receber/<?php echo $id_pedido ?>" id="ReceberCompra" method="post" accept-charset="utf-8">

    <span><?php echo validation_errors(); ?></span>
    <?php if ($LstPedido <> NULL) { ?>
        <table>
            <thead>
                <tr class="bg-primary"><th width="5%"></th><th>DESCRIÇÃO (Disponibilidade)</th><th width="8%">QNT</th><th width="12%">CUSTO</th><th width="15%">VENDA</th></tr>
            </thead>
            <tbody>
                <?php
                foreach ($LstPedido as $linha) {
                    $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
                    $estoq_atual = ($linha->PRO_TIPO == "s") ? "Serviço" : $linha->ESTOQ_ATUAL;
                    ?>
                    <tr id="<?php echo $linha->LIST_PED_ID ?>" itemref="<?php echo $linha->ESTOQ_ID ?>">
                        <td><?php echo $linha->PRO_ID ?></td>
                        <td><?php echo $linha->PRO_DESCRICAO ?> [ <?php echo $estoq_atual ?> ]</td>
                        <td><?php echo $linha->LIST_PED_QNT ?></td>
                        <td><?php echo $this->convert->em_real($linha->LIST_PED_COMP) ?></td>
                        <td><input type="text" class="valor ValorVenda" value="<?php echo $this->convert->em_real($linha->LIST_PED_PRECO) ?>"></td>
                    <tr>
                    <?php } ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-xs-12">
                <label>Observação:</label>
                <textarea name="PEDIDO_OBS" rows="3"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <label>N do documento:</label>
                <input type="text" name="PEDIDO_N_DOC" value="" maxlength="45"/>
                <input type="hidden" name="id_pedido" id="id_pedido" value="<?php echo $id_pedido ?>">
            </div>
            <div class="col-xs-6"><br>
                <button type="submit" class="btn btn-default">CONFIRMAR O RECEBIMENTO</button>
            </div>
        </div>
        <?php
    } else {
        echo "<p align='center'>Não foi usado produto(s)!</p>";
    }
    ?>
</form>
<script>
    $(document).ready(function() {

        // comportamento dos formularios das ordems
        $(document).on("submit", '#ReceberCompra', function() {
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                dataType: "html",
                data: $(this).serialize(),
                // enviado com sucesso
                success: function(response) {
                    $("#ComprasConteiner").load("compras/listar");
                    $("#modal-content").html(response);
                }
            });
            return false;
        });

        // Altera o valor
        $(document).on("keypress", ".ValorVenda", function(event) {
            if (event.which === 13) {
                valor = $(this);
                ListPedido = $(this).parents('tr').attr('id');
                Estoque_id = $(this).parents('tr').attr('itemref');
                var dados = {Pedido: $('#id_pedido').val(), ListPed: ListPedido, Valor: $(this).val()};
                $.ajax({
                    type: "POST",
                    url: "financeiro/ValorVenda",
                    dataType: "html",
                    data: dados,
                    success: function() {
                        $('input').eq($('input').index(valor)+1).focus();
                        valor.removeClass("alert-danger");
                        valor.addClass("alert-success");
                    },
                    error: function() {
                        valor.removeClass("alert-success");
                        valor.addClass("alert-danger");
                    }
                });
                return false;
            }
        });
    });
</script>