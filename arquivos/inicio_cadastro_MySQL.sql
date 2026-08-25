/**
**
**/
CREATE TABLE getar_cad (
    `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` varchar(120),
    `clasf` char(1),
    `contato` varchar(60) DEFAULT NULL,
    `cpcn` varchar(20) DEFAULT NULL,
    `estciv` VARCHAR(20) DEFAULT 'casado',
    `nacna` VARCHAR(20) DEFAULT 'Brasileiro' COMMENT 'Nacionalidade',
    `rgie` varchar(20) DEFAULT NULL,
    `desde` date DEFAULT '2001-01-01',
    `nasc` date DEFAULT '2001-01-01',
    `ref` varchar(40) DEFAULT NULL,
    `endr` varchar(120) DEFAULT NULL,
    `bairro` varchar(60) DEFAULT NULL,
    `cidade` varchar(60) DEFAULT NULL,
    `cep` varchar(9) DEFAULT NULL,
    `estado` char(2) DEFAULT NULL,
    `emailcorp` varchar(60) DEFAULT NULL COMMENT 'Para uso de envio e-mail pelo Getar',
    `situacao` varchar(60) DEFAULT 'ativo'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
INSERT INTO getar_cad (nome, clasf, situacao)
            VALUES('Administrador', 'a', 'ativo'),
                  ('Empresa Proprietaria', 'a', 'ativo'),
                  ('Empresa Cliente Interno ', 'c', 'ativo');# pra quem vai OS, projeto novos e ainda temporarios

CREATE TABLE `getar_fones` (
    cod int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    codcli int(5) NOT NULL,
    numero varchar(15) NOT NULL,
    descr varchar(20) NOT NULL,
    ramal varchar(5),
    situ VARCHAR(20) DEFAULT 'ativo'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
# ALTER TABLE getar_fones CHANGE numero numero varchar(15) NOT NULL;
ALTER TABLE `getar_fones` ADD CONSTRAINT `fk_fonecad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`);

CREATE TABLE `getar_sites` (
    `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `codcli` int(11) NOT NULL,
    `endr` varchar(120) NOT NULL,
    `descr` varchar(120) NOT NULL,
    situ VARCHAR(20) DEFAULT 'ativo'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
ALTER TABLE `getar_sites` ADD CONSTRAINT `fk_sitecad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`);

CREATE TABLE `getar_emails` (
    `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `codcli` int(11) NOT NULL,
    `endr` varchar(120) NOT NULL,
    `descr` varchar(120) NOT NULL,
    situ VARCHAR(20) DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `getar_emails` ADD CONSTRAINT `fk_emailcad` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`);

/**
** Para logon no sistemas
**/
CREATE TABLE `getar_control` (
    `nick` varchar(20) NOT NULL PRIMARY KEY,
    `frase` varchar(64) DEFAULT NULL,
    `codcad` int(11) NOT NULL,
    `contra` varchar(64) DEFAULT NULL COMMENT 'Senha para validar pagamentos financeiros'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `getar_control` ADD CONSTRAINT `fk_ctcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`);
INSERT INTO getar_control (nick, frase, codcad, contra) VALUES('admin', PASSWORD('123mudar'), 1, '');
# UPDATE getar_control SET frase= PASSWORD('123mudar') WHERE nick= 'admin';

CREATE TABLE `getar_reglog` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nick` varchar(20) DEFAULT NULL,
  `datalog` date DEFAULT NULL,
  `horaini` time DEFAULT NULL,
  `horault` time DEFAULT NULL,
  `horafim` time DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `situacao` varchar(20) DEFAULT 'ativo'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
ALTER TABLE `getar_reglog` ADD CONSTRAINT `fk_rgnick` FOREIGN KEY (`nick`) REFERENCES `getar_control` (`nick`);

# tabela para distinguir contatos particulares dos administradores ou gerentes
CREATE TABLE `getar_part` (
    `nick` varchar(20) NOT NULL,
    `codcad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `getar_part` ADD CONSTRAINT `fk_ptcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`);
ALTER TABLE `getar_part` ADD CONSTRAINT `fk_ptctr` FOREIGN KEY (`nick`) REFERENCES `getar_control` (`nick`);

# tabela em teste (redirecionamento de logon cliente
CREATE TABLE `getar_cliente` (
    `nick` varchar(20) NOT NULL,
    `url` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `getar_atrib` (
  `nick` varchar(120) NOT NULL COMMENT 'Nick a receber a atribuicao - se tipo padroa: apenas para referencia na clonagem',
  `codatrib` int(11) NOT NULL COMMENT 'codigo da atribuicao',
  `tipo` varchar(20) NOT NULL COMMENT 'padrao: apenas referencia - ativo: referente ao um nick cadastrado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Topico do sistema atribuido a um nick';
# ERRO: Código do erro 1005, estado do SQL HY000: Can't create table `getardistri`.`getar_atrib` (errno: 150 "Foreign key constraint is incorrectly formed")
ALTER TABLE getar_atrib ADD CONSTRAINT `fk_nickatb` FOREIGN KEY (`nick`) REFERENCES `getar_control` (`nick`);

CREATE TABLE `estado` (
  `cod_estado` int(11) NOT NULL,
  `cod_pais` int(11) NOT NULL,
  `sgl_estado` char(2) NOT NULL,
  `nom_estado` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
# pegar os dados de um exportacao de uma tabela ja existente para evitar problema com acentuacao

# SHOW CREATE TABLE getar_perfil;
CREATE TABLE `getar_perfil` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL COMMENT 'nome do perfil',
  `clasf` varchar(20) DEFAULT NULL,
  `arratrib` varchar(60) NOT NULL COMMENT 'Array de numeros, topicos para o perfil',
  `situ` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Topico do sistema atribuido a um nick';

INSERT INTO `getar_perfil` (`cod`, `nome`, `clasf`, `arratrib`, `situ`) VALUES
(1, 'Administrador', 'a', '1, 2, 3, 72, 90, 93', 'ativo'),
(2, 'Secretario', 's', '1, 3, 72', 'ativo'),
(3, 'Tecnico', 't', '1, 3, 5,11, 21, 72', 'ativo');

SHOW CREATE TABLE getar_logon;
