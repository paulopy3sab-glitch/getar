/**
** INICIO DAS TABELAS DE MENSAGENS E LEMBRETES
**/

CREATE TABLE `getar_lembre` (
  `dest` varchar(20) DEFAULT NULL,
  `remt` varchar(20) DEFAULT NULL,
  `datacad` date DEFAULT NULL COMMENT 'data de cadastro',
  `dataagd` date DEFAULT NULL COMMENT 'data de agendamento',
  `titulo` varchar(30) DEFAULT NULL COMMENT 'Titulo do Lembrete',
  `texto` text DEFAULT NULL,
  `situ` varchar(20) NOT NULL DEFAULT 'ativo'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `getar_lembre` ADD CONSTRAINT `fk_destlmb` FOREIGN KEY (`dest`) REFERENCES `getar_control` (`nick`);
ALTER TABLE `getar_lembre` ADD CONSTRAINT `fk_remtlmb` FOREIGN KEY (`remt`) REFERENCES `getar_control` (`nick`);

CREATE TABLE `getar_mens` (
  `cod` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `dest` varchar(100) DEFAULT NULL,
  `remt` varchar(100) DEFAULT NULL,
  `emailRemetente` varchar(120) NOT NULL,
  `artigo` varchar(60) NOT NULL,
  `dataEnv` date DEFAULT NULL,
  `lida` tinyint(1) DEFAULT '0',
  `texto` text,
  `situ` varchar(20) NOT NULL DEFAULT 'ativo'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `getar_mens` ADD CONSTRAINT `fk_destmns` FOREIGN KEY (`dest`) REFERENCES `getar_control` (`nick`);
ALTER TABLE `getar_mens` ADD CONSTRAINT `fk_remtmns` FOREIGN KEY (`remt`) REFERENCES `getar_control` (`nick`);

/**
** AREA DE TESTES
**/

SHOW CREATE TABLE getar_lembre;
CREATE TABLE `getar_lembre` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `dest` varchar(20) DEFAULT NULL,
  `remt` varchar(20) DEFAULT NULL,
  `datacad` date DEFAULT NULL COMMENT 'data de cadastro',
  `dataagd` date DEFAULT NULL COMMENT 'data de agendamento',
  `titulo` varchar(30) DEFAULT NULL COMMENT 'Titulo do Lemprete',
  `texto` text DEFAULT NULL,
  `situ` varchar(20) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_destlmb` (`dest`),
  KEY `fk_remtlmb` (`remt`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
#DROP TABLE getar_lembre;