<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>

<div class="modal-header"><h4 class="modal-title">RECIBO DE PRODUTOS</h4></div>
<div class="modal-body impresao">

    <div class="recibo">
    <p class="cabeca-recibo">
        <?php echo $empresa->EMPRE_NOME ?> - <?php echo $empresa->EMPRE_SLOGAN ?><br>
        CNPJ: <?php echo $empresa->EMPRE_CNPJ ?> - Fone/Fax: <?php echo $empresa->EMPRE_FONE ?> / <?php echo $empresa->EMPRE_FAX ?><br>
        E-mail/site: <?php echo $empresa->EMPRE_EMAIL ?> / <?php echo $empresa->EMPRE_SITE ?><br>
    </p>
    <?php
    setlocale(LC_MONETARY, "pt_BR");
    $this->table->set_heading('COD', 'QNT', 'DESCRIÇÃO', 'PREÇO(UN)', 'SUB.TOTAL');

    foreach ($lista_pedido as $linha) {

        $sub_total = ($linha->LIST_PED_QNT * $linha->LIST_PED_PRECO);
        

        $this->table->add_row($linha->PRO_ID, $linha->LIST_PED_QNT . $linha->MEDI_SIGLA, $linha->PRO_DESCRICAO, $this->convert->em_real($linha->LIST_PED_PRECO), $this->convert->em_real($sub_total));
    }

    $this->table->add_row('', '', '', 'TOTAL:', $this->convert->em_real($total->total));

    $tmpl = array('table_open' => '<table class="tabela_recibo">');
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
            <td>__________________________</td>
            <td>__________________________</td>
            <td><b><?php echo date("d/m/Y - H:i:s", strtotime($pedido->PEDIDO_DATA)) ?></b></td>
        </tr>
    </table>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-primary" id="imprimir">Imprimir</button>
</div>