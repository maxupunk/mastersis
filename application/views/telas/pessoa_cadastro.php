<script src="<?php echo base_url('assets/js/mascaras.js'); ?>"></script>
<form action="<?php echo base_url('pessoa'); ?>/cadastrar" method="post" class="form-inline" name="grava" accept-charset="utf-8">
    <fieldset>

        <legend>CADASTRO DE PESSOAS</legend>

        <?php
        if (isset($mensagem)) {
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
            exit();
        }
        ?>

        <?php echo validation_errors(); ?>

        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Pessoal</a></li>
                <li><a href="#tabs-2">Contatos</a></li>
                <li><a href="#tabs-3">Endereço</a></li>
            </ul>

            <div id="tabs-1" >
                <div class="row">
                    <div class="col-3">
                        <label>Tipo *:</label>
                        <?php echo form_dropdown('PES_TIPO', array('f' => 'FISICA', 'j' => 'JURIDICA'), $this->input->post('PES_TIPO'), 'id="pessoa_tipo" autofocus'); ?>
                    </div>
                    <div class="col-5">
                        <label class="cpf-cnpj-label">C.P.F *:</label>
                        <input type="text" name="PES_CPF_CNPJ" value="<?php echo set_value('PES_CPF_CNPJ'); ?>" class="cpf-cnpj" required />
                    </div>
                    <div class="col-4">
                        <label>Dt.Nasc.:</label>
                        <input type="text" name="PES_NASC_DATA" value="<?php echo set_value('PES_NASC_DATA'); ?>" class="data"/>
                    </div>
                </div>

                <label>Nome:</label>
                <input type="text" name="PES_NOME" value="<?php echo set_value('PES_NOME'); ?>" required />

                <label>Nome do pai:</label>
                <input type="text" name="PES_NOME_PAI" value="<?php echo set_value('PES_NOME_PAI'); ?>" />

                <label>Nome da mãe:</label>
                <input type="text" name="PES_NOME_MAE" value="<?php echo set_value('PES_NOME_MAE'); ?>" />
            </div>

            <div id="tabs-2">
                <div class="row">
                    <div class="col-4">
                        <label>Telefone:</label>
                        <input type="text" name="PES_FONE" value="<?php echo set_value('PES_FONE'); ?>" class="fone" />
                    </div>
                    <div class="col-4">
                        <label>Celular 1 *:</label>
                        <input type="text" name="PES_CEL1" value="<?php echo set_value('PES_CEL1'); ?>" class="fone" required />
                    </div>
                    <div class="col-4">
                        <label>Celular 2:</label>
                        <input type="text" name="PES_CEL2" value="<?php echo set_value('PES_CEL2'); ?>" class="fone" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label>E-MAIL:</label>
                        <input type="text" name="PES_EMAIL" value="<?php echo set_value('PES_EMAIL'); ?>"/>
                    </div>
                </div>
            </div>

            <div id="tabs-3">
                <?php
                $options = array('' => 'Selecione o Estado');
                foreach ($estados as $estado)
                    $options[$estado->ESTA_ID] = $estado->ESTA_NOME;
                echo form_dropdown('ESTA_ID', $options);
                ?>

                <?php echo form_dropdown('CIDA_ID'); ?>

                <?php echo form_dropdown('BAIRRO_ID'); ?>

                <?php echo form_dropdown('RUA_ID'); ?>

                <label>Numero:</label>
                    <?php echo form_error('END_NUMERO'); ?>
                    <input type="text" name="END_NUMERO" value="<?php echo set_value('END_NUMERO'); ?>" />

                <label>Referencia:</label>
                <?php echo form_error('END_REFERENCIA'); ?>
                <input type="text" name="END_REFERENCIA" value="<?php echo set_value('END_REFERENCIA'); ?>" />
            </div>
        </div>

        <input type="hidden" name="PES_DATE" />

        <br><button type="submit" class="btn">CADASTRAR</button>

    </fieldset>
</form>