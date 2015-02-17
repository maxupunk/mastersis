<?php
if (isset($mensagem) and $mensagem != NULL)
    echo '<div class="alert alert-info">' . $mensagem . '</div>';

if ($total->total == NULL) {
    echo 'Não é possivel finalizar a venda. Não existe item nessa venda.';
    exit;
}
?>
<form action="venda/pagamento/<?php echo $id_pedido ?>" method="post" name="grava" accept-charset="utf-8">
    <div class="row">
        <div class="col-sm-3"><label>ID VENDA</label><input type="text" id="VendaId" value="<?php echo $id_pedido ?>" disabled /></div>
        <div class="col-sm-9">
            <label>NOME</label> | <span id="pessoa-selec">Venda avulsa</span>
            <input type="text" id="pessoa" autocomplete="off" placeholder="DIgite o nome do cliente"/>
            <input type="hidden" name="PES_ID" id="PES_ID" value="">
            <?php echo form_error('PES_ID'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4"><label>FORMA PG.</label>
            <?php
            foreach ($forma_pgs as $forma_pg)
                $options[$forma_pg->FPG_ID] = $forma_pg->FPG_DESCR;
            echo form_dropdown('FPG', $options, '', 'id="FPG" required');
            ?>
        </div>
        <div class="col-sm-2"><label>PARCELA</label>
            <select name="NPARCELA" id="nparcela"><option value="1">1</option></select>
        </div>
        <div class="col-sm-3">
            <label>DE</label>
            <input type="text" name="VPARCELA" id="VPARCELA" disabled />
        </div>
        <div class="col-sm-3">
            <label>TOTAL</label>
            <input type="text" name="valor-total" id="valor-total" value="<?php echo $this->convert->em_real($total->total) ?>" disabled />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label>OBSERVAÇÃO</label>
            <textarea name="PEDIDO_OBS" rows="3"></textarea>
        </div>
    </div>
    
    <button class="btn btn-default">Finalizar</button>
</form>

<script>
    $(document).ready(function() {

        $(document).on('change', '#FPG', function() {
            $.getJSON("financeiro/FormaPG/" + $('#FPG').val(), function(data) {
                if (data.msg !== undefined) {
                    alert(data.msg);
                } else {
                    $('#nparcela').empty();
                    for (var x = 1; x <= data.FPG_PARCE; x++) {
                        $('#nparcela').append(new Option(x, x));
                    }
                }
            }, $('#nparcela').change());
        });

        $(document).on('change', '#nparcela', function() {
            parcelas = $(this).val();
            $.getJSON("financeiro/Nparcelas/" + $('#VendaId').val() + "/" + $('#FPG').val() + "/" + parcelas, function(data) {
                if (data.msg === undefined) {
                    $('#valor-total').val(FloatReal(data));
                    $('#VPARCELA').val(FloatReal(data / parcelas));
                } else {
                    alert(data.msg);
                }
            });
        });
    });
</script>
<script src="<?php echo base_url('assets/js/pessoa.js'); ?>"></script>
