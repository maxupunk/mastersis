<div class="BordaOs">
    <form action="<?php echo base_url('pedido'); ?>/LimpLstEmAberto" id="confirmacao" method="post" accept-charset="utf-8">
        <fieldset>

            <legend>Limpar <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></legend>

            <div>Limpa a lista de compras em aberto?</div>

            <hr>
            <input type="hidden" name="confima">
            <button type="submit" class="btn btn-danger">SIM</button>
            <button type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true">NÃO</button>

        </fieldset>
    </form>
</div>