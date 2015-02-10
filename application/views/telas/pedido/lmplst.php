<form action="<?php echo base_url('pedido'); ?>/LmpLstEmAberto" id="confirmacao" method="post" accept-charset="utf-8">
    <fieldset>

        <div>Limpa a lista de compras em aberto?</div><br>
        <input type="hidden" name="confirma">
        <button type="submit" class="btn btn-danger">SIM</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true">NÃO</button>

    </fieldset>
</form>