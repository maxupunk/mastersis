<form action="<?php echo base_url('relatorios/vendas'); ?>" method="post" name="grava" accept-charset="utf-8">

    <fieldset>

        <?php
        if (isset($mensagem) and $mensagem != NULL)
            echo '<div class="alert alert-info">' . $mensagem . '</div>';
        ?>

        <div class="row">
            <div class="col-sm-3">
                <label>Venda por</label>
                <?php
                echo form_dropdown('tipo', array(
                    'f' => 'Funcionario',
                    'e' => 'Estatus',
                    'f' => 'Forma PG',
                    'l' => 'Local'
                        ), set_value('tipo', 'f'));
                ?>
            </div>
            <div class="col-sm-2">
                <label>Tipo</label>
                <?php
                echo form_dropdown('LstTotal', array(
                    'l' => 'Lista',
                    't' => 'Total',
                        ), set_value('LstTotal', "p"));
                ?>
            </div>
            <div class="col-sm-3">
                <label>de</label>
                <input type="text" class="data" name="DataInicial" value="<?php echo set_value('DataInicial'); ?>"/>
            </div>
            <div class="col-sm-3">
                <label>ate</label>
                <input type="text" class="data" name="DataFinal" value="<?php echo set_value('DataFinal'); ?>"/>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Prosseguir</button>
        <input type="reset" class="btn btn-warning" value="Limpar"/>

    </fieldset>

</form>