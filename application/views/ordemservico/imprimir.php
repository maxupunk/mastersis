<?php if (isset($mensagem) and $mensagem != NULL) print '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="impresao">

    <div class="recibo">
        <p class="cabeca-recibo">
            <b><?php echo $empresa->EMPRE_NOME ?> - <?php echo $empresa->EMPRE_SLOGAN ?></b><br>
            <b>CNPJ:</b> <?php echo $empresa->EMPRE_CNPJ ?> - <b>Fone/Fax:</b> <?php echo $empresa->EMPRE_FONE ?> / <?php echo $empresa->EMPRE_FAX ?><br>
            <b>E-mail/site:</b> <?php echo $empresa->EMPRE_EMAIL ?> / <?php echo $empresa->EMPRE_SITE ?><br>
        </p>
        <p align="center" class="descr-os">
            <b>CLIENTE:</b> <?php echo $pessoa->PES_NOME ?> | <b>FONE:</b> <?php echo $pessoa->PES_CEL1 ?><br>
            <b>END.:</b> <?php echo $pessoa->RUA_NOME ?> - <?php echo $pessoa->BAIRRO_NOME ?> / 
            <?php echo $pessoa->CIDA_NOME ?> - <?php echo $pessoa->ESTA_UF ?> | <b>CEP:</b> <?php echo $pessoa->RUA_CEP ?>
        </p>

        <b>Equiapmento:</b>
        <p class="descr-os">
            <?php echo $OsDados->OS_EQUIPAMENT ?>
        </p>

        <b>Defeito:</b>
        <p class="descr-os">
            <?php echo $OsDados->OS_DSC_DEFEITO ?>
        </p>

        <b>Solução:</b>
        <p class="descr-os">
            <?php echo $OsDados->OS_DSC_SOLUC ?>
        </p>

        <?php
        setlocale(LC_MONETARY, "pt_BR");
        $this->table->set_heading('COD', 'QNT', 'DESCRIÇÃO', 'PREÇO(UN)', 'SUB.TOTAL');

        foreach ($ListaPedido as $linha) {

            $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);


            $this->table->add_row($linha->PRO_ID, $linha->LIST_PED_QNT . $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total));
        }

        $this->table->add_row('', '', '', 'TOTAL:', $this->convert->em_real($total->total));

        $tmpl = array('table_open' => '<table class="lista-produto">');
        $this->table->set_template($tmpl);

        echo $this->table->generate();
        ?>

        <table class="rodape-recibo">
            <tr>
                <th>USUARIO</th>
                <th>ENTRADA</th>
                <th>ESTATUS</th>
            </tr>
            <tr>
                <td><?php echo $usuario->USUARIO_APELIDO; ?></td>
                <td><?php echo date("d/m/Y - H:i:s", strtotime($OsDados->OS_DATA_ENT)) ?></td>
                <td><?php echo $Estatus; ?></td>
            </tr>
        </table>
    </div>

</div>
<div class="botoes">
    <button class="btn btn-primary" id="imprimir">Imprimir</button>
</div>