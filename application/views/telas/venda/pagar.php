<?php
if (isset($mensagem) and $mensagem != NULL)
    echo '<div class="alert alert-info">' . $mensagem . '</div>';

if ($total->total == NULL) {
    echo 'Não é possivel finalizar a venda. Não existe item nessa venda.';
    exit;
}
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Finalizando venda</h4>
</div>
<div class="modal-body">
    <div class="row">
        <input type="hidden" id="PES_ID">
        <div class="col-sm-3"><label>N. VENDA</label><input type="text" value="<?php echo $id_pedido ?>" disabled /></div>
        <div class="col-sm-9">
            <label>NOME DA PESSOA</label> | <span id="pessoa-selec">0 - Venda avulsa</span>
            <input type="text" id="Cliente" autocomplete="off" placeholder="Cliente"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8"><label>FORMA PG.</label><select><option>Dinheiro</option><option>Carnê</option><option>Cheque</option><option>Credito</option><option>Debito</option></select></div>
        <div class="col-sm-4"><label>TOTAL</label><input type="text" name="valor-total" id="valor-total" value="<?php echo $total->total ?>" class="valor" disabled /></div>
    </div>
</div>
<div class="modal-footer">
    <button href="venda/fechar/<?php echo $id_pedido ?>" class="btn btn-default" id="InModel">Finalizar</button>
</div>
<script>
    $(document).ready(function() {
        var ListaUsuario = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {url: 'pessoa/pegapessoa?buscar=%QUERY'}
        });
        // inicialisa o autocomplete
        ListaUsuario.initialize();

        // inicialisa typeahead UI
        $('#Cliente').typeahead(null, {
            source: ListaUsuario.ttAdapter()
        }).on('typeahead:selected', function(object, data) {
            $("#PES_ID").val(data.id);
            $("#pessoa-selec").text(data.id + " - " + data.value);
        });
    });
</script>