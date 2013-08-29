
INSERT INTO `BAIRROS` (`BAIRRO_ID`, `BAIRRO_NOME`, `CIDA_ID`) VALUES
(1, 'Centro', 703);

INSERT INTO `RUA` (`RUA_ID`, `RUA_NOME`, `RUA_CEP`, `BAIRRO_ID`) VALUES
(1, 'ANTUNINO CUNHA', '62120-000', 1);

INSERT INTO ENDERECOS (`END_ID`, `END_NUMERO`, `END_REFERENCIA`, `RUA_ID`) VALUES (1, 100, '', 1);
INSERT INTO ENDERECOS (`END_ID`, `END_NUMERO`, `END_REFERENCIA`, `RUA_ID`) VALUES (2, 100, '', 1);

INSERT INTO PESSOAS (`PES_ID`, `PES_NOME`, `PES_CPF_CNPJ`, `PES_NOME_PAI`, `PES_NOME_MAE`, `PES_NASC_DATA`, `PES_FONE`, `PES_CEL1`, `PES_CEL2`, `END_ID`, `PES_TIPO`, `PES_ESTATUS`, `PES_DATA`, `PES_EMAIL`) VALUES (1, 'ADMINISTRADOR', '000.000.000-00', 'ADMIN', 'ADMIN', '2013-08-17', '', '(00)0000-0000', '', 1, 'f', NULL, '2013-08-17 05:12:31', 'A@A');
INSERT INTO PESSOAS (`PES_ID`, `PES_NOME`, `PES_CPF_CNPJ`, `PES_NOME_PAI`, `PES_NOME_MAE`, `PES_NASC_DATA`, `PES_FONE`, `PES_CEL1`, `PES_CEL2`, `END_ID`, `PES_TIPO`, `PES_ESTATUS`, `PES_DATA`, `PES_EMAIL`) VALUES (2, 'MAXUEL ALCANTARA AGUIAR', '999.999.999-99', 'AA', 'AA', '1987-04-02', '', '(88)9221-4180', '', 2, 'f', NULL, '2013-08-23 07:17:25', 'A@A');

INSERT INTO `CARGOS` (`CARG_ID`, `CARG_NOME`) VALUES
(1, 'ADMINISTRADOR');

INSERT INTO `USUARIO` (`USUARIO_ID`, `CARG_ID`, `PES_ID`, `USUARIO_APELIDO`, `USUARIO_LOGIN`, `USUARIO_SENHA`, `USUARIO_ESTATUS`) VALUES
(1, 1, 1, 'ADMINISTRADOR', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'a');

INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (39, 'produto', 'cadastrar', 'produto/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (40, 'produto', 'listar', 'produto/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (41, 'produto', 'busca', 'produto/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (42, 'produto', 'editar', 'produto/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (43, 'produto', 'exibir', 'produto/exibir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (44, 'produto', 'imagem', 'produto/imagem', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (45, 'produto', 'excluir', 'produto/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (48, 'servico', 'cadastrar', 'servico/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (49, 'servico', 'listar', 'servico/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (50, 'servico', 'busca', 'servico/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (51, 'servico', 'editar', 'servico/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (52, 'servico', 'excluir', 'servico/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (54, 'pessoa', 'cadastrar', 'pessoa/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (55, 'pessoa', 'busca', 'pessoa/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (56, 'pessoa', 'editar', 'pessoa/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (57, 'pessoa', 'excluir', 'pessoa/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (60, 'permissoes', 'usuario', 'permissoes/usuario', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (64, 'permissoes', 'gerenciar', 'permissoes/gerenciar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (65, 'usuario', 'pegausuario', 'usuario/pegausuario', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (68, 'categoria', 'cadastrar', 'categoria/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (69, 'categoria', 'listar', 'categoria/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (70, 'categoria', 'busca', 'categoria/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (71, 'categoria', 'editar', 'categoria/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (72, 'categoria', 'imagem', 'categoria/imagem', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (75, 'medida', 'cadastrar', 'medida/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (77, 'medida', 'busca', 'medida/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (78, 'medida', 'editar', 'medida/editar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (79, 'medida', 'excluir', 'medida/excluir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (80, 'permissoes', 'inserir', 'permissoes/inserir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (81, 'permissoes', 'retirar', 'permissoes/retirar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (82, 'pessoa', 'pegapessoa', 'pessoa/pegapessoa', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (83, 'produto', 'pegaproduto', 'produto/pegaproduto', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (86, 'permissoes', 'remover', 'permissoes/remover', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (87, 'usuario', 'busca', 'usuario/busca', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (88, 'usuario', 'buscar', 'usuario/buscar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (89, 'usuario', 'cadastrar', 'usuario/cadastrar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (90, 'usuario', 'listar', 'usuario/listar', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (91, 'endereco', 'pegacidades', 'endereco/pegacidades', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (92, 'endereco', 'pegabairros', 'endereco/pegabairros', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (93, 'endereco', 'pegaruas', 'endereco/pegaruas', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (95, 'venda', 'assets', 'venda/assets', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (96, 'venda', 'pessoa', 'venda/pessoa', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (97, 'venda', 'abrir', 'venda/abrir', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (98, 'venda', 'avista', 'venda/avista', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (99, 'venda', 'cansela', 'venda/cansela', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (100, 'ferramentas', 'logsistema', 'ferramentas/logsistema', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (102, 'permissoes', 'assets', 'permissoes/assets', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (103, 'medida', 'index', 'medida/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (104, 'categoria', 'index', 'categoria/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (105, 'endereco', 'index', 'endereco/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (106, 'permissoes', 'index', 'permissoes/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (107, 'usuario', 'index', 'usuario/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (108, 'pessoa', 'index', 'pessoa/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (109, 'servico', 'index', 'servico/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (110, 'produto', 'index', 'produto/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (111, 'venda', 'index', 'venda/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (112, 'venda', 'addproduto', 'venda/addproduto', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (113, 'venda', 'fecha_pedido', 'venda/fecha_pedido', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (114, 'configuracoes', 'index', 'configuracoes/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (115, 'home', 'index', 'home/index', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (116, 'home', 'login', 'home/login', 0);
INSERT INTO METODOS (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES (117, 'home', 'dologin', 'home/dologin', 0);




INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (511, 1, 72);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (512, 1, 71);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (513, 1, 68);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (514, 1, 78);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (515, 1, 66);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (516, 1, 79);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (518, 1, 77);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (519, 1, 64);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (520, 1, 75);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (521, 1, 59);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (522, 1, 80);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (523, 1, 81);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (524, 1, 82);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (525, 1, 54);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (526, 1, 60);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (527, 1, 57);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (528, 1, 56);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (529, 1, 45);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (530, 1, 41);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (531, 1, 42);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (532, 1, 43);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (533, 1, 53);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (534, 1, 55);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (535, 1, 83);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (536, 1, 37);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (537, 1, 49);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (539, 1, 39);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (540, 1, 51);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (541, 1, 50);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (542, 1, 52);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (543, 1, 84);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (544, 1, 65);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (545, 1, 40);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (546, 1, 46);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (547, 1, 44);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (548, 1, 76);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (549, 1, 69);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (554, 1, 70);
INSERT INTO PERMISSOES (`PERM_ID`, `USUARIO_ID`, `METOD_ID`) VALUES (555, 1, 86);


INSERT INTO MEDIDAS (`MEDI_ID`, `MEDI_NOME`, `MEDI_SIGLA`) VALUES (1, 'UNIDADE', 'UN');

INSERT INTO CATEGORIA (`CATE_ID`, `CATE_NOME`, `CATE_DESCRIC`, `CATE_IMG`, `CATE_ESTATUS`) VALUES (1, 'ARMAZENAMNETO', NULL, NULL, 'a');
INSERT INTO CATEGORIA (`CATE_ID`, `CATE_NOME`, `CATE_DESCRIC`, `CATE_IMG`, `CATE_ESTATUS`) VALUES (2, 'HARDWARE', '', '2.jpg', NULL);

INSERT INTO PRODUTOS (`PRO_ID`, `PRO_DESCRICAO`, `PRO_CARAC_TEC`, `PRO_ESTATUS`, `CATE_ID`, `MEDI_ID`, `PRO_IMG`, `PRO_PESO`) VALUES (1, 'PENDRIVER KINGSTONE 16GB', '', 'a', 1, 1, '1.jpg', '0.200');
INSERT INTO PRODUTOS (`PRO_ID`, `PRO_DESCRICAO`, `PRO_CARAC_TEC`, `PRO_ESTATUS`, `CATE_ID`, `MEDI_ID`, `PRO_IMG`, `PRO_PESO`) VALUES (2, 'PLACA MAE GIGABITE 775 1333 S/V/R', '', 'a', 2, 1, NULL, '1.000');

INSERT INTO ESTOQUE (`ESTOQ_ID`, `PRO_ID`, `ESTOQ_ATUAL`, `ESTOQ_MIN`, `ESTOQ_CUSTO`, `ESTOQ_PRECO`) VALUES (1, 1, '92.00', '3.00', '15.00', '22.00');
INSERT INTO ESTOQUE (`ESTOQ_ID`, `PRO_ID`, `ESTOQ_ATUAL`, `ESTOQ_MIN`, `ESTOQ_CUSTO`, `ESTOQ_PRECO`) VALUES (2, 2, '96.00', '10.00', '200.00', '280.00');
