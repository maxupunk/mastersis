<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">

<?php
$id_categoria = $this->uri->segment(3);


if ($id_categoria == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->crud_model->pega("CATEGORIA", array('CATE_ID' => $id_categoria))->row();

if ($query == null):
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;
?>


<div class="row">
    <div class="col-lg-12">
    <form action="<?php echo base_url('categoria'); ?>/imagem/<?php echo $id_categoria ?>" method="post" name="form-data" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
            <legend><?php echo $query->CATE_NOME; ?></legend>


            <?php
            if (isset($upload))
                print_r($upload);
            if (isset($thumb))
                print_r($thumb);
            if (isset($mensagem) and $mensagem != NULL)
                echo '<div class="alert alert-info">' . $mensagem . '</div>';
            ?>

            <label class="file_input_button">Click para seleciona arquivo!
                <input type="file" name="userfile" />
            </label>
            <input type="hidden" value="<?php echo $id_categoria; ?>" name="id_categoria" />
            <button type="submit" id="img_botao" class="btn btn-primary">Adiciona/Alterar</button>
        </fieldset>
    </form>
    <p>Obs.: Se já exista uma imagem a mesma será substituida.</p>
    </div>
</div>

<div class="row">
    <?php if ($query->CATE_IMG != NULL) echo '<img src="assets/img_categoria/' . $query->CATE_IMG . '" >' ?>
</div>