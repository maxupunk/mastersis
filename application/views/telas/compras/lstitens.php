<?php if (isset($mensagem) and $mensagem != NULL) { ?>
    <div class="alert alert-info"><?php echo $mensagem ?></div>
<?php } ?>

<span><?php echo validation_errors(); ?></span>
<?php if ($LstProd <> NULL) { ?>
    <table class="lista-produto">
        <thead>
            <tr class="bg-primary"><th width="5%"></th><th>DESCRIÇÃO (Disponibilidade)</th><th width="5%">QNT</th><th width="10%">PREÇO</th><th width="5%">SUBTOTAL</th><th></th></tr>
        </thead>
        <tbody>
            <?php
            foreach ($LstProd as $linha) {
                $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_COMP);
                $estoq_atual = ($linha->PRO_TIPO == "s") ? "Serviço" : $linha->ESTOQ_ATUAL;
                ?>
                <tr id="<?php echo $linha->LIST_PED_ID ?>" itemref="<?php echo $linha->ESTOQ_ID ?>">
                    <td><?php echo $linha->PRO_ID ?></td>
                    <td><?php echo $linha->PRO_DESCRICAO ?> [ <?php echo $estoq_atual ?> ]</td>
                    <td><input type="number" id="quantidade" value="<?php echo $linha->LIST_PED_QNT ?>"></td>
                    <td><input type="text" class="valor ValorCompra" value="<?php echo $this->convert->em_real($linha->LIST_PED_COMP) ?>"></td>
                    <td><?php echo $this->convert->em_real($sub_total) ?></td>
                    <td><button type="button" class="close" id="excluir-item">&times;</button></td></tr>
                <tr>
                <?php } ?>
            <tr class="bg-primary">
                <td colspan="3"></td><td><b>TOTAL</b></td><td><b><?php echo $this->convert->em_real($Total->total) ?></b></td><td></td>
            </tr>
        </tbody>
    </table>
    <?php
} else {
    echo "<p align='center'>Não foi adicionado produto(s)!</p>";
}
?>