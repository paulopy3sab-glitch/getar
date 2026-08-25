/**
** Inicio atividades operacionais para MySQL
**/
# operacionais
CREATE TABLE `getar_opera` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(60) NOT NULL COMMENT 'nome projeto',
  `resp` varchar(20) NOT NULL,
  `tag` varchar(20) NOT NULL,
  `datareg` date NOT NULL,
  `descr` text NOT NULL,
  `situacao` varchar(20) NOT NULL
) ENGINE=InnoDB CHARSET=latin1;
# DROP TABLE getar_opera;

# tarefas operacionais
CREATE TABLE `getar_tarfopera` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `codopera` int(11) NOT NULL,
  `resp` varchar(20) NOT NULL,
  `dataexc` date NOT NULL,
  `horaini` time NOT NULL,
  `horafim` time,
  `doc` text NOT NULL,
  `situacao` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `getar_tarfopera`
    ADD CONSTRAINT `fk_cdopera` FOREIGN KEY (`codopera`) REFERENCES `getar_opera` (`cod`);
ALTER TABLE `getar_tarfopera`
    ADD CONSTRAINT `fk_rptarfopera` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`);
DROP TABLE getar_tarfopera;

# classicacoes operacionais
CREATE TABLE `getar_clasfopera` (
  `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `titulo` varchar(20) NOT NULL,
  `descr` text NOT NULL,
  `situacao` varchar(20) NOT NULL COMMENT 'ativo inativo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO getar_clasfopera (titulo, descr, situacao) VALUES('ADM', 'Atividades administrativas em geral', 'ativo');
INSERT INTO getar_clasfopera (titulo, descr, situacao)
                       VALUES('Adm', 'Atividades administrativas em geral', 'ativo'),
                             ('Manu', 'Atividades manutenção e limpeza', 'ativo'),
                             ('Exp', 'Atividades expedição de rádios e vendas avulsas', 'ativo'),
                             ('Midia', 'Produção de vídeos e outras mídias de divulgação', 'ativo'),
                             ('Estq', 'Estocagem e pedidos de reposição', 'ativo');

SELECT * FROM getar_clasfopera;
/**
**
**/
SELECT * FROM getar_tarfopera ORDER BY cod ASC;