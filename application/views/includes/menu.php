<div class="container">

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation"><!-- INICIO DO MENU -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cel">
                <span class="sr-only">Menu de navegação</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand"> MasterSis<i class="glyphicon glyphicon glyphicon-leaf"></i>
                <span class="carregando">.:Carragando:.</span>
            </div>
        </div>
        <div class="collapse navbar-collapse navbar-cel centraliza-menu">
            <ul class="nav navbar-nav side-nav"><!-- MENU DROPDOWN -->
                <li><? echo anchor('cadastros', 'Cadastros'); ?></li>

                <li><? echo anchor('venda', 'Vendas'); ?></li>

                <li><? echo anchor('ordemservico', 'O.S'); ?></li>

                <li><? echo anchor('compra', 'Compras'); ?></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Financeiros</a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"></li>
                        <li><a href="#">Contas a receber</a></li>
                        <li><a href="#">Contas a pagar</a></li>
                        <li><a href="#">Receita/Despesa avulsa</a></li>
                        <li><a href="#">Baixa pagamento</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatorios</a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"><?php echo $this->lang->line("menu_relatorio"); ?></li>
                        <li><a href="#">Vendas</a></li>
                        <li><a href="#">Compras</a></li>
                        <li><a href="#">Ordem de serviços</a></li>
                        <li><a href="#">Itens sem saida</a></li>
                        <li><a href="#">Itens com estoque baixo</a></li>
                        <li><a href="#">Pagamentos baixados</a></li>
                        <li><a href="#">Clientes em atraso</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configurações</a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"><?php echo $this->lang->line("menu_ferramentas"); ?></li>
                        <li><? echo anchor('home', $this->lang->line("menu_ferra_principal")); ?></li>
                        <li class="divider"></li>
                        <li><? echo anchor('permissoes', $this->lang->line("menu_cad_permissoes")); ?></li>
                        <li><? echo anchor('configuracoes', $this->lang->line("menu_ferra_config")); ?></li>
                        <li><? echo anchor('ferramentas/logsistema', $this->lang->line("menu_ferra_logsistema"), 'class="nocorpo"'); ?></li>
                        <li><a href="#">Log de acesso</a></li>
                        <li><? echo anchor('ferramentas/backup_db', $this->lang->line("menu_ferra_backup")); ?></li>
                        <li><? echo anchor('ferramentas/otimizar_db', $this->lang->line("menu_ferra_otimizar"), 'class="nocorpo"'); ?></li>
                        <li class="divider"></li>
                        <li><a href="#">Perfil</a></li>
                        <li>
                            <?php
                            if ($this->session->userdata('USUARIO_APELIDO') != "") {
                                echo anchor('home/logout', $this->lang->line("menu_ferra_logout")) . '';
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