<?php
if (isset($mensagem) and $mensagem != NULL) {
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();
}
?>
<form action="<?php echo base_url('ordemservico'); ?>/excluir/<?php echo $OsDados->OS_ID ?>" id="SubmitAjax" method="post" accept-charset="utf-8">
    <fieldset>

        <div class="row">
            <div class="col-sm-6"><label>CLIENTE</label><br><?php echo $OsDados->PES_NOME ?></div>
            <div class="col-sm-4"><label>ENTRADA</label><br><?php echo $OsDados->OS_DATA_ENT ?></div>
            <div class="col-sm-2"><label>OS N.</label><br><?php echo $OsDados->OS_ID ?></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <label>EQUIPAMENTO:</label>
                <div class="col-sm-12">
                    <?php echo $OsDados->OS_EQUIPAMENT ?>
                </div>
            </div>
            <div class="col-sm-6">
                <label>DEFEITO:</label>
                <div class="col-sm-12">
                    <?php echo $OsDados->OS_EQUIPAMENT ?>
                </div>
            </div>
        </div>

        <input type="hidden" name="id_os" value="<?php echo $OsDados->OS_ID ?>" />
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">SIM</button>
            <button type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true">NÃO</button>
        </div>
    </fieldset>
</form>