/**
** @author: Paulo Regis
** @email: paulo_schw@yahoo.com.br
** @abstract: para testes e acompanhamento das Atividades Operacionais
**/

/**
**
**/
SHOW CREATE TABLE getar_opera;
CREATE TABLE `getar_opera` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL COMMENT 'nome projeto',
  `resp` varchar(20) NOT NULL,
  `tag` varchar(20) NOT NULL,
  `datareg` date NOT NULL,
  `descr` text NOT NULL,
  `situacao` varchar(20) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

ALTER TABLE `getar_opera` ADD `clasf` VARCHAR(20) COMMENT 'Classificacao da atividade' AFTER `tag`;

# ***********
SHOW CREATE TABLE getar_tarfopera;
CREATE TABLE `getar_tarfopera` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codopera` int(11) NOT NULL,
  `resp` varchar(20) NOT NULL,
  `dataexc` date NOT NULL,
  `horaini` time NOT NULL,
  `horafim` time DEFAULT NULL,
  `doc` text NOT NULL,
  `situacao` varchar(20) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_cdopera` (`codopera`),
  KEY `fk_rptarfopera` (`resp`),
  CONSTRAINT `fk_cdopera` FOREIGN KEY (`codopera`) REFERENCES `getar_opera` (`cod`),
  CONSTRAINT `fk_rptarfopera` FOREIGN KEY (`resp`) REFERENCES `getar_control` (`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=1706 DEFAULT CHARSET=latin1;


# *********
SHOW CREATE TABLE getar_clasfopera;

/**
** Operacionais
**/
INSERT INTO getar_opera ( tag, nome, resp, datareg, descr, situacao)
                  VALUES('OPR001', 'Administrativo', 'pregis', CURDATE(), 'Operações administrativas em geral', 'ativo');
INSERT INTO getar_opera ( tag, nome, resp, datareg, descr, situacao)
                  VALUES('MAN001', 'Manutenção', 'pregis', CURDATE(), 'Operações de manutenção em geral', 'ativo');
SELECT * FROM getar_opera ORDER BY cod DESC;
SELECT * FROM getar_opera WHERE cod= 6;
# 
SELECT * FROM getar_tarfopera ORDER BY cod DESC;
SELECT * FROM getar_tarfopera WHERE cod IN(1686, 1685, 1672, 1645, 1646, 1647, 1606, 1591);
SELECT * FROM getar_tarfopera WHERE cod IN(1005, 1006, 1007);
# para listagem
     SELECT cod,
            tag,
            nome,
            resp,
            SUBSTRING(descr, 1, 40) AS descr,
            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
            CASE
               WHEN situacao = 'espera' THEN 'em espera'
               WHEN situacao = 'ativo' THEN 'ativo'
               WHEN situacao = 'fechado' THEN 'fechado'
           END situacao
       FROM getar_opera opr
      WHERE 1 = 1;

# para edição
     SELECT cod,
            tag,
            clasf,
            nome,
            resp,
            descr,
            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
            situacao
       FROM  getar_opera
      WHERE cod= 1
            AND tag= 'ADM001';
SELECT * FROM getar_opera;

# para listagem nas boas vindas
         SELECT opr.cod,
                opr.tag,
                opr.nome,
                opr.resp,
                opr.situacao
           FROM getar_opera AS opr
          WHERE opr.situacao NOT IN('fechado', 'espera')
                AND opr.resp = 'sofia2t';

/**
** Tarefas das operações
**/
INSERT INTO getar_tarfopera (codopera, resp, dataexc, horaini, doc, situacao)
 VALUES(1, 'pregis', '2021-12-15', NOW(), 'Teste de tarefa', 'andamento');

# listando tarefas
     SELECT cod,
            tag,
            nome,
            resp,
            SUBSTRING(descr, 1, 40) AS descr,
            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
            CASE
               WHEN situacao = 'espera' THEN 'em espera'
               WHEN situacao = 'ativo' THEN 'ativo'
               WHEN situacao = 'fechado' THEN 'fechado'
           END situacao
       FROM getar_opera opr
      WHERE 1 = 1
       AND situacao NOT IN ('temporario');
# listando suas tarefas de atividades operacionais nas Boas Vindas
    SELECT  tar.cod AS cod,
            opr.nome AS nome,
            'andamento' AS situ
      FROM getar_tarfopera tar,
           getar_opera opr
     WHERE tar.codopera = opr.cod
           AND tar.situacao = 'andamento'
           AND tar.resp  = 'pregis';# $_SESSION(resps)

/**
** Classificacoes das tarefas operacionais
** 
**/
INSERT INTO getar_clasfopera (titulo, descr, situacao)
                       VALUES('Adm', 'Atividades administrativas em geral', 'ativo'),
                             ('Manu', 'Atividades manutenção e limpeza', 'ativo'),
                             ('Exp', 'Atividades expedição de rádios e vendas avulsas', 'ativo'),
                             ('Midia', 'Produção de vídeos e outras mídias de divulgação', 'ativo'),
                             ('Estq', 'Estocagem e pedidos de reposição', 'ativo');
SELECT * FROM getar_opera WHERE cod= 7;

/**
** Area de testes
**/
     SELECT cod,
            resp,
            doc,
            date_format(dataexc, '%d/%m/%Y') dia,
            date_format(dataexc, '%m') mes,
            date_format(horaini, '%k:%i') hora_ini,
            date_format(horafim, '%k:%i') hora_fim,
            date_format(SUBTIME(horafim, horaini), '%k:%i') tempotrab,
            CASE 
                WHEN situacao = 'concluido' THEN 'concluido'
                WHEN situacao = 'andamento' THEN 'andamento'
                WHEN situacao = 'cancelada' THEN 'cancelada'
            END AS situ
       FROM getar_tarfopera
      WHERE situacao != 'temporario'
            AND codopera = 1; 

INSERT INTO getar_tarfopera (resp, codopera, dataexc, horaini, horafim, doc, situacao)
                         VALUES ('sofia2t', 3, '2021-12-09', '9:41:00', '10:48:00', 'Descricao inicial da Tarefa.', 'concluida'),
                          ('sofia2t', 3, '2021-12-10', '8:09:00', '9:08:00', 'Descricao inicial da Tarefa.', 'concluida'),
                          ('sofia2t', 3, '2021-12-13', '9:09:00', '10:19:00', 'Descricao inicial da Tarefa.', 'concluida'),
                          ('sofia2t', 3, '2021-12-14', '14:51:00', '15:52:00', 'Descricao inicial da Tarefa.', 'concluida'),
                          ('sofia2t', 3, '2021-12-15', '9:52:00', '11:00:00', 'Descricao inicial da Tarefa.', 'concluida'),
                          ('sofia2t', 3, '2021-12-16', '10:42:00', '11:38:00', 'Descricao inicial da Tarefa.', 'concluida')
;

SELECT * FROM getar_tarfopera ORDER BY cod DESC;
 SELECT cod,
                                resp,
                                doc,
                                date_format(dataexc, '%d/%m/%Y') dia,
                                date_format(dataexc, '%m') mes,
                                date_format(horaini, '%k:%i') hora_ini,
                                date_format(horafim, '%k:%i') hora_fim,
                                date_format(SUBTIME(horafim, horaini), '%k:%i') tempotrab,
                                CASE 
                                    WHEN situacao = 'concluida' THEN 'concluido'
                                    WHEN situacao = 'andamento' THEN 'andamento'
                                    WHEN situacao = 'cancelada' THEN 'cancelada'
                                END AS situ
                           FROM getar_tarfopera
                          WHERE situacao != 'temporario'
                                AND codopera = 3                                 
                       ORDER BY cod DESC;

# *********
             SELECT tar.cod codtarf,
                    opr.clasf tipo,
                    date_format(tar.dataexc, '%d/%m/%Y') dia,
                    tar.dataexc AS diaSemana,
                    TIMEDIFF (tar.horafim, tar.horaini) tempo,
                    tar.horaini,
                    tar.resp resp,
                    opr.nome projeto,
                    ' ' pedido
               FROM getar_opera opr,
                    getar_tarfopera tar
              WHERE opr.cod = tar.codopera
                    AND (DATE_FORMAT(tar.dataexc, '%m')= '06')# @mes 
                    AND (DATE_FORMAT(tar.dataexc, '%Y')= '2024')# @ano
                    AND tar.situacao = 'concluida'
                    AND tar.resp='pregis';

     SELECT date_format(dataexc, '%d/%m/%Y') dia,
            # date_format(horaini, '%k:%i') hora_ini,
            horaini,
            date_format(horafim, '%k:%i') hora_fim,
            doc,
            resp,
            situacao as situ
       FROM getar_tarfopera
      WHERE cod= 2385;