<?php
if (isset($mensagem) and $mensagem != NULL) {
    echo '<div class="alert alert-error">' . $mensagem . '</div>';
    exit();
}

if ($query == null) :
    echo '<div class="alert alert-error">Esse item não existe ou foi apagado!<div>';
    exit();
endif;

$query->PRO_IMG != null ? $img = $query->PRO_IMG : $img = "sem_img.gif";
?>


<div class="thumbnail">
    <center><h3><?php echo $query->PRO_DESCRICAO ?></h3></center>
    <img src="<? echo 'assets/arquivos/produto/' . $img ?>">
    <div class="caption">
        VALOR:
        <pre><?php echo $query->PRO_CARAC_TEC ?></pre>
    </div>
</div>
