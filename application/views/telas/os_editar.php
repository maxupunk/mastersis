<form action="<?php echo base_url('ordemservico'); ?>/editar/<?php echo $OsDados->OS_ID ?>" method="post" accept-charset="utf-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            Edição de Ordem de Serviço
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="panel-body">

            <div class="row BordaOs">
                <div class="col-sm-6"><label>CLIENTE</label><br><?php echo $OsDados->PES_NOME ?></div>
                <div class="col-sm-4"><label>ENTRADA</label><br><?php echo $OsDados->OS_DATA_ENT ?></div>
                <div class="col-sm-2"><label>OS N.</label><br><?php echo $OsDados->OS_ID ?></div>
            </div>

            <div class="row">
                <span>EQUIPAMENTO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $OsDados->OS_EQUIPAMENT ?>
                </div>
            </div>

            <div class="row">
                <span>DEFEITO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $OsDados->OS_EQUIPAMENT ?>
                </div>
            </div>

            <div class="row">
                <span>SOLUÇÃO:</span>
                <div class="col-sm-12 BordaOs">             
                    <?php echo form_error('OS_DSC_SOLUC'); ?>
                    <textarea name="OS_DSC_SOLUC" rows="4"><?php echo set_value('OS_DSC_SOLUC', $OsDados->OS_DSC_SOLUC); ?></textarea>
                </div>
            </div>

            <div class="row">
                <span>DEPENDENCIA:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo form_error('OS_DSC_PENDENT'); ?>
                    <textarea name="OS_DSC_PENDENT" rows="4"><?php echo set_value('OS_DSC_PENDENT', $OsDados->OS_DSC_PENDENT); ?></textarea>
                </div>
            </div>

            <div class="row">
                <span>OBSERVAÇÃO:</span>
                <div class="col-sm-12 BordaOs">
                    <?php echo $OsDados->OS_OBSERVACAO; ?>
                </div>
            </div><br>

            <div class="row">
                <div class="col-sm-6 pull-left">
                    <?php echo form_dropdown('OS_ESTATUS', array('1' => 'ABERTO', '2' => 'PENDENTE', '3' => 'CONCLUIDO'), set_value('OS_ESTATUS', $Estatus->OS_ESTATUS)); ?>
                </div>
                <div class="col-sm-6 pull-right">
                    <input type="hidden" value="<?php echo $OsDados->OS_ID; ?>" name="id_os" />
                    <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                </div>
            </div>

        </div>

    </div>

</form>
