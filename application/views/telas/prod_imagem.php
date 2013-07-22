<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">

<?php
$id_produto = $this->uri->segment(3);


if ($id_produto == NULL):
    echo '<div class="alert alert-success">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row();

if ($query == null):
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;

?>


<div class="row">
    <form action="<?php echo base_url('produto'); ?>/imagem/<?php echo $id_produto; ?>" method="post" id="upload_img" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
            <legend><?php echo $query->PRO_DESCRICAO ?></legend>

            <?php
            if (isset($upload))
                print_r($upload);
            if (isset($thumb))
                print_r($thumb);
            if (isset($mensagem))
                echo $mensagem;
            ?>

            <input type="file" class="btn" name="userfile" />
            <input type="hidden" value="<?php echo $id_produto; ?>" name="id_produto" />
            <button type="submit" id="img_botao" class="btn">Adiciona/Alterar</button>
        </fieldset>
    </form>
    <p>Obs.: Se já exista uma imagem a mesma será substituida.</p>
</div>

<div class="row">
<?php if ($query->PRO_IMG != NULL) echo '<img src="' . APPPATH . 'views/img_produto/' . $query->PRO_IMG . '" >' ?>
</div>