/**
**
**/

/** projetos de programacao */
CREATE TABLE `getar_projetos` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tag` VARCHAR(20) DEFAULT NULL,
  `codant` int(11) NULL,
  `nome` varchar(40) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  `datareg` date DEFAULT NULL,
  `descr` text,
  `situacao` varchar(60) DEFAULT 'a'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

# DROP TABLE getar_projetos_nv;

/*ALTER TABLE `getar_projetos`
     ADD KEY `fk_cadprojprog` (`cliente`);
 ALTER TABLE getar_projetos DROP FOREIGN KEY fk_cadprojprog;*/
ALTER TABLE `getar_projetos`
    ADD CONSTRAINT `fk_cadprojprog` FOREIGN KEY (`cliente`) REFERENCES `getar_cad` (`cod`);

/* pedido dos projetos */
CREATE TABLE `getar_pedidos` (
    `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `titulo` varchar(60) NOT NULL,
    `resp` varchar(20) DEFAULT NULL,
    `situacao` varchar(60) DEFAULT 'e',
    `prior` char(1) DEFAULT 'c',
    `projeto` int(11) DEFAULT NULL,
    `datareg` date DEFAULT NULL,
    `dataini` date DEFAULT NULL,
    `dataclc` date DEFAULT NULL,
    `fatura` tinyint(1) DEFAULT NULL,
    `doc` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

ALTER TABLE `getar_pedidos`
    ADD KEY `fk_codproj` (`projeto`), ADD KEY `fk_rppedido` (`resp`);

ALTER TABLE `getar_pedidos`
ADD CONSTRAINT `fk_rppedido` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`);

ALTER TABLE `getar_pedidos`
ADD CONSTRAINT `fk_codproj` FOREIGN KEY (`projeto`) REFERENCES `getar_projetos` (`cod`);
ALTER TABLE getar_pedidos DROP FOREIGN KEY fk_codproj;

/* tarefas dos pedidos */
CREATE TABLE `getar_tarefas` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `resp` varchar(20) DEFAULT NULL,
  `situacao` varchar(60) DEFAULT 'e',
  `codped` int(11) DEFAULT NULL,
  `dataexc` date DEFAULT NULL,
  `horaini` time DEFAULT NULL,
  `horafim` time DEFAULT NULL,
  `doc` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

# DROP TABLE getar_tarefas;
ALTER TABLE `getar_tarefas`
    ADD KEY `fk_cdpedido` (`codped`), ADD KEY `fk_rptarefa` (`resp`);

ALTER TABLE `getar_tarefas`
ADD CONSTRAINT `fk_cdpedido` FOREIGN KEY (`codped`) REFERENCES `getar_pedidos` (`cod`);

ALTER TABLE `getar_tarefas`
ADD CONSTRAINT  `fk_rptarefa` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`);
# ALTER TABLE getar_tarefas DROP FOREIGN KEY fk_cdpedido;
# ALTER TABLE getar_tarefas DROP FOREIGN KEY fk_rptarefa;
/** Da erro de sintaxe
ALTER TABLE getar_tarefas DROP CONSTRAINT fk_rptarefa;
*/

/**
** Area de testes
**/
SHOW CREATE TABLE getar_projetos;

# ALTER TABLE getar_projetos MODIFY cliente INT NOT NULL;

SHOW CREATE TABLE getar_pedidos;
CREATE TABLE `getar_pedidos` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) NOT NULL,
  `resp` varchar(20) DEFAULT NULL,
  `situacao` varchar(60) DEFAULT 'e',
  `prior` char(1) DEFAULT 'c',
  `projeto` int(11) DEFAULT NULL,
  `datareg` date DEFAULT NULL,
  `dataini` date DEFAULT NULL,
  `dataclc` date DEFAULT NULL,
  `fatura` tinyint(1) DEFAULT NULL,
  `doc` text,
  PRIMARY KEY (`cod`),
  KEY `fk_codproj` (`projeto`),
  KEY `fk_rppedido` (`resp`),
  CONSTRAINT `fk_rppedido` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`),
  CONSTRAINT `fk_codproj` FOREIGN KEY (`projeto`) REFERENCES `getar_projetos` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `getar_pedidos` (
  `cod` int(11) NOT NULL,
  `titulo` varchar(60) NOT NULL,
  `resp` varchar(20) DEFAULT NULL,
  `situacao` varchar(60) DEFAULT 'e',
  `prior` char(20) DEFAULT 'baixa',
  `codproj` int(11) DEFAULT NULL,
  `datareg` date DEFAULT NULL,
  `dataini` date DEFAULT NULL,
  `dataclc` date DEFAULT NULL,
  `fatu` tinyint(1) DEFAULT NULL,
  `doc` text,
  PRIMARY KEY (`cod`),
  KEY `fk_codproj` (`codproj`),
  KEY `fk_rppedido` (`resp`),
  CONSTRAINT `fk_rppedido` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `getar_pedidos`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

# Tarefas
SHOW CREATE TABLE getar_tarefas;
CREATE TABLE `getar_tarefas` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `resp` varchar(20) DEFAULT NULL,
  `situacao` varchar(60) DEFAULT 'e',
  `codped` int(11) DEFAULT NULL,
  `dataexc` date DEFAULT NULL,
  `horaini` time DEFAULT NULL,
  `horafim` time DEFAULT NULL,
  `doc` text,
  PRIMARY KEY (`cod`),
  KEY `fk_cdpedido` (`codped`),
  KEY `fk_rptarefa` (`resp`),
  CONSTRAINT `fk_cdpedido` FOREIGN KEY (`codped`) REFERENCES `getar_pedidos` (`cod`),
  CONSTRAINT `fk_rptarefa` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=4271 DEFAULT CHARSET=latin1;

ALTER TABLE `getar_tarefas`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4500;