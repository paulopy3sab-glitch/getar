/**
** @autor: Paulo Regis paulo.py3sab@gmail.com
** Descricao: Inicializar tabelas para OSs
**/

/**
**
**/
CREATE TABLE `ordem` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codeqp` int(11) DEFAULT NULL,
  `codcli` int(11) DEFAULT NULL,
  `situequip` varchar(20) DEFAULT 'normal',
  `entd` date NOT NULL COMMENT 'Data de entrada',
  `saida` date DEFAULT NULL COMMENT 'Data de saida',
  `datafcd` date DEFAULT NULL COMMENT 'Data de fechamento da OS',
  `resp` varchar(20) DEFAULT NULL COMMENT 'Tecnico responsavel pela OS',
  `recla` text COMMENT 'Defeito reclamado pelo cliente',
  `encr` text COMMENT 'Defeito encontrado',
  `serv` text COMMENT 'Servico realizado',
  `valcb` decimal(10,2) DEFAULT NULL,
  `vndacs` int(11) DEFAULT NULL,
  `fatu` varchar(20) DEFAULT 'aberta' COMMENT 'Se esta: aberta, paga, naofatu',
  `situ` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_codeqp` (`codeqp`),
  KEY `fk_codclord` (`codcli`),
  CONSTRAINT `fk_codclord` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`),
  CONSTRAINT `fk_codeqp` FOREIGN KEY (`codeqp`) REFERENCES `equipo` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/**
** 
**/
CREATE TABLE `equipo` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codcli` int(11) DEFAULT NULL,
  `hist` tinyint(1) DEFAULT NULL COMMENT 'Apenas para efeito HISTORICO pois a extrutura do equipamento pode ter mudado ou foi sucateado',
  `descr` varchar(60) NOT NULL,
  `marca` varchar(60) DEFAULT NULL COMMENT 'Fabricante do equipamento',
  `modelo` varchar(20) DEFAULT NULL,
  `serial` varchar(40) DEFAULT NULL,
  `acess` varchar(120) DEFAULT NULL COMMENT 'Acessorios que acompanham o equipamento',
  `situ` varchar(20) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_codcleqp` (`codcli`),
  CONSTRAINT `fk_codcleqp` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Cadastro dos equipamento consertado nas OS';

/**
**
**/
CREATE TABLE `ordem_obs` (
  `codobs` int(11) NOT NULL AUTO_INCREMENT,
  `codord` int(11) DEFAULT NULL,
  `texto` text,
  PRIMARY KEY (`codobs`),
  KEY `fk_obsord` (`codord`),
  KEY `codobs` (`codobs`),
  CONSTRAINT `fk_obsord` FOREIGN KEY (`codord`) REFERENCES `ordem` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

/**
**
**/
CREATE TABLE `ordem_tarf` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codos` int(11) NOT NULL,
  `tecn` varchar(20) DEFAULT NULL COMMENT 'tecnico atendendo a OS',
  `dataexec` date DEFAULT NULL COMMENT 'dia do atendimento a OS',
  `horaini` time DEFAULT NULL COMMENT 'hora inicio tarefa',
  `horafim` time DEFAULT NULL COMMENT 'hora inicio tarefa',
  `descr` text COMMENT 'o que aconteceu',
  `situ` varchar(20) DEFAULT NULL COMMENT 'a',
  PRIMARY KEY (`cod`),
  KEY `fk_codostarf` (`codos`),
  CONSTRAINT `fk_codostarf` FOREIGN KEY (`codos`) REFERENCES `ordem` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=latin1 COMMENT='tarefas das OS'

CREATE TABLE ordem_ret(
    codret int(11) COMMENT 'numero da OS nova',
    codord int(11) COMMENT 'numero da OS original'
)ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'interliga a OS de retorno a sua original';


/**
** Como estão agora as tabelas
**/
SHOW CREATE TABLE ordem;
CREATE TABLE `ordem` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `situ` varchar(20) DEFAULT NULL,
  `retorno` int(1) NOT NULL DEFAULT '0',
  `fila` int(11) DEFAULT '0' COMMENT 'Infileiramento',
  `fatu` varchar(20) DEFAULT 'aberta' COMMENT 'Se esta: aberta, paga, naofatu',
  `valcb` decimal(10,2) DEFAULT NULL,
  `situequip` varchar(20) DEFAULT 'Normal',
  `vndacs` int(11) DEFAULT NULL,
  `entd` date DEFAULT NULL,
  `inicio` date DEFAULT NULL COMMENT 'Data prevista inicio trabalhos',
  `dtrepro` date DEFAULT NULL,
  `saida` date DEFAULT NULL,
  `datafcd` date DEFAULT NULL COMMENT 'Data de fechamento da OS',
  `codcli` int(11) DEFAULT NULL,
  `resp` varchar(20) DEFAULT NULL COMMENT 'Tecnico responsavel pela OS',
  `codeqp` int(11) DEFAULT NULL,
  `recla` text,
  `encr` text,
  `serv` text,
  PRIMARY KEY (`cod`),
  KEY `fk_codeqp` (`codeqp`),
  KEY `fk_codclord` (`codcli`),
  CONSTRAINT `fk_codclord` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`),
  CONSTRAINT `fk_codeqp` FOREIGN KEY (`codeqp`) REFERENCES `equipo` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=670 DEFAULT CHARSET=latin1

ALTER TABLE `ordem` ADD `retorno` INT(1) NOT NULL DEFAULT '0' AFTER `situ`;
ALTER TABLE `ordem` ADD `dtrepro` date DEFAULT NULL AFTER `inicio`;

SHOW CREATE TABLE equipo;
CREATE TABLE `equipo` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codcli` int(11) DEFAULT NULL,
  `hist` tinyint(1) DEFAULT NULL COMMENT 'Apenas para efeito HISTORICO pois a extrutura do equipamento pode ter mudado ou foi sucateado',
  `descr` varchar(60) NOT NULL,
  `marca` varchar(60) DEFAULT NULL COMMENT 'Fabricante do equipamento',
  `modelo` varchar(20) DEFAULT NULL,
  `serial` varchar(40) DEFAULT NULL,
  `acess` varchar(120) DEFAULT NULL COMMENT 'Acessorios que acompanham o equipaento',
  `situ` varchar(20) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_codcleqp` (`codcli`),
  CONSTRAINT `fk_codcleqp` FOREIGN KEY (`codcli`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Cadastro dos equipamento consertado nas OS';

ALTER TABLE equipo DROP hist;

SHOW CREATE TABLE ordem_tarf;
CREATE TABLE `ordem_tarf` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codos` int(11) NOT NULL,
  `tecn` varchar(20) DEFAULT NULL COMMENT 'tecnico atendendo a OS',
  `dataexec` date DEFAULT NULL COMMENT 'dia do atendimento a OS',
  `horaini` time DEFAULT NULL COMMENT 'hora inicio tarefa',
  `horafim` time DEFAULT NULL COMMENT 'hora inicio tarefa',
  `descr` text COMMENT 'o que aconteceu',
  `situ` varchar(20) DEFAULT NULL COMMENT 'a',
  PRIMARY KEY (`cod`),
  KEY `fk_codostarf` (`codos`),
  CONSTRAINT `fk_codostarf` FOREIGN KEY (`codos`) REFERENCES `ordem` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=6942 DEFAULT CHARSET=latin1 COMMENT='tarefas das OS';
