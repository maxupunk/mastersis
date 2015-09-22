<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation"><!-- INICIO DO MENU -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cel">
                <i class="glyphicon glyphicon-th-list"></i>
            </button>
            <div class="navbar-brand"> MasterSis<i class="glyphicon glyphicon-leaf"></i>
                <div class="progress progresso">
                    <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse navbar-cel centraliza-menu">
            <ul class="nav navbar-nav side-nav">
                <li><?php echo anchor('cadastros', 'Cadastros'); ?></li>

                <li><?php echo anchor('venda', 'Vendas'); ?></li>

                <li><?php echo anchor('ordemservico', 'Serviços'); ?></li>

                <li><?php echo anchor('compras', 'Compras'); ?></li>

                <li><?php echo anchor('financeiro', 'Financeiro'); ?></li>

                <li><?php echo anchor('relatorios', 'Relatorios'); ?></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Outros</a>
                    <ul class="dropdown-menu">
                        <li><a href="permissoes">permissoes</a></li>
                        <li><a href="ferramentas">Ferramentas</a></li>
                        <li><a href="#">Configuraçoes</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Perfil</a></li>
                        <li>
                            <?php
                            if ($this->session->userdata('USUARIO_APELIDO') != "") {
                                echo anchor('home/logout', 'Logout');
                            }
                            ?>
                        </li>
                        <li><a href="#">Ajuda</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav><!-- FIM DO MENU -->

    <div class="container" id="corpo">