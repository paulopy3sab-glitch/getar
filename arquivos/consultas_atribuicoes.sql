/***
**
**/
SHOW CREATE TABLE getar_control;
CREATE TABLE `getar_control` (
  `nick` varchar(20) NOT NULL DEFAULT '',
  `frase` varchar(64) DEFAULT NULL,
  `codcad` int(11) DEFAULT NULL,
  `contra` varchar(64) NOT NULL COMMENT 'Senha para validar pagamentos financeiros',
  PRIMARY KEY (`nick`),
  KEY `fk_ctcad` (`codcad`),
  CONSTRAINT `fk_ctcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE getar_control ADD `contra` varchar(64) NOT NULL COMMENT 'Senha para validar pagamentos financeiros';
ALTER TABLE getar_control CHANGE `frase` `frase` varchar(64) NOT NULL COMMENT 'Senha para logon no GETAR';
# ALTER TABLE getar_control DROP FOREIGN KEY `fk_ctcad`;
# ALTER TABLE getar_control ADD `codcad` INT(11) NOT NULL COMMENT 'Codigo da cadastro em getar_cad';
# ALTER TABLE getar_control ADD CONSTRAINT fk_ctcad FOREIGN KEY (codcad) REFERENCES getar_cad(cod);
ALTER TABLE `getar_control`
  DROP `datalog`,
  DROP `ip`;
ALTER TABLE getar_control ADD custohora decimal(10,2) NOT NULL;

# Atributos
ALTER TABLE getar_atrib CHANGE `codatrib` `cod` int(11) NOT NULL PRIMARY KEY COMMENT 'codigo da atribuicao getar_topico';


INSERT INTO getar_topico(cod, descr) VALUES(1, 'Inicio atribuicao cadastro');
INSERT INTO getar_topico(cod, descr) VALUES(2, 'Gerenciamento de atribuicoes, logons no sistema');
INSERT INTO getar_topico(cod, descr) VALUES(3, 'Cadastro e edicao de clientes e fornecedores/fabricantes');
INSERT INTO getar_topico(cod, descr) VALUES(4, 'Apenas detalha Cadastro');
# OSCONTROL Novas atribuições
INSERT INTO getar_topico(cod, descr) VALUES(10, 'Inicio atribuicao para OS');
INSERT INTO getar_topico(cod, descr) VALUES(11, 'Responsavel por uma OS');
INSERT INTO getar_topico(cod, descr, arquivos) VALUES(12, 'Soh lista as OS e Cria novas', 'index.php');
# Estoque
INSERT INTO getar_topico(cod, descr) VALUES(20, 'Inicio atribuicao para Estoque');
INSERT INTO getar_topico(cod, descr) VALUES(21, 'Responsavel Almoxarifado');
INSERT INTO getar_topico(cod, descr) VALUES(22, 'Tecnico: so consulta e pedido para OS');
INSERT INTO getar_topico(cod, descr) VALUES(30, 'Inicio atribuicao para Projetos Programacao');
INSERT INTO getar_topico(cod, descr) VALUES(31, 'Analista/Programador');
INSERT INTO getar_topico(cod, descr) VALUES(32, 'Analista');
INSERT INTO getar_topico(cod, descr) VALUES(40, 'Inicio atribuicao para Projetos Eletronicos');
INSERT INTO getar_topico(cod, descr) VALUES(41, 'Engenheiro/Tecnico');
INSERT INTO getar_topico(cod, descr) VALUES(42, 'Engenheiro');
INSERT INTO getar_topico(cod, descr) VALUES(50, 'Inicio atribuicao para Vendas');
INSERT INTO getar_topico(cod, descr) VALUES(51, 'Vendedor Geral');
INSERT INTO getar_topico(cod, descr) VALUES(52, 'Vendedor Projetos Programacao');
INSERT INTO getar_topico(cod, descr) VALUES(53, 'Vendedor/Atendende Balcao Assistencia');
INSERT INTO getar_topico(cod, descr) VALUES(60, 'Inicio atribuicao para Financas');
INSERT INTO getar_topico(cod, descr) VALUES(61, 'Financeiro');
INSERT INTO getar_topico(cod, descr) VALUES(70, 'Inicio atribuicao para Lembretes e Mensagens');
INSERT INTO getar_topico(cod, descr) VALUES(71, 'Admin Lembretes/Mensagens');
INSERT INTO getar_topico(cod, descr, arquivos) VALUES(94, 'Gerencia logons de usuarios', 'index.php');

INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 1, 'padrao');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 2, 'padrao');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 2, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 11, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('tecno', 11, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 11, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 21, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 21, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('tecno', 22, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 31, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 31, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 32, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 32, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 41, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 41, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 42, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 42, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 51, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 51, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 52, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 52, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 53, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 53, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 61, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 61, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 71, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 71, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 72, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('financa', 61, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admin', 3, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('financa', 3, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('pregis', 3, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('vendedor', 3, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('tecno', 4, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('estoque', 3, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('estoque', 21, 'ativo');
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('marias', 73, 'padrao');

SELECT * FROM getar_topico WHERE cod IN(40,41,42);
# ------------------------

# DROP TABlE getar_topico;
# DELETE FROM getar_topico WHERE cod = 10 LIMIT 1;

CREATE TABLE `getar_perfil` (
  `cod` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL COMMENT 'nome do perfil',
  `clasf` VARCHAR(20) DEFAULT NULL,
  `arratrib` varchar(60) NOT NULL COMMENT 'Array de numeros, topicos para o perfil',
  `situ` varchar(20) DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Topico do sistema atribuido a um nick';
# DROP TABLE getar_perfil;
TRUNCATE TABLE getar_perfil;
INSERT INTO getar_perfil (nome, clasf, arratrib)
                   VALUES('Chefe de Gabinete', 'a', '1, 3, 72, 90, 93, 94, 500, 504'),
                         ('Vereador', 'd', '1, 3, 72, 90, 93, 94, 500, 504'),
                         ('Assessor', 's', '1, 3, 72, 73'),
                         ('Recepcao', 'v', '1, 3, 72, 73');
INSERT INTO getar_topico (cod, descr, arquivos) VALUES (94, 'Gerencia logons de usuarios', 'index.php');
INSERT INTO getar_topico (cod, descr, arquivos)
                  VALUES (572, 'Libera mensagens, acesso mobile', 'm-index.php'),
                         (573, 'Libera lembretes, acesso mobile', 'm-index.php');

INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                  VALUES(504, 'marias', 'padrao');
INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                  VALUES(94, 'admin', 'padrao');

INSERT INTO getar_topico(cod, descr, arquivos) VALUES(94, 'Gerencia logons de usuarios', 'index.php');

SELECT nick, codatrib, tipo FROM getar_atrib ORDER BY nick, codatrib;
SELECT nick, codatrib, tipo FROM getar_atrib WHERE nick='pregis' ORDER BY codatrib;
SELECT nick, codatrib, tipo FROM getar_atrib WHERE nick='kauan' ORDER BY codatrib;
UPDATE getar_atrib SET codatrib= 573 WHERE nick='marias' AND codatrib= 504 LIMIT 1;
SELECT nick, codatrib, tipo FROM getar_atrib WHERE nick='admin' ORDER BY codatrib;

DELETE FROM getar_atrib WHERE codatrib= 72 AND nick= 'admin' LIMIT 1;
DELETE FROM getar_atrib WHERE nick= 'kauan';
INSERT INTO getar_atrib(nick, codatrib, tipo) VALUES('admingeral.wl', 94, 'padrao');

SELECT * FROM getar_perfil;
ALTER TABLE getar_perfil ADD clasf VARCHAR(20) DEFAULT NULL AFTER `nome`;
SELECT clasf FROM getar_cad WHERE cod=897;
                  SELECT arratrib
                    FROM getar_perfil
                   WHERE clasf='a'
                   LIMIT 1;
SELECT * FROM getar_control;

/**
**
**/
SELECT descr FROM getar_topico WHERE cod= 2;
SELECT * FROM `getar_atrib` WHERE `nick` = 'marias' ORDER BY `codatrib`;

INSERT INTO getar_atrib (nick, codatrib, tipo) VALUES ('admin', 93, 'padrao');
INSERT INTO getar_atrib (nick, codatrib, tipo) VALUES ('pregis', 93, 'padrao');
INSERT INTO getar_topico (cod, descr, arquivos) VALUES(93, 'Aplicar perfil de atribuicoes', 'index.php');

             SELECT ct.nick,
                    cad.nome
               FROM getar_control ct,
                    getar_cad cad
              WHERE ct.codcad = cad.cod
                    AND cad.situacao= 'ativo'
                    AND cad.cod NOT IN(1, 2, 3)
                    AND ct.nick NOT IN(SELECT DISTINCT nick
                                         FROM getar_atrib);

/**
** AREA DE TESTES
**/
        SELECT cod,
               nome,
               arratrib
         FROM getar_perfil
        WHERE situ= 'ativo';


SELECT cod, descr FROM getar_topico ORDER BY cod;
SELECT nick, codatrib, tipo FROM getar_atrib ORDER BY nick, codatrib;

DELETE FROM getar_atrib WHERE nick='pregis';

        SELECT DISTINCT nick
          FROM getar_atrib;

        SELECT ct.nick,
               cad.nome
          FROM getar_control ct,
               getar_cad cad
         WHERE ct.codcad = cad.cod
               AND cad.situacao= 'ativo'
               AND ct.nick NOT IN(SELECT DISTINCT nick
                                    FROM getar_atrib);

        SELECT cod codatrib,
               descr,
               ' ' nick,
               ' ' tipo
          FROM getar_topico
UNION(SELECT codatrib,
               tp.descr,
               nick,
               tipo 
          FROM getar_atrib atr,
               getar_topico tp
               WHERE atr.codatrib = tp.cod)
      ORDER BY codatrib;

/**
** funcao de consulta se atribuido
**/
        SELECT COUNT(*) atrib
          FROM getar_atrib
         WHERE nick = 'admingeral.a'
               AND codatrib = 2;
SELECT * FROM getar_atrib WHERE nick= 'admingeral.a' ORDER BY codatrib;
SELECT * FROM getar_atrib WHERE nick = 'kauan' ORDER BY nick, codatrib;
SELECT * FROM getar_control;

INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES(93, 'perfil de atribuicoes', 'index.php');
INSERT INTO `getar_topico` (`cod`, `descr`, `arquivos`) VALUES
(110, 'Inicio cadastro veiculos', 'index.php'),
(111, 'Edita cadastro veiculos', 'index.php');
(112, 'lista e apenas detalha cadastro veiculos', 'index.php');

INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                  VALUES(111, 'admin', 'padrao');

INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                  VALUES(93, 'admin', 'padrao');
INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                  VALUES(71, 'pregis', 'padrao');
INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                  VALUES(72, 'pregis', 'padrao');
INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                    VALUES(520, 'pregis', 'ativo'),
                          (511, 'pregis', 'ativo');

/**
** CONSULTA SOMENTE PARA TECNICOS LIBERADOS
**/
        SELECT cad.nome,
               ctl.nick
         FROM  getar_control ctl,
               getar_cad cad
         WHERE ctl.codcad = cad.cod
               AND cad.situacao = 'ativo'
               AND ctl.nick IN(SELECT nick
                               FROM getar_atrib
                                WHERE codatrib = 1);

/**
** Testes
**/
SELECT * FROM getar_atrib;
SELECT * FROM getar_atrib WHERE nick='pregis';
SELECT * FROM getar_atrib WHERE nick='sofia2t';

     SELECT cad.nome,
            ctl.nick
      FROM  getar_control ctl,
            getar_cad cad
      WHERE ctl.codcad = cad.cod
            AND cad.situacao = 'ativo'
            AND ctl.nick IN(SELECT nick
                              FROM getar_atrib
                             WHERE codatrib = 41);