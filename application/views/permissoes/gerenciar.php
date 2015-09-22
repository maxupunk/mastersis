<div class="row">
    <div class="col-sm-12">
        <h4 align="center">GERENCIANDO PERMISSÕES - <?php echo $usuario->USUARIO_LOGIN ?></h4><hr>
        <input type="hidden" id="id_usuario" value="<?php echo $usuario->USUARIO_ID ?>">
    </div>
</div>
<div class="row">
    <div class="col-sm-12" id="metodos">
        <?php
        $class_atual = "";
        foreach ($metodos as $linha) {

            $marcado = (in_array($linha->METOD_ID, $permissoes)) ? "checked" : null;

            if ($class_atual != $linha->METOD_CLASS) {
                $class_atual = $linha->METOD_CLASS;
                ?>

                <legend class="titulo-permissoes"><?php echo $class_atual; ?></legend>

                <?php
            }
            ?>

            <label class="permissao">
                <input type="checkbox" class="metodo" value="<?php echo $linha->METOD_ID; ?>" <?php echo $marcado; ?> />
                <?php echo $linha->METOD_DESCR == null ? $linha->METOD_METODO : $linha->METOD_DESCR; ?>
            </label>

            <?php
        }
        ?>
    </div>
</div>
