<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
<?php } ?>

<span><?php echo validation_errors(); ?></span>
<?php if ($LstProd <> NULL) { ?>
    <table class="plista-produto">
        <thead>
            <tr class="bg-primary">
                <th width="5%"></th><th>DESCRIÇÃO (Disponibilidade)</th><th width="5%">QNT</th><th width="10%">VALOR</th><th width="5%">SUBTOTAL</th><th width="1%"></th>
            </tr>
        </thead>
        <tbody class="lista-produto"></tbody>
        <tfoot>
            <tr class="bg-primary">
                <td colspan="3"></td><td><b>TOTAL :</b></td><td colspan="2"><b id="total"></b></td>
            </tr>
        </tfoot>
    </table>
    <?php
} else {
    echo "<p align='center'>Não foi adicionado produto(s)!</p>";
}


array_push($LstProd, array('Total' => $this->convert->em_real($Total->total)));
$JsonDados = json_encode($LstProd, JSON_UNESCAPED_UNICODE);
?>

<script>

    drawTable(<?php echo $JsonDados ?>);

    function drawTable(data) {
        $tamanho = data.length - 1;
        for (var i = 0; i < $tamanho; i++) {
            drawRow(data[i]);
        }
        $("#total").text(data[data.length - 1].Total);
    }

    function drawRow(rowData) {
        $('.lista-produto').append(
                $('<tr id=' + rowData.LIST_PED_ID + ' itemref=' + rowData.ESTOQ_ID + '>').append(
                $('<td>').text(rowData.PRO_ID),
                $('<td>').text(rowData.PRO_DESCRICAO),
                $('<td>').html('<input type=number id=quantidade value=' + rowData.LIST_PED_QNT + '>'),
                $('<td>').text(FloatReal(rowData.LIST_PED_PRECO)),
                $('<td>').text(FloatReal(rowData.LIST_PED_QNT * rowData.LIST_PED_PRECO)),
                $('<td class="close" id="excluir-item">').html('&times;')
                ));
    }
</script>