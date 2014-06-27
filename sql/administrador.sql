
INSERT INTO `BAIRROS` (`BAIRRO_ID`, `BAIRRO_NOME`, `CIDA_ID`) VALUES
(1, 'Centro', 703);

INSERT INTO `RUAS` (`RUA_ID`, `RUA_NOME`, `RUA_CEP`, `BAIRRO_ID`) VALUES
(1, 'ANTUNINO CUNHA', '62120-000', 1);

INSERT INTO ENDERECOS (`END_ID`, `END_NUMERO`, `END_REFERENCIA`, `RUA_ID`) VALUES (1, 100, '', 1);
INSERT INTO ENDERECOS (`END_ID`, `END_NUMERO`, `END_REFERENCIA`, `RUA_ID`) VALUES (2, 100, '', 1);

INSERT INTO PESSOAS (`PES_ID`, `PES_NOME`, `PES_CPF_CNPJ`, `PES_NOME_PAI`, `PES_NOME_MAE`, `PES_NASC_DATA`, `PES_FONE`, `PES_CEL1`, `PES_CEL2`, `END_ID`, `PES_TIPO`, `PES_ESTATUS`, `PES_DATA`, `PES_EMAIL`) VALUES (1, 'ADMINISTRADOR', '000.000.000-00', 'ADMIN', 'ADMIN', '2013-08-17', '', '(00)0000-0000', '', 1, 'f', NULL, '2013-08-17 05:12:31', 'A@A');
INSERT INTO PESSOAS (`PES_ID`, `PES_NOME`, `PES_CPF_CNPJ`, `PES_NOME_PAI`, `PES_NOME_MAE`, `PES_NASC_DATA`, `PES_FONE`, `PES_CEL1`, `PES_CEL2`, `END_ID`, `PES_TIPO`, `PES_ESTATUS`, `PES_DATA`, `PES_EMAIL`) VALUES (2, 'MAXUEL ALCANTARA AGUIAR', '999.999.999-99', 'AA', 'AA', '1987-04-02', '', '(88)9221-4180', '', 2, 'f', NULL, '2013-08-23 07:17:25', 'A@A');

INSERT INTO `CARGOS` (`CARG_ID`, `CARG_NOME`) VALUES
(1, 'ADMINISTRADOR');

INSERT INTO `USUARIOS` (`USUARIO_ID`, `CARG_ID`, `PES_ID`, `USUARIO_APELIDO`, `USUARIO_LOGIN`, `USUARIO_SENHA`, `USUARIO_ESTATUS`) VALUES
(1, 1, 1, 'ADMINISTRADOR', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'a');

INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (152, 'produto', 'index', 'produto/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (153, 'produto', 'cadastrar', 'produto/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (154, 'produto', 'listar', 'produto/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (155, 'produto', 'busca', 'produto/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (156, 'produto', 'editar', 'produto/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (157, 'produto', 'excluir', 'produto/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (158, 'produto', 'exibir', 'produto/exibir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (159, 'produto', 'imagem', 'produto/imagem', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (160, 'servico', 'index', 'servico/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (161, 'servico', 'cadastrar', 'servico/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (162, 'servico', 'listar', 'servico/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (163, 'servico', 'busca', 'servico/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (164, 'servico', 'editar', 'servico/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (165, 'servico', 'excluir', 'servico/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (166, 'pessoa', 'index', 'pessoa/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (169, 'pessoa', 'cadastrar', 'pessoa/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (170, 'pessoa', 'busca', 'pessoa/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (171, 'pessoa', 'editar', 'pessoa/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (172, 'pessoa', 'excluir', 'pessoa/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (173, 'usuario', 'index', 'usuario/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (174, 'usuario', 'listar', 'usuario/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (175, 'usuario', 'cadastrar', 'usuario/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (176, 'pessoa', 'pegapessoa', 'pessoa/pegapessoa', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (177, 'usuario', 'busca', 'usuario/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (178, 'usuario', 'editar', 'usuario/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (179, 'permissoes', 'index', 'permissoes/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (180, 'usuario', 'pegausuario', 'usuario/pegausuario', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (181, 'permissoes', 'gerenciar', 'permissoes/gerenciar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (182, 'permissoes', 'inserir', 'permissoes/inserir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (183, 'permissoes', 'retirar', 'permissoes/retirar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (184, 'endereco', 'index', 'endereco/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (185, 'endereco', 'bairro', 'endereco/bairro', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (186, 'endereco', 'rua', 'endereco/rua', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (187, 'endereco', 'pegacidades', 'endereco/pegacidades', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (188, 'endereco', 'pegabairros', 'endereco/pegabairros', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (189, 'endereco', 'pegaruas', 'endereco/pegaruas', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (190, 'endereco', 'busca', 'endereco/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (194, 'categoria', 'index', 'categoria/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (195, 'categoria', 'cadastrar', 'categoria/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (196, 'categoria', 'listar', 'categoria/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (197, 'categoria', 'busca', 'categoria/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (198, 'categoria', 'editar', 'categoria/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (199, 'categoria', 'imagem', 'categoria/imagem', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (200, 'medida', 'index', 'medida/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (203, 'medida', 'cadastrar', 'medida/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (204, 'medida', 'busca', 'medida/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (205, 'medida', 'editar', 'medida/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (206, 'medida', 'excluir', 'medida/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (207, 'venda', 'index', 'venda/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (208, 'venda', 'abrir', 'venda/abrir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (209, 'produto', 'pegaproduto', 'produto/pegaproduto', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (210, 'venda', 'addproduto', 'venda/addproduto', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (211, 'venda', 'avista', 'venda/avista', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (212, 'venda', 'atualizar', 'venda/atualizar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (213, 'venda', 'excluir', 'venda/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (214, 'venda', 'fecha_pedido', 'venda/fecha_pedido', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (215, 'venda', 'cansela', 'venda/cansela', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (216, 'home', 'index', 'home/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (219, 'configuracoes', 'index', 'configuracoes/index', 0);


INSERT INTO MEDIDAS (`MEDI_ID`, `MEDI_NOME`, `MEDI_SIGLA`) VALUES (1, 'UNIDADE', 'UN');

INSERT INTO CATEGORIAS (`CATE_ID`, `CATE_NOME`, `CATE_DESCRIC`, `CATE_IMG`, `CATE_ESTATUS`) VALUES (1, 'ARMAZENAMENTO', NULL, NULL, 'a');
INSERT INTO CATEGORIAS (`CATE_ID`, `CATE_NOME`, `CATE_DESCRIC`, `CATE_IMG`, `CATE_ESTATUS`) VALUES (2, 'HARDWARE', '', NULL, NULL);

INSERT INTO PRODUTOS (`PRO_ID`, `PRO_DESCRICAO`, `PRO_CARAC_TEC`, `PRO_ESTATUS`, `CATE_ID`, `MEDI_ID`, `PRO_IMG`, `PRO_PESO`, `PRO_TIPO`) VALUES (1, 'PENDRIVER KINGSTONE 16GB', '', 'a', 1, 1, NULL, '0.200', 'p');
INSERT INTO PRODUTOS (`PRO_ID`, `PRO_DESCRICAO`, `PRO_CARAC_TEC`, `PRO_ESTATUS`, `CATE_ID`, `MEDI_ID`, `PRO_IMG`, `PRO_PESO`, `PRO_TIPO`) VALUES (2, 'PLACA MAE GIGABITE 775 1333 S/V/R', '', 'a', 2, 1, NULL, '1.000', 'p');

INSERT INTO ESTOQUES (`ESTOQ_ID`, `PRO_ID`, `ESTOQ_ATUAL`, `ESTOQ_MIN`, `ESTOQ_CUSTO`, `ESTOQ_PRECO`) VALUES (1, 1, '92.00', '3.00', '15.00', '22.00');
INSERT INTO ESTOQUES (`ESTOQ_ID`, `PRO_ID`, `ESTOQ_ATUAL`, `ESTOQ_MIN`, `ESTOQ_CUSTO`, `ESTOQ_PRECO`) VALUES (2, 2, '96.00', '10.00', '200.00', '280.00');

INSERT INTO `EMPRESAS` (`EMPRE_ID`, `EMPRE_RAZAO`, `EMPRE_CNPJ`, `EMPRE_ESCR_ESTADUAL`, `EMPRE_FONE`, `EMPRE_FAX`, `EMPRE_EMAIL`, `EMPRE_SITE`, `EMPRE_NOME`, `EMPRE_SLOGAN`, `END_ID`) VALUES
(6, 'MAXUEL ALCANTARA AGUIAR 01629456390', '13.989.608/0001-32', 1111111, '(88)9221-4180', '(88)****-*****', 'contato@masternetinformatica.com.br', 'www.masternetinformatca.com.br', 'MasterNet informatica', 'Soluções Inteligentes.', 1);
