
INSERT INTO `BAIRROS` (`BAIRRO_ID`, `BAIRRO_NOME`, `CIDA_ID`) VALUES
(1, 'Centro', 703);

INSERT INTO `RUA` (`RUA_ID`, `RUA_NOME`, `RUA_CEP`, `BAIRRO_ID`) VALUES
(1, 'ANTUNINO CUNHA', '62120-000', 1);

INSERT INTO `ENDERECOS` (`END_ID`, `END_NUMERO`, `END_REFERENCIA`, `RUA_ID`) VALUES
(1, 100, '', 1);

INSERT INTO `PESSOAS` (`PES_ID`, `PES_NOME`, `PES_CPF_CNPJ`, `PES_NOME_PAI`, `PES_NOME_MAE`, `PES_NASC_DATA`, `PES_FONE`, `PES_CEL1`, `PES_CEL2`, `END_ID`, `PES_TIPO`, `PES_ESTATUS`, `PES_DATA`, `PES_EMAIL`) VALUES
(1, 'ADMINISTRADOR', '000.000.000-00', 'ADMIN', 'ADMIN', '2013-08-17', '', '(00)0000-0000', '', 1, 'f', NULL, '2013-08-17 05:12:31', 'A@A');

INSERT INTO `CARGOS` (`CARG_ID`, `CARG_NOME`) VALUES
(1, 'ADMINISTRADOR');

INSERT INTO `USUARIO` (`USUARIO_ID`, `CARG_ID`, `PES_ID`, `USUARIO_APELIDO`, `USUARIO_LOGIN`, `USUARIO_SENHA`, `USUARIO_ESTATUS`) VALUES
(1, 1, 1, 'ADMINISTRADOR', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'a');

INSERT INTO `METODOS` (`METOD_ID`, `METOD_CLASS`, `METOD_METODO`, `METOD_APELIDO`, `METOD_PRIVADO`) VALUES
(1, 'pessoa', 'index', 'pessoa/index', 0),
(2, 'produto', 'index', 'produto/index', 0),
(3, 'servico', 'index', 'servico/index', 0),
(4, 'endereco', 'index', 'endereco/index', 0),
(5, 'categoria', 'index', 'categoria/index', 0),
(6, 'medida', 'index', 'medida/index', 0),
(7, 'endereco', 'pegacidades', 'endereco/pegacidades', 0),
(8, 'produto', 'pegaproduto', 'produto/pegaproduto', 0),
(9, 'produto', 'cadastrar', 'produto/cadastrar', 0),
(10, 'produto', 'listar', 'produto/listar', 0),
(11, 'servico', 'cadastrar', 'servico/cadastrar', 0),
(12, 'servico', 'listar', 'servico/listar', 0),
(13, 'servico', 'busca', 'servico/busca', 0),
(14, 'produto', 'busca', 'produto/busca', 0),
(15, 'categoria', 'cadastrar', 'categoria/cadastrar', 0),
(16, 'categoria', 'listar', 'categoria/listar', 0),
(17, 'medida', 'cadastrar', 'medida/cadastrar', 0),
(18, 'medida', 'busca', 'medida/busca', 0),
(19, 'categoria', 'busca', 'categoria/busca', 0),
(20, 'produto', 'editar', 'produto/editar', 0),
(21, 'produto', 'exibir', 'produto/exibir', 0),
(22, 'produto', 'imagem', 'produto/imagem', 0),
(23, 'produto', 'excluir', 'produto/excluir', 0),
(24, 'servico', 'editar', 'servico/editar', 0),
(25, 'servico', 'excluir', 'servico/excluir', 0),
(26, 'categoria', 'editar', 'categoria/editar', 0),
(27, 'categoria', 'imagem', 'categoria/imagem', 0),
(28, 'usuario', 'index', 'usuario/index', 0),
(29, 'permissoes', 'index', 'permissoes/index', 0),
(30, 'permissoes', 'pegausuario', 'permissoes/pegausuario', 0),
(31, 'permissoes', 'permissoes', 'permissoes/permissoes', 0),
(32, 'permissoes', 'assets', 'permissoes/assets', 0),
(33, 'permissoes', 'abrir', 'permissoes/abrir', 0);

INSERT INTO `PERMISSOES` (`USUARIO_ID`, `METOD_ID`) VALUES
( 1, 1),
( 1, 2),
( 1, 3),
( 1, 4),
( 1, 5),
( 1, 6),
( 1, 7),
( 1, 8),
( 1, 9),
( 1, 10),
( 1, 11),
( 1, 12),
( 1, 13),
( 1, 14),
( 1, 15),
( 1, 16),
( 1, 17),
( 1, 18),
( 1, 19),
( 1, 20),
( 1, 21),
( 1, 22),
( 1, 23),
( 1, 24),
( 1, 25),
( 1, 26),
( 1, 27),
( 1, 28),
( 1, 29),
( 1, 30),
( 1, 31),
( 1, 32),
( 1, 33),
( 1, 34),
( 1, 35),
( 1, 36),
( 1, 37),
( 1, 38);
