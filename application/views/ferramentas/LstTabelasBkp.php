<div class="row">
    <h5>Selecone a Tabela que deseja fazer backup</h5>
</div>
<div class="row">
    <ul class="relatorio-list">
        <li>
            <span class="titulo">TODAS</span>
        </li>
        <?php foreach ($tabelas as $tabela) { ?>
            <li>
                <span class="titulo"><?php echo $tabela ?></span>
            </li>
        <?php } ?>
    </ul>
</div>