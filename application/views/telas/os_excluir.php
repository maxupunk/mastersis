<?php
if (isset($mensagem) and $mensagem != NULL) {
    echo '<div class="alert alert-info">' . $mensagem . '</div>';
    exit();
}
?>
<div class="BordaOs">
    <form action="<?php echo base_url('ordemservico'); ?>/excluir/<?php echo $OsDados->OS_ID ?>" id="OrdemServicos" method="post" accept-charset="utf-8">
        <fieldset>

            <legend>EXCLUIR ESSA ORDEM? <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></legend>

            <div>
                <div class="col-sm-6"><label>CLIENTE</label><br><?php echo $OsDados->PES_NOME ?></div>
                <div class="col-sm-4"><label>ENTRADA</label><br><?php echo $OsDados->OS_DATA_ENT ?></div>
                <div class="col-sm-2"><label>OS N.</label><br><?php echo $OsDados->OS_ID ?></div>
            </div>

            <div>
                <span>EQUIPAMENTO:</span>
                <div class="col-sm-12">
                    <?php echo $OsDados->OS_EQUIPAMENT ?>
                </div>
            </div>

            <div>
                <span>DEFEITO:</span>
                <div class="col-sm-12">
                    <?php echo $OsDados->OS_EQUIPAMENT ?>
                </div>
            </div>

            <input type="hidden" name="id_os" value="<?php echo $OsDados->OS_ID ?>" />

            <hr>
            <button type="submit" class="btn btn-danger">SIM</button>
            <button type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true">NÃO</button>

        </fieldset>
    </form>
</div>