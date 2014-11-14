<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
<?php } ?>
<form action="<?php echo base_url('pedido'); ?>/Receber/<?php echo $id_pedido ?>" id="ReceberCompra" method="post" accept-charset="utf-8">

    <span><?php echo validation_errors(); ?></span>
    <?php if ($LstProd <> NULL) { ?>
        <table>
            <thead>
                <tr class="bg-primary"><th width="5%"></th><th>DESCRIÇÃO (Disponibilidade)</th><th width="8%">QNT</th><th width="10%"></th></tr>
            </thead>
            <tbody>
                <?php
                foreach ($LstProd as $linha) {
                    $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
                    $estoq_atual = ($linha->PRO_TIPO == "s") ? "Serviço" : $linha->ESTOQ_ATUAL;
                    ?>
                    <tr id="<?php echo $linha->LIST_PED_ID ?>" itemref="<?php echo $linha->ESTOQ_ID ?>">
                        <td><?php echo $linha->PRO_ID ?></td>
                        <td><?php echo $linha->PRO_DESCRICAO ?> [ <?php echo $estoq_atual ?> ]</td>
                        <td id="QntPed"><?php echo $linha->LIST_PED_QNT ?></td>
                        <td><input type="number" id="QntRec" value=""></td>
                    <tr>
                    <?php } ?>
            </tbody>
        </table>

        <label>Observação:</label>
        <textarea name="PEDIDO_OBS" rows="3"></textarea>
        <div class="row">
            <div class="col-xs-6">
                <label>N do documento:</label>
                <input type="text" name="PEDIDO_N_DOC" value="" maxlength="45"/>
                <input type="hidden" name="id_pedido" value="<?php echo $id_pedido ?>">
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
        $(document).on('change', '#QntRec', function() {
            if (parseInt($(this).val()) >= parseInt($('#QntPed').text())) {
                $(this).parents('tr').addClass("bg-success");
            } else {
                $(this).parents('tr').removeClass("bg-success");
            }
            //console.log($('#QntPed').text());
            return false;
        });
        
                // comportamento dos formularios das ordems
        $(document).on("submit", '#ReceberCompra', function() {
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                dataType: "html",
                data: $(this).serialize(),
                // enviado com sucesso
                success: function(response) {
                    $("#modal-content").html(response);
                    $("#ComprasConteiner").load("compras/listar");
                }
            });
            return false;
        });
    });
</script>