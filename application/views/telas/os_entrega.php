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
        CLIENTE: <?php echo $pessoa->PES_NOME ?><br>
        END.: <?php echo $pessoa->RUA_NOME ?> - <?php echo $pessoa->BAIRRO_NOME ?> / 
        <?php echo $pessoa->CIDA_NOME ?> - <?php echo $pessoa->ESTA_UF ?> CEP: <?php echo $pessoa->RUA_CEP ?><br>
        C.P.F: <?php echo $pessoa->PES_CPF_CNPJ ?> | FONE: <?php echo $pessoa->PES_CEL1 ?>
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
    
    <p class="miniletras">     
        1 - Os produtos listados neste recibo foram entregues ao receptor conforme descritos.
        2 - O cliente conferiu todas as mercadorias durante a baixa.
        3 - O Cliente acompanhou e reconheceu os produtos listados, bem como suas respectivas quantidades e valores.
        4 - O cliente ou representante retirou todos os produtos apresentados no recibo na respectiva data aqui informada.
        Ambos, Empresa e Cliente assinam este recibo a fim de validá-lo como verdadeiro.
        Todas as assinaturas e datas devem estar preenchidas corretamente.
        O cliente reconhece e assina este recibo dando garantia de retirada dos produtos acima listados.
        Sem mais. 
    </p>

    <table class="rodape-recibo">
        <tr>
            <th>ENTREGUE POR:</th>
            <th>RECEBIDO POR:</th>
            <th>DATA:</th>
        </tr>
        <tr>
            <td>______________________________</td>
            <td>______________________________</td>
            <td><b><?php echo $OsDados->OS_DATA_SAI; ?></b></td>
        </tr>
    </table>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-primary" id="imprimir">Imprimir</button>
</div>