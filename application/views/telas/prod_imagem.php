<?php
$id_produto = $this->uri->segment(3);

if ($id_produto == NULL):
    echo '<div class="alert alert-success">ERRO NA URL! Tente novamente.</div>';
    exit();
endif;

$query = $this->produto_model->pega_id($id_produto)->row();

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
else:
    ?>

    <div class="row">
        <form action="<?php echo base_url('produto'); ?>/adiciona_img" method="post" id="upload_img" accept-charset="utf-8" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo $query->PRO_DESCRICAO ?></legend>
                <input type="file" class="btn" id="arq_select" name="userfile" />
                <input type="hidden" value="<?php echo $id_produto; ?>" name="id_produto" />
                <button type="submit" id="img_botao" class="btn">Aplicar imagem</button>
            </fieldset>
        </form>
    </div>

    <div class="row">
    <?php if ($query->PRO_IMG != NULL) echo '<img src="' . APPPATH . 'views/produto_img/' . $query->PRO_IMG . '" >' ?>
    </div>

<?php endif ?>