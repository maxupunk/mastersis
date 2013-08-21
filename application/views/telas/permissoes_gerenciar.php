<div class="row">
    <div class="col-sm-12">
        <h4 align="center">GERENCIANDO PERMISSÕES - <?php echo $usuario->USUARIO_LOGIN ?></h4><hr>
        <input type="hidden" id="id_usuario" value="<?php echo $usuario->USUARIO_ID ?>">
        <div align="center" id="retorno"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12" id="metodos">
        <?php
        $class_atual = "";
        foreach ($metodos as $linha) {

            if (in_array($linha->METOD_ID, $permissoes)) {
                $marcado = "checked";
            } else {
                $marcado = "";
            }

            if ($class_atual != $linha->METOD_CLASS) {
                $class_atual = $linha->METOD_CLASS;
                ?>

                <legend class="titulo-permissoes"><?php echo $class_atual; ?></legend>

                <?php
            }
            ?>

            <label class="permissao-class">
                <input type="checkbox" class="selecao" id="permissao" value="<?php echo $linha->METOD_ID; ?>" <?php echo $marcado; ?> />
                <?php echo $linha->METOD_METODO; ?>
            </label>

            <?php
        }
        ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/permissoes.js'); ?>"></script>