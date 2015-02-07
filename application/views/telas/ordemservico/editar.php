<form action="<?php echo base_url('ordemservico'); ?>/editar/<?php echo $OsDados->OS_ID ?>" id="OrdemServicos" method="post" accept-charset="utf-8">
    <?php
    if (isset($mensagem) and $mensagem != NULL)
        echo '<div class="alert alert-info">' . $mensagem . '</div>';
    ?>
    <div class="row">
        <div class="col-sm-6"><label>CLIENTE</label><br><?php echo $OsDados->PES_NOME ?></div>
        <div class="col-sm-4"><label>ENTRADA</label><br><?php echo $OsDados->OS_DATA_ENT ?></div>
        <div class="col-sm-2"><label>OS N.</label><br><?php echo $OsDados->OS_ID ?></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            EQUIPAMENTO:
            <p class="descr-os"><?php echo $OsDados->OS_EQUIPAMENT ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            DEFEITO:
            <p class="descr-os"><?php echo $OsDados->OS_EQUIPAMENT ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">  
            SOLUÇÃO: <?php echo form_error('OS_DSC_SOLUC'); ?>
            <p class="descr-os">
                <textarea name="OS_DSC_SOLUC" rows="4"><?php echo set_value('OS_DSC_SOLUC', $OsDados->OS_DSC_SOLUC); ?></textarea>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            DEPENDENCIA: <?php echo form_error('OS_DSC_PENDENT'); ?>
            <p class="descr-os">
                <textarea name="OS_DSC_PENDENT" rows="4"><?php echo set_value('OS_DSC_PENDENT', $OsDados->OS_DSC_PENDENT); ?></textarea>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            OBSERVAÇÃO:
            <p class="descr-os"><?php echo $OsDados->OS_OBSERVACAO; ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 pull-left">
            <?php echo form_dropdown('OS_ESTATUS', array('1' => 'ABERTO', '2' => 'PENDENTE', '3' => 'CONCLUIDO'), set_value('OS_ESTATUS', $Estatus)); ?>
        </div>
    </div>

    <div class="botoes">
        <button type="submit"  class="btn btn-primary Model-Submit">Salvar</button>
    </div>

    <input type="hidden" value="<?php echo $OsDados->OS_ID; ?>" name="id_os" />

</form>
<script src="<?php echo base_url('assets/js/Os.js'); ?>"></script>