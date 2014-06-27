<?php if (isset($mensagem) and $mensagem != NULL) print '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

<div class="modal-header"><h4 class="modal-title">RECEBO DE PRODUTOS</h4></div>
<div class="modal-body impresao">

    <div class="recibo">
    <p class="cabeca-recibo">
        <?php echo $empresa->EMPRE_NOME ?> - <?php echo $empresa->EMPRE_SLOGAN ?><br>
        CNPJ: <?php echo $empresa->EMPRE_CNPJ ?> - Fone/Fax: <?php echo $empresa->EMPRE_FONE ?> / <?php echo $empresa->EMPRE_FAX ?><br>
        E-mail/site: <?php echo $empresa->EMPRE_EMAIL ?> / <?php echo $empresa->EMPRE_SITE ?><br>
    </p>
    <p class="descr-os">
        CLIENTE: <?php echo $pessoa->PES_NOME ?> | FONE: <?php echo $pessoa->PES_CEL1 ?><br>
        END.: <?php echo $pessoa->RUA_NOME ?> - <?php echo $pessoa->BAIRRO_NOME ?> / 
        <?php echo $pessoa->CIDA_NOME ?> - <?php echo $pessoa->ESTA_UF ?> | CEP: <?php echo $pessoa->RUA_CEP ?>
    </p>

    <p class="descr-os">EQUIPAMENTO:<br>
        <?php echo $OsDados->OS_EQUIPAMENT ?>
    </p>
    
    <p class="descr-os">DEFEITO:<br>
        <?php echo $OsDados->OS_DSC_DEFEITO ?>
    </p>
    
    <p class="descr-os">SOLUÇÃO:<br>
        <?php echo $OsDados->OS_DSC_SOLUC ?>
    </p>
    
    <?php
    setlocale(LC_MONETARY, "pt_BR");
    $this->table->set_heading('COD', 'QNT', 'DESCRIÇÃO', 'PREÇO(UN)', 'SUB.TOTAL');

    foreach ($ListaPedido as $linha) {

        $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
        

        $this->table->add_row($linha->PRO_ID, $linha->LIST_PED_QNT . $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, \money_format('%n', $linha->LIST_PED_PRECO), money_format('%n', $sub_total));
    }

    $this->table->add_row('', '', '', 'TOTAL:', money_format('%n', $total->total));

    $tmpl = array('table_open' => '<table class="lista-produto">');
    $this->table->set_template($tmpl);

    echo $this->table->generate();
    ?>
    
    <table class="rodape-recibo">
        <tr>
            <th>USUARIO</th>
            <th>ESTATUS</th>
        </tr>
        <tr>
            <td><?php echo $usuario->USUARIO_APELIDO; ?></td>
            <td><?php echo $Estatus; ?></td>
        </tr>
    </table>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-primary" id="imprimir">Imprimir</button>
</div>