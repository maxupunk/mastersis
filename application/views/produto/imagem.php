<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">

<?php
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
    <div class="col-lg-12">
        <form action="<?php echo base_url('produto'); ?>/imagem/<?php echo $id_produto; ?>" method="post" name="form-data" accept-charset="utf-8" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo $query->PRO_DESCRICAO ?></legend>

                <?php
                if (isset($upload))
                    print_r($upload);
                if (isset($thumb))
                    print_r($thumb);
                if (isset($mensagem) and $mensagem != NULL)
                    echo '<div class="alert alert-info">' . $mensagem . '</div>';
                ?>
                <label class="file_input_button"><span>Click para seleciona arquivo!</span>
                    <input type="file" name="userfile" id="ArqUpload" />
                </label>
                <input type="hidden" value="<?php echo $id_produto; ?>" name="id_produto"/>
            </fieldset>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <ul class="imagem-list">
            <?php if($imagens == null){
                echo "<p align='center'>Sem imagens</p>";
            }
            foreach ($imagens as $imagem) : ?>
                <li>
                    <img src="assets/arquivos/produto/<?php echo $imagem->PROIMG_NOME ?>">
                    <a href="<?php echo base_url('produto'); ?>/ImagemCapa/<?php echo $id_produto; ?>/<?php echo $imagem->PROIMG_NOME ?>" class="glyphicon glyphicon-ok" id="ImagemCapa" aria-hidden="true"></a>
                    <a href="<?php echo base_url('produto'); ?>/ImagemExcluir/<?php echo $imagem->PROIMG_ID ?>" class="glyphicon glyphicon-trash" id="ImagemExcluir" aria-hidden="true"></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    // compoetamento excluir e padrão
    $(document).on('click', '#ImagemCapa', function () {
        var href = $(this).attr('href');
        $.getJSON(href, function (data) {
            if (data.msg !== undefined) {
                MensagemModal(data.msg);
                $('#Modal').modal('show');
            }
        }
        );
        return false;
    });
    // compoetamento excluir e padrão
    $(document).on('click', '#ImagemExcluir', function () {
        var href = $(this).attr('href');
        $("#Modal .modal-content").load(href).css('text-align', 'center');
        $('#Modal').modal('show');
        return false;
    });

</script>