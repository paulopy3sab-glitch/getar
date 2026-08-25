/**
** Inicio projetos eletronicos para MySQL
**/
# projetos eletronicos
CREATE TABLE `eletro_projetos` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(60) NOT NULL COMMENT 'nome projeto',
  `datareg` date NOT NULL,
  `cliente` int(11) NOT NULL,
  `descr` text NOT NULL,
  `situacao` varchar(20) NOT NULL
) ENGINE=InnoDB CHARSET=latin1;
ALTER TABLE `eletro_projetos`
    ADD CONSTRAINT `fk_cadproel` FOREIGN KEY (`cliente`) REFERENCES `getar_cad` (`cod`);

# pedidos eletronicos
CREATE TABLE `eletro_pedidos` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `codproj` int(11) NOT NULL,
  `resp` varchar(20) NOT NULL,
  `titulo` varchar(60) NOT NULL,
  `prioridade` varchar(20) NOT NULL,
  `datareg` date NOT NULL,
  `dataini` date NOT NULL,
  `dataclc` date NOT NULL,
  `fatu` varchar(10) NOT NULL,
  `doc` text NOT NULL,
  `situacao` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
ALTER TABLE `eletro_pedidos`
    ADD CONSTRAINT `fk_cdproel` FOREIGN KEY (`codproj`) REFERENCES `eletro_projetos` (`cod`);
ALTER TABLE `eletro_pedidos`
    ADD CONSTRAINT `fk_rppdproel` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`);

# tarefas eletronicos
CREATE TABLE `eletro_tarefas` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `codped` int(11) NOT NULL,
  `resp` varchar(20) NOT NULL,
  `dataexc` date NOT NULL,
  `horaini` time NOT NULL,
  `horafim` time NOT NULL,
  `doc` text NOT NULL,
  `situacao` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1
ALTER TABLE `eletro_tarefas`
    ADD CONSTRAINT `fk_cdpedel` FOREIGN KEY (`codped`) REFERENCES `eletro_pedidos` (`cod`);
ALTER TABLE `eletro_tarefas`
    ADD CONSTRAINT `fk_rptarproel` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`);