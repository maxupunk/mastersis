<?php
$id_produto = $this->uri->segment(3);

if ($id_produto == NULL):
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>ERRO NA URL! Tente novamente.</div?>';
    exit();
endif;

setlocale(LC_MONETARY, 'pt_BR');
            
$query = $this->produto_model->pega_id($id_produto)->row();

if ($query == null) :
        echo '<div class="alert alert-error">Esse item não existe!</div>';
    else:

$query->PRO_IMG != null ? $img = $query->PRO_IMG : $img = "sem_img.jpg";

?>



<ul class="thumbnails">
    <li class="span6">
        <hr>
        <div class="thumbnail">
            <center><h3><?php echo $query->PRO_DESCRICAO ?></h3></center>
            <img src="<? echo APPPATH . 'views/produto_img/' . $img ?>">
            <div class="caption">
                VALOR: <?php echo money_format('%.2n', $query->PRO_VAL_VEND); ?>
                <p><pre><?php echo $query->PRO_CARAC_TEC ?></pre></p>
            </div>
        </div>
    </li>
</ul>
<?php endif; ?>