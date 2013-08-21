<?php
$id_produto = $this->uri->segment(3);

if ($id_produto == NULL):
    echo '<div class="alert alert-error">ERRO NA URL! Tente novamente.</div?>';
    exit();
endif;

$query = $this->crud_model->pega("PRODUTOS", array('PRO_ID' => $id_produto))->row();
if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe!</div>';
    exit();
endif;

$query->PRO_IMG != null ? $img = $query->PRO_IMG : $img = "sem_img.gif";
?>


<div class="thumbnail">
    <center><h3><?php echo $query->PRO_DESCRICAO ?></h3></center>
    <img src="<? echo 'assets/img_produto/' . $img ?>">
    <div class="caption">
        VALOR:
        <pre><?php echo $query->PRO_CARAC_TEC ?></pre>
    </div>
</div>
