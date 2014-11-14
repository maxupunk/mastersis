<?php
if (isset($mensagem) and $mensagem != NULL) {
    echo '<h4 class="text-center">' . $mensagem . '</h4>';
    exit();
}
?>
<div class="BordaOs">
    <form action="<?php echo base_url('pedido'); ?>/Delete/<?php echo $id_pedido ?>" name="grava" method="post" accept-charset="utf-8">
        <fieldset>

            <legend>Excluir o pedido <?php echo $id_pedido ?>? <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></legend>

            <input type="hidden" name="id_pedido" value="<?php echo $id_pedido ?>" />

            <button type="submit" class="btn btn-danger">SIM</button>
            <button type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true">NÃO</button>

        </fieldset>
    </form>
</div>