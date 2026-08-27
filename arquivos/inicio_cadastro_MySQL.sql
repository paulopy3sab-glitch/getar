/**
** Aqui inicializamos o GETAR, as tabelas principais o CADASTRO do administrado,
* do propritario, de clientes, de colaboradores, dos fornecedores, dos fabricantes
* e logons dos colaboradores.
**/
CREATE TABLE `getar_cad` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `getar_estado_cod` int(11) DEFAULT 1,
  `nome` varchar(120) DEFAULT NULL,
  `clasf` char(1) DEFAULT NULL,
  `contato` varchar(20) DEFAULT NULL,
  `endr` varchar(40) DEFAULT NULL,
  `numero` varchar(8) NOT NULL DEFAULT '',
  `complemento` varchar(60) NOT NULL DEFAULT '',
  `bairro` varchar(60) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `cpcn` varchar(20) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `rgie` varchar(20) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `desde` date DEFAULT '2001-01-01',
  `nasc` date DEFAULT '2001-01-01',
  `estciv` varchar(20) DEFAULT 'casado',
  `sexo` varchar(120) DEFAULT 'masculino',
  `nacna` varchar(20) DEFAULT 'Brasileiro' COMMENT 'Nacionalidade',
  `situacao` varchar(60) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#

INSERT INTO getar_cad (nome, clasf, situacao)
            VALUES('Administrador', 'a', 'ativo'),
                  ('Empresa Proprietaria', 'a', 'ativo'),
                  ('Empresa Cliente Interno ', 'c', 'ativo');# pra quem vai OS, projeto novos e ainda temporarios

INSERT INTO getar_cad (nome, clasf, situacao)
            VALUES('Gerente Proprietario', 'a', 'ativo');

CREATE TABLE `getar_fones` (
  `cod` int(5) NOT NULL AUTO_INCREMENT,
  `codcli` int(5) NOT NULL,
  `numero` varchar(15) NOT NULL,
  `descr` varchar(20) NOT NULL,
  `ramal` varchar(5) NOT NULL,
  `situ` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`),
  KEY `fk_fonecad` (`codcli`),
  CONSTRAINT `fk_fonecad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
# ALTER TABLE getar_fones CHANGE numero numero varchar(15) NOT NULL;
# ALTER TABLE `getar_fones` ADD CONSTRAINT `fk_fonecad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`);

CREATE TABLE `getar_sites` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codcli` int(11) NOT NULL,
  `endr` varchar(120) NOT NULL,
  `descr` varchar(120) NOT NULL,
  `situ` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`),
  KEY `fk_sitecad` (`codcli`),
  CONSTRAINT `fk_sitecad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
# ALTER TABLE `getar_sites` ADD CONSTRAINT `fk_sitecad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`);

CREATE TABLE `getar_emails` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codcli` int(11) NOT NULL,
  `endr` varchar(120) NOT NULL,
  `descr` varchar(120) NOT NULL,
  `situ` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`),
  KEY `fk_emailcad` (`codcli`),
  CONSTRAINT `fk_emailcad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
# ALTER TABLE `getar_emails` ADD CONSTRAINT `fk_emailcad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`);

/**
** Para logon no sistemas
**/

CREATE TABLE `getar_control` (
  `nick` varchar(20) NOT NULL,
  `emailcorp` varchar(60) DEFAULT NULL COMMENT 'Para uso de envio e-mail pelo Getar',
  `hashsl` varchar(256) NOT NULL,
  `codcad` int(11) NOT NULL,
  `contrahash` varchar(256) NOT NULL,
  `custohora` decimal(10,2) NOT NULL,
  `proprietario` varchar(20) NOT NULL DEFAULT 'getar' COMMENT 'para multiplos proprietarios',
  PRIMARY KEY (`nick`),
  KEY `fk_ctcad` (`codcad`),
  CONSTRAINT `fk_ctcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
# ALTER TABLE `getar_control` ADD CONSTRAINT `fk_ctcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`);

INSERT INTO getar_control (nick, hashsl, contrahash, custohora, codcad)
                   VALUES ('admin', '$2y$10$BCscY.cMV4NGmdPMn0WTl.lxMVwO.iNYkJ4ez2C4CW3C5lT2kSomS', ' ', 0, 1);# senha 123mudar
INSERT INTO getar_control (nick, hashsl, contrahash, custohora, codcad)
                   VALUES ('distri', '$2y$10$BCscY.cMV4NGmdPMn0WTl.lxMVwO.iNYkJ4ez2C4CW3C5lT2kSomS', ' ', 0, 4);# senha 123mudar


CREATE TABLE `getar_reglog` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) DEFAULT NULL,
  `datalog` date DEFAULT NULL,
  `horaini` time DEFAULT NULL,
  `horault` time DEFAULT NULL,
  `horafim` time DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `situacao` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
# ALTER TABLE `getar_reglog` ADD CONSTRAINT `fk_rgnick` FOREIGN KEY (`nick`) REFERENCES `getar_control` (`nick`);

# tabela para distinguir contatos particulares dos administradores ou gerentes
CREATE TABLE `getar_part` (
  `nick` varchar(20) NOT NULL,
  `codcad` int(11) NOT NULL,
  KEY `fk_ptcad` (`codcad`),
  CONSTRAINT `fk_ptcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
# ALTER TABLE `getar_part` ADD CONSTRAINT `fk_ptcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`);
# ALTER TABLE `getar_part` ADD CONSTRAINT `fk_ptctr` FOREIGN KEY (`nick`) REFERENCES `getar_control` (`nick`);

# tabela em teste (redirecionamento de logon cliente
/*CREATE TABLE `getar_cliente` (
    `nick` varchar(20) NOT NULL,
    `url` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;*/

CREATE TABLE `getar_atrib` (
  `nick` varchar(20) NOT NULL COMMENT 'Nick a receber a atribuicao - se tipo padroa: apenas para referencia na clonagem',
  `codatrib` int(11) NOT NULL COMMENT 'codigo da atribuicao',
  `tipo` varchar(20) NOT NULL COMMENT 'padrao: apenas referencia - ativo: referente ao um nick cadastrado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Topico do sistema atribuido a um nick';

CREATE TABLE `getar_perfil` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL COMMENT 'nome do perfil',
  `clasf` varchar(20) DEFAULT NULL,
  `arratrib` varchar(60) NOT NULL COMMENT 'Array de numeros, topicos para o perfil',
  `situ` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Topico do sistema atribuido a um nick';
INSERT INTO `getar_perfil` (`cod`, `nome`, `clasf`, `arratrib`, `situ`) VALUES
(1, 'Administrador', 'a', '1, 2, 3, 72, 90, 93', 'ativo'),
(2, 'Secretario', 's', '1, 3, 72', 'ativo'),
(3, 'Tecnico', 't', '1, 3, 5,11, 21, 72', 'ativo');

CREATE TABLE `getar_pais` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO getar_pais (nome)
                 VALUES('Brasil'),
                       ('EUA'),
                       ('Alemanha'),
                       ('India'),
                       ('China'),
                       ('UK');

# SHOW CREATE TABLE getar_estado;
CREATE TABLE `getar_estado` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `getar_pais_id_pais` int(11) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_getar_estado_getar_pais1_idx` (`getar_pais_id_pais`),
  CONSTRAINT `fk_getar_estado_getar_pais1` FOREIGN KEY (`getar_pais_id_pais`) REFERENCES `getar_pais` (`cod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE getar_cad ADD
KEY `fk_getar_cad_getar_estado` (`getar_estado_cod`);

/*ALTER TABLE getar_cad ADD
  CONSTRAINT `fk_getar_cad_getar_estado`
  FOREIGN KEY (`getar_estado_cod`)
  REFERENCES `getar_estado` (`cod`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;# Código do erro 1452, estado do SQL 23000: Cannot add or update a child row: a foreign key constraint fails (`getardistri`.`#sql-6098_f6`, CONSTRAINT `fk_getar_cad_getar_estado` FOREIGN KEY (`getar_estado_cod`) REFERENCES `getar_estado` (`cod`) ON DELETE NO ACTION ON UPDATE NO ACTION)
*/

ALTER TABLE getar_cad ADD
CONSTRAINT `fk_getar_cad_getar_estado`
    FOREIGN KEY (`getar_estado_cod`)
    REFERENCES `getar_estado` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

# Estados brasileiros
INSERT INTO getar_estado (nome, getar_pais_id_pais)
                  VALUES ('Acre', 1),
                         ('Alagoas', 1),
                         ('Amazonas', 1),
                         ('Amapá', 1),
                         ('Bahia', 1),
                         ('Ceará', 1),
                         ('Distrito Federal', 1),
                         ('Espírito Santo', 1),
                         ('Goiás', 1),
                         ('Maranhão', 1),
                         ('Minas Gerais', 1),
                         ('Mato Grosso do Sul', 1),
                         ('Mato Grosso', 1),
                         ('Pará', 1),
                         ('Paraíba', 1),
                         ('Pernambuco', 1),
                         ('Piauí', 1),
                         ('Paraná', 1),
                         ('Rio de Janeiro', 1),
                         ('Rio Grande do Norte', 1),
                         ('Rondônia', 1),
                         ('Roraima', 1),
                         ('Rio Grande do Sul', 1),
                         ('Santa Catarina', 1),
                         ('Sergipe', 1),
                         ('São Paulo', 1),
                         ('Tocantis', 1);