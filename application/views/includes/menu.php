<div class="container">

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation"><!-- INICIO DO MENU -->
        <div class="centraliza-menu">
            <ul class="nav navbar-nav"><!-- MENU DROPDOWN -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus-sign"></span></a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"><?php echo $this->lang->line("menu_cadastro"); ?></li>
                        <li><? echo anchor('produto', $this->lang->line("menu_cad_produto")); ?></li>
                        <li><? echo anchor('servico', $this->lang->line("menu_cad_servico")); ?></li>
                        <li class="divider"></li>
                        <li><? echo anchor('pessoa', $this->lang->line("menu_cad_pessoa")); ?></a></li>
                        <li><? echo anchor('usuario', $this->lang->line("menu_cad_usario")); ?></li>
                        <li><? echo anchor('permissoes', $this->lang->line("menu_cad_permissoes")); ?></li>
                        <li class="divider"></li>
                        <li><? echo anchor('endereco', $this->lang->line("menu_cad_endereco")); ?></li>
                        <li><? echo anchor('categoria', $this->lang->line("menu_cad_categoria")); ?></li>
                        <li><? echo anchor('medida', $this->lang->line("menu_cad_unid_medida")); ?></li>
                        <li class="divider"></li>
                        <li><? echo anchor('avaria', $this->lang->line("menu_cad_avaria")); ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <? echo anchor('venda', '<span class="glyphicon glyphicon-barcode">', 'class="dropdown-toggle"'); ?>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-wrench"></span></a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"><?php echo $this->lang->line("menu_ordem_servico"); ?></li>
                        <li><? echo anchor('ordemservico', $this->lang->line("menu_ordem_dash")); ?></li>
                        <li><? echo anchor('ordemservico/abrir', $this->lang->line("menu_ordem_abrir")); ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span></a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"><?php echo $this->lang->line("menu_compras"); ?></li>
                        <li><a href="#">Fazer Compra</a></li>
                        <li><a href="#">Lista Compras</a></li>
                        <li><a href="#">Receber Compra</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-credit-card"></span></a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"><?php echo $this->lang->line("menu_financeiro"); ?></li>
                        <li><a href="#">Contas a receber</a></li>
                        <li><a href="#">Contas a pagar</a></li>
                        <li><a href="#">Receita/Despesa avulsa</a></li>
                        <li><a href="#">Baixa pagamento</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-print"></span></a>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
                    <ul class="dropdown-menu">
                        <li class="titulo-menu"><?php echo $this->lang->line("menu_ferramentas"); ?></li>
                        <li><? echo anchor('home', $this->lang->line("menu_ferra_principal")); ?></li>
                        <li class="divider"></li>
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