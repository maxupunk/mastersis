<div class="container">

    <div class="page-header">

        <div class="navbar"><!-- INICIO DO MENU -->
            <div class="navbar-inner">
                <ul class="nav"><!-- MENU DROPDOWN -->

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("menu_cadastro"); ?></a>
                        <ul class="dropdown-menu">
                            <li><? echo anchor('produto', $this->lang->line("menu_cad_produto")); ?></li>
                            <li><? echo anchor('servico', $this->lang->line("menu_cad_servico")); ?></li>
                            <li class="divider"></li>
                            <li><? echo anchor('cliente', $this->lang->line("menu_cad_cliente")); ?></a></li>
                            <li><? echo anchor('fornecedor', $this->lang->line("menu_cad_fornecedor")); ?></li>
                            <li><? echo anchor('usuario', $this->lang->line("menu_cad_usario")); ?></li>
                            <li class="divider"></li>
                            <li><? echo anchor('endereco', $this->lang->line("menu_cad_endereco")); ?></li>
                            <li><? echo anchor('categoria', $this->lang->line("menu_cad_categoria")); ?></li>
                            <li><? echo anchor('unidade_medida', $this->lang->line("menu_cad_unid_medida")); ?></li>
                            <li class="divider"></li>
                            <li><? echo anchor('avaria', $this->lang->line("menu_cad_avaria")); ?></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("menu_vendas"); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fazer Venda</a></li>
                            <li><a href="#">Busca Venda</a></li>
                            <li><a href="#">Cansela Venda</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Fazer orçamento</a></li>
                            <li><a href="#">Concluir orçamento</a></li>
                            <li><a href="#">Cansela orçamento</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("menu_ordem_servico"); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Abrir um OS</a></li>
                            <li><a href="#">Alterar/consulta OS</a></li>
                            <li><a href="#">Orçamento de serviços</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("menu_compras"); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fazer Compra</a></li>
                            <li><a href="#">Lista Compras</a></li>
                            <li><a href="#">Receber Compra</a></li>
                            <li><a href="#">Conselar compra</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("menu_financeiro"); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Contas a receber</a></li>
                            <li><a href="#">Contas a pagar</a></li>
                            <li><a href="#">Receita/Despesa avulsa</a></li>
                            <li><a href="#">Baixa pagamento</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("menu_relatorio"); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Vendas</a></li>
                            <li><a href="#">Compras</a></li>
                            <li><a href="#">Itens com estoue baixo</a></li>
                            <li><a href="#">Baixa pagamentos</a></li>
                            <li><a href="#">Clientes em atraso</a></li>
                        </ul>
                    </li>

                    <li><? echo anchor('configuracoes', $this->lang->line("menu_configuracoes")); ?></li>

                </ul>

            </div><!-- /navbar-inner -->
        </div><!-- FIM DO MENU -->
    </div>

    <div class="container">