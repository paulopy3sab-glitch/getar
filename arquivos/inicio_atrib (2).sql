/**
**
**/
CREATE TABLE `getar_atrib` (
  `codatrib` int(11) NOT NULL COMMENT 'codigo da atribuicao getar_topico',
  `nick` varchar(20) NOT NULL COMMENT 'Nick a receber a atribuicao - se tipo padroa: apenas para referencia na clonagem',
  `tipo` varchar(20) NOT NULL COMMENT 'padrao: apenas referencia - ativo: referente ao um nick cadastrado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Topico do sistema atribuido a um nick';
ALTER TABLE getar_atrib ADD CONSTRAINT `fk_nickatb` FOREIGN KEY (`nick`) REFERENCES `getar_control` (`nick`);
INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                  VALUES(1, 'admin', 'padrao'),
                        (2, 'admin', 'padrao'),
                        (3, 'admin', 'padrao');

CREATE TABLE `getar_topico` (
  `cod` int(11) NOT NULL PRIMARY KEY,
  `descr` varchar(120) NOT NULL COMMENT 'rapida descricao',
  `arquivos` varchar(160) COMMENT 'arquivos .php que o usam'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Topico do sistema a terem controle atribuido';
ALTER TABLE getar_atrib ADD CONSTRAINT `fk_codatb` FOREIGN KEY (`codatrib`) REFERENCES `getar_topico` (`cod`);
INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
    (1, 'Inicio atribuicao cadastro', '');
ALTER TABLE getar_atrib ADD CONSTRAINT `fk_codatb` FOREIGN KEY (`cod`) REFERENCES `getar_topico` (`cod`);

INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
(2, 'Gerenciamento de atribuicoes, logons no sistema', 'index.php, m-index.php, cadastro-cad.php, cadastro-cad.inc.php, clasf.php, funcoes_cadastro.php, ingresso.php'),
(3, 'Cadastro e edicao de clientes', 'cadastro.php, clasf.php, funcoes_cadastro.php, ingresso.php, estoque.php, estoque-impress.php'),
(4, 'Apenas detalha Cadastro', 'cadastro.php'),
(5, 'Cadastro e edicao de fornecedores/fabricantes', 'cadastro.php, ingresso.php, clasf.php'),
(6, 'Lista e Edita registros chaves (1, 2 e 3)', 'classe_cad.php'),
(10, 'Inicio atribuicao para OS', ''),
    (11, 'Responsavel por uma OS', 'index.php, m-index.php, boasvindas.php'),
(20, 'Inicio atribuicao para Estoque', 'cadastro-cad.inc.php'),
    (21, 'Responsavel Almoxarifado', 'index.php, m-index.php, estoque.php'),
    (22, 'Tecnico: so consulta e pedido para OS', 'index.php, m-index.php'),
(30, 'Inicio atribuicao para Projetos Programacao', 'cadastro-cad.inc.php'),
    (31, 'Analista/Programador', 'index.php, m-index.php'),
    (32, 'Analista', 'index.php, m-index.php, classe_projprog.php'),
(40, 'Inicio atribuicao para Projetos Eletronicos', 'cadastro-cad.inc.php'),
    (41, 'Engenheiro/Tecnico', 'index.php, m-index.php, proj_eletro/funcoes_projeto.php'),
    (42, 'Engenheiro', 'index.php, m-index.php, proj_eletro/funcoes_projeto.php, proj_eletro/pedido.php, proj_eletro/tarefa.php'),
(50, 'Inicio atribuicao para Vendas', 'cadastro-cad.inc.php'),
    (51, 'Vendedor Geral', 'index.php, m-index.php'),
    (52, 'Vendedor Projetos Programacao', ''),
    (53, 'Vendedor/Atendende Balcao Assistencia', ''),
(60, 'Inicio atribuicao para Financas', 'cadastro-cad.inc.php'),
    (61, 'Financeiro', 'index.php, m-index.php, boasvindas.php'),
    (62, 'Pagamento final', 'boasvindas.php'),
(70, 'Inicio atribuicao para Lembretes e Mensagens', ''),
    (71, 'Admin Lembretes/Mensagens', 'mensg.php, classe_lembre.php'),
    (72, 'Libera mensagens', 'index.php'),
    (73, 'Libera lembretes', 'index.php'),
(80, 'Inicio Atribuicao Artigos', ''),
    (81, 'Libera artigos', ''),
(90, 'Inicio Atribuicoes Avancadas', 'index.php'),
    (91, 'backup', 'index.php'),
    (92, 'plano de atribuiceos', 'index.php'),
(100, 'Inicio Atribuicoes cadastros particular', 'cadastro-cad.inc.php');

# pra atribuicoes mobile
INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
(500, 'Acesso mobile', 'm-index.php'),
(502, 'Administracao de logon, acesso mobile', 'm-index.php'),
(504, 'Detalha cadastro, acesso mobile', 'm-index.php'),
(590, 'Backup, acesso mobile', 'm-index.php'),
(581, 'Artigos, acesso mobile', 'm-index.php'),
(571, 'Mensagens, acesso mobile', 'm-index.php'),
(531, 'Projetos programacao, acesso mobile', 'm-index.php'),
(541, 'Projetos eletronicos, acesso mobile', 'm-index.php'),
(520, 'Estoque, acesso mobile', 'm-index.php'),
(511, 'Ordens de servico OS, acesso mobile', 'm-index.php'),
(551, 'Vendas, acesso mobile', 'm-index.php'),
(561, 'Financeiro, acesso mobile', 'm-index.php'),
(570, 'Lembretes, acesso mobile', 'm-index.php');


# ajuste para o getar em producao
INSERT INTO getar_atrib (codatrib, nick, tipo)
                VALUES(50, 'pregis', 'ativo'),
                      (40, 'pregis', 'ativo'),
                      (20, 'pregis', 'ativo'),
                      (100, 'pregis', 'ativo'),
                      (30, 'pregis', 'ativo');
INSERT INTO getar_atrib (codatrib, nick, tipo)
                VALUES(2, 'gerente', 'ativo');


/**
** AREA DE TESTES
**/
SELECT * FROM getar_atrib;
SELECT * FROM getar_topico ORDER BY cod;
SELECT * FROM getar_control;

ALTER TABLE getar_topico ADD PRIMARY KEY (`cod`);
DROP TABLE getar_atrib;
TRUNCATE TABLE getar_topico;
DELETE FROM getar_topico WHERE cod = 50 LIMIT 1;
ALTER TABLE getar_topico ADD `arquivos` varchar(160) COMMENT 'arquivos .php que o usam';
ALTER TABLE getar_atrib CHANGE `nick` `nick` varchar (20);

ALTER TABLE getar_atrib ADD PRIMARY KEY (codatrib);
# em estudos

INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
        (62, 'Pagamento final', 'boasvindas.php');
INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
        (63, 'Pagamento apenas nivel pendente', 'boasvindas.php, classe_pfinanca.php');
INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
        (6, 'Lista e Edita registros chaves (1, 2 e 3)', 'classe_cad.php');
INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
        (100, 'Inicio Atribuicoes cadastros particular', 'cadastro-cad.inc.php');
