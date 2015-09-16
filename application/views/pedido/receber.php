<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <?php echo $mensagem ?>
<?php } ?>
<form action="<?php echo base_url('pedido'); ?>/Receber/<?php echo $id_pedido ?>" id="SubmitPedido" method="post" accept-charset="utf-8">

    <?php if ($LstPedido <> NULL) { ?>
        <table data-sortable>
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
                <textarea name="PEDIDO_OBS" rows="3"><?php echo $pedido->PEDIDO_N_DOC ?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <label>N do documento:</label>
                <input type="text" name="PEDIDO_N_DOC" value="<?php echo $pedido->PEDIDO_N_DOC ?>" maxlength="45"/>
            </div>
            <div class="col-xs-6"><br>
                <input type="hidden" name="id_pedido" id="id_pedido" value="<?php echo $id_pedido ?>">
                <button type="submit" class="btn btn-default">CONFIRMAR O RECEBIMENTO</button>
            </div>
        </div>
        <?php
    } else {
        echo "<p align='center'>Não foi usado produto(s)!</p>";
    }
    ?>
</form>