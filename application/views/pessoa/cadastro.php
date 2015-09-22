<form action="<?php echo base_url('pessoa'); ?>" method="post" class="form-inline" name="grava" accept-charset="utf-8">
    <fieldset>

        <?php
        if (isset($mensagem) and $mensagem != NULL) {
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
            die();
        }
        ?>

        <?php echo validation_errors(); ?>

        <div class="well-sm">
            <div class="row">
                <div class="col-sm-3">
                    <label>Tipo *:</label>
                    <?php echo form_dropdown('PES_TIPO', array('f' => 'FISICA', 'j' => 'JURIDICA'), $this->input->post('PES_TIPO'), 'id="pessoa_tipo" autofocus'); ?>
                </div>
                <div class="col-sm-5">
                    <label class="cpf-cnpj-label">C.P.F *:</label>
                    <input type="text" name="PES_CPF_CNPJ" value="<?php echo set_value('PES_CPF_CNPJ'); ?>" class="cpf" id="cpf-cnpj" required />
                </div>
                <div class="col-sm-4">
                    <label>Dt.Nasc.:</label>
                    <input type="text" class="data" name="PES_NASC_DATA" value="<?php echo set_value('PES_NASC_DATA'); ?>"/>
                </div>
            </div>

            <label>Nome / Razão social:</label>
            <input type="text" name="PES_NOME" value="<?php echo set_value('PES_NOME'); ?>" required />

            <label>Nome do pai:</label>
            <input type="text" name="PES_NOME_PAI" value="<?php echo set_value('PES_NOME_PAI'); ?>" />

            <label>Nome da mãe:</label>
            <input type="text" name="PES_NOME_MAE" value="<?php echo set_value('PES_NOME_MAE'); ?>" />
        </div>

        <div class="well-sm">
            <div class="row">
                <div class="col-sm-4">
                    <label>Telefone:</label>
                    <input type="text" name="PES_FONE" value="<?php echo set_value('PES_FONE'); ?>" class="fone" />
                </div>
                <div class="col-sm-4">
                    <label>Celular 1 *:</label>
                    <input type="text" name="PES_CEL1" value="<?php echo set_value('PES_CEL1'); ?>" class="fone" required />
                </div>
                <div class="col-sm-4">
                    <label>Celular 2:</label>
                    <input type="text" name="PES_CEL2" value="<?php echo set_value('PES_CEL2'); ?>" class="fone" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label>E-MAIL:</label>
                    <input type="email" name="PES_EMAIL" value="<?php echo set_value('PES_EMAIL'); ?>"/>
                </div>
            </div>
        </div>

        <div class="well-sm">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    $options = array('' => 'Selecione o Estado');
                    foreach ($estados as $estado) {
                        $options[$estado->ESTA_ID] = $estado->ESTA_NOME;
                    }
                    echo form_dropdown('ESTA_ID', $options);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php echo form_dropdown('CIDA_ID'); ?>
                </div>
            </div>

            <label>Bairro:</label>
            <div class="row">
                <div class="col-sm-9">
                    <?php echo form_dropdown('BAIRRO_ID'); ?>
                </div>
                <div class="col-sm-3">
                    <a href="endereco/bairro" class="btn btn-success" data-toggle="modal" data-target="#Modal">Add bairro</a>
                </div>
            </div>

            <label>Rua:</label>
            <div class="row">
                <div class="col-sm-9">
                    <?php echo form_dropdown('RUA_ID'); ?>
                </div>
                <div class="col-sm-3">
                    <a href="endereco/rua" class="btn btn-success" data-toggle="modal" data-target="#Modal">Add rua</a>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                    <label>Numero:</label>
                    <?php echo form_error('END_NUMERO'); ?>
                    <input type="text" name="END_NUMERO" value="<?php echo set_value('END_NUMERO'); ?>" />
                </div>
                <div class="col-sm-10"
                     <label>Referencia:</label>
                         <?php echo form_error('END_REFERENCIA'); ?>
                    <input type="text" name="END_REFERENCIA" value="<?php echo set_value('END_REFERENCIA'); ?>" />
                </div>
            </div>
        </div>

        <input type="hidden" name="PES_DATE" />

        <button type="submit" class="btn btn-primary">Salvar</button>
        <input type="reset" class="btn btn-warning" value="Limpar"/>

    </fieldset>
</form>

<script>
    $(document).ready(function () {

        $(document).on('change', 'select[name="ESTA_ID"]', function () {
            estado = $(this).val();
            if (estado === '')
                return false;
            $.getJSON('endereco/pegacidades/' + estado, function (data) {
                var option = new Array();
                $.each(data, function (i, obj) {
                    option[i] = document.createElement('option');
                    $(option[i]).attr({value: obj.CIDA_ID});
                    $(option[i]).append(obj.CIDA_NOME);
                });
                $('select[name="CIDA_ID"]').html(option);
            });
        });
        $(document).on('change', 'select[name="CIDA_ID"]', function () {
            bairro = $(this).val();
            if (bairro === '')
                return false;
            $.getJSON('endereco/pegabairros/' + bairro, function (data) {
                var option = new Array();
                $.each(data, function (i, obj) {
                    option[i] = document.createElement('option');
                    $(option[i]).attr({value: obj.BAIRRO_ID});
                    $(option[i]).append(obj.BAIRRO_NOME);
                });
                $('select[name="BAIRRO_ID"]').html(option);
            });
        });
        $(document).on('change', 'select[name="BAIRRO_ID"]', function () {
            rua = $(this).val();
            if (rua === '')
                return false;
            $.getJSON('endereco/pegaruas/' + rua, function (data) {
                var option = new Array();
                $.each(data, function (i, obj) {
                    option[i] = document.createElement('option');
                    $(option[i]).attr({value: obj.RUA_ID});
                    $(option[i]).append(obj.RUA_NOME);
                });
                $('select[name="RUA_ID"]').html(option);
            });
        });
        $(document).on('change', 'select[name="PES_TIPO"]', function () {
            if ($(this).val() === "f") {
                $('#cpf-cnpj').attr("class", "cpf");
                $('.cpf-cnpj-label').html('CPF *:');
                $('input[name="PES_NASC_DATA"]').prop('disabled', false);
                $('input[name="PES_NOME_PAI"]').prop('disabled', false);
                $('input[name="PES_NOME_MAE"]').prop('disabled', false);
                $('input[name="PES_NASC_DATA"]').prop('required', true);
            } else {
                $('#cpf-cnpj').attr("class", "cnpj");
                $('.cpf-cnpj-label').html('CNPJ *:');
                $('input[name="PES_NASC_DATA"]').prop('disabled', true);
                $('input[name="PES_NOME_PAI"]').prop('disabled', true);
                $('input[name="PES_NOME_MAE"]').prop('disabled', true);
                $('input[name="PES_NASC_DATA"]').empty();
                $('input[name="PES_NOME_PAI"]').empty();
                $('input[name="PES_NOME_MAE"]').empty();
                $('input[name="PES_NASC_DATA"]').prop('required', false);
            }
            $(".cpf-cnpj").focus();
        });

    });
</script>