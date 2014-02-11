<?php if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>'; ?>
<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="col-sm-4"><label>CLIENTE</label><p><?php echo $cliente->PES_NOME ?></p></div>
        <div class="col-sm-2"><label>C.P.F / C.N.P.J</label><p><?php echo $cliente->PES_CPF_CNPJ ?></p></div>
        <div class="col-sm-2"><label>CELULAR</label><p><?php echo $cliente->PES_CEL1 ?></p></div>
        <div class="col-sm-2"><label>CIDADE</label><p><?php echo $cliente->CIDA_NOME ?>-<?php echo $cliente->ESTA_UF ?></p></div>
        <div class="col-sm-1"><p><?php echo anchor('venda/abrir/'.$cliente->PES_ID, 'Abrir', 'class="btn btn-primary" id="AbrirVenda"'); ?></p></div>
        <div class="col-sm-1"><p><?php echo anchor('venda/listar/'.$cliente->PES_ID, 'Listar', 'class="btn btn-primary" id="ListarVenda"'); ?></p></div>
    </div>
</div>
<hr>