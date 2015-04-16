<?php
if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>
<form method="post" action="<?php echo base_url('pessoa'); ?>/editar/<?php echo $query->PES_ID ?>" name="grava" accept-charset="utf-8">

    <fieldset>

        <legend>EDIÇÃO DE PESSOA</legend>


        <?php
        if (isset($mensagem) and $mensagem != NULL) echo '<div class="alert alert-info">' . $mensagem . '</div>';
        echo validation_errors();
        ?>


            <div class="well">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Tipo *:</label>
                        <?php echo form_dropdown('PES_TIPO', array('f' => 'FISICA', 'j' => 'JURIDICA'), $query->PES_TIPO, 'id="pessoa_tipo" autofocus'); ?>
                    </div>
                    <div class="col-sm-5">
                        <label class="cpf-cnpj-label">C.P.F *:</label>
                        <input type="text" name="PES_CPF_CNPJ" value="<?php echo set_value('PES_CPF_CNPJ', $query->PES_CPF_CNPJ); ?>" class="cpf-cnpj" required />
                    </div>
                    <div class="col-sm-4">
                        <label>Dt.Nasc.:</label>
                        <input type="text" name="PES_NASC_DATA" value="<?php echo set_value('PES_NASC_DATA', $query->PES_NASC_DATA); ?>" class="data" <?php if ($query->PES_TIPO == "j") echo 'disabled="disabled"'; ?>/>
                    </div>
                </div>

                <label>Nome:</label>
                <input type="text" name="PES_NOME" value="<?php echo set_value('PES_NOME', $query->PES_NOME); ?>" required />

                <label>Nome do pai:</label>
                <input type="text" name="PES_NOME_PAI" value="<?php echo set_value('PES_NOME_PAI', $query->PES_NOME_PAI); ?>" <?php if ($query->PES_TIPO == "j") echo 'disabled="disabled"'; ?> />

                <label>Nome da mãe:</label>
                <input type="text" name="PES_NOME_MAE" value="<?php echo set_value('PES_NOME_MAE', $query->PES_NOME_MAE); ?>" <?php if ($query->PES_TIPO == "j") echo 'disabled="disabled"'; ?> />


            </div>


            <div class="well">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Telefone:</label>
                        <input type="text" name="PES_FONE" value="<?php echo set_value('PES_FONE', $query->PES_FONE); ?>" class="fone" />
                    </div>
                    <div class="col-sm-4">
                        <label>Celular 1 *:</label>
                        <input type="text" name="PES_CEL1" value="<?php echo set_value('PES_CEL1', $query->PES_CEL1); ?>" class="fone" required />
                    </div>
                    <div class="col-sm-4">
                        <label>Celular 2:</label>
                        <input type="text" name="PES_CEL2" value="<?php echo set_value('PES_CEL2', $query->PES_CEL2); ?>" class="fone" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label>E-MAIL:</label>
                        <input type="text" name="PES_EMAIL" value="<?php echo set_value('PES_EMAIL', $query->PES_EMAIL); ?>"/>
                    </div>
                </div>
            </div>

            <div class="well">
                <label>Numero:</label>
                <?php echo form_error('END_NUMERO'); ?>
                <input type="text" name="END_NUMERO" value="<?php echo set_value('END_NUMERO', $query->END_NUMERO); ?>" />

                <label>Ponto de referecnia:</label>
                <?php echo form_error('END_REFERENCIA'); ?>
                <input type="text" name="END_REFERENCIA" value="<?php echo set_value('END_REFERENCIA', $query->END_REFERENCIA); ?>" />

                <?php
                $options = array('' => 'Selecione o Estado');
                foreach ($estados as $estado)
                    $options[$estado->ESTA_ID] = $estado->ESTA_NOME;
                echo form_dropdown('ESTA_ID', $options);
                ?>

                <?php echo form_dropdown('CIDA_ID'); ?>

                <?php echo form_dropdown('BAIRRO_ID'); ?>

                <?php echo form_error('RUA_ID'); ?>
                <?php echo form_dropdown('RUA_ID', array($query->RUA_ID => $query->RUA_NOME), $query->RUA_ID); ?>
            </div>


        <?php echo form_dropdown('PES_ESTATUS', array('a' => 'Ativo', 'd' => 'Desativo'), set_value('PES_ESTATUS', $query->PES_ESTATUS)); ?>


        <input type="hidden" value="<?php echo $query->PES_ID ?>" name="id_pessoa" />
        <input type="hidden" value="<?php echo $query->END_ID; ?>" name="id_endereco" />

        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="reset" class="btn btn-warning" value="Limpar"/>
        </div>
        
    </fieldset>
</form>