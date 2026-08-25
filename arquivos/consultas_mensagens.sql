SHOW CREATE TABLE getar_mens;
CREATE TABLE `getar_mens` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `dest` varchar(100) DEFAULT NULL,
  `remt` varchar(100) DEFAULT NULL,
  `remtemail` varchar(120) NOT NULL COMMENT 'email do remetente',
  `data` date DEFAULT NULL COMMENT 'data de criacao',
  `lida` tinyint(1) DEFAULT '0',
  `texto` text,
  `situ` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`),
  KEY `fk_destmns` (`dest`),
  KEY `fk_remtmns` (`remt`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE getar_mens ADD titulo VARCHAR(120) AFTER cod;
ALTER TABLE getar_mens ADD destemail VARCHAR(120) AFTER remtemail;
ALTER TABLE getar_mens CHANGE dataenv `data` DATE;
ALTER TABLE getar_mens DROP lida;

ALTER TABLE `getar_lembre` ADD `titulo` varchar(30) DEFAULT NULL COMMENT 'Titulo do Lemprete' AFTER `dataagd`;
/**
** CONSULTAS GERAIS
**/
        INSERT INTO getar_mens (dest, remt, remtemail, dataenv, texto)
             VALUES('', '', '', CURDATE(), '');

SELECT * FROM getar_mens ORDER BY cod DESC;

              SELECT COUNT(*) num
                FROM getar_mens
               WHERE dest = 'all_admin'
                     AND situ = 'enviada';

         UPDATE getar_mens SET
                titulo='',
                dest='',
                texto='',
                situ= ''
          WHERE cod= 117;

/**
** TESTES
**/
        SELECT cod,
               remt,
               dest,
               `data`,
               lida,
               situacao
          FROM getar_mens
         WHERE dest = 'vendedor'
               AND situacao = 'ativo';

        SELECT COUNT(*) 
          FROM getar_mens
         WHERE dest = 'pregis'
               AND situacao = 'ativo'
               AND lida= '0';

        SELECT cad.nome AS remtnome,
               cad.emailcorp AS remtemail,
               (SELECT nome
                  FROM getar_cad caddt,
                       getar_control ctdt
                 WHERE caddt.cod= ctdt.codcad
                       AND ctdt.nick= 'aninha_reg') AS destnome,
               (SELECT caddt.emailcorp
                  FROM getar_cad caddt,
                       getar_control ctdt
                 WHERE caddt.cod= ctdt.codcad
                       AND ctdt.nick= 'pregis') AS destemail
          FROM getar_control ct,
               getar_cad cad
         WHERE ct.codcad = cad.cod
               AND ct.nick='pregis';

/***
**
*/
         SELECT cod,
                remt,
                date_format(dataCadastro, '%d/%m/%Y') AS dataCadastro,
                date_format(dataAgendada, '%d/%m/%Y') AS dataAgendada,
                CASE 
                    WHEN date_format(dataAgendada, '%w') = '0' THEN 'Domingo'
                    WHEN date_format(dataAgendada, '%w') = '1' THEN 'Segunda'
                    WHEN date_format(dataAgendada, '%w') = '2' THEN 'Terca'
                    WHEN date_format(dataAgendada, '%w') = '3' THEN 'Quarta'
                    WHEN date_format(dataAgendada, '%w') = '4' THEN 'Quinta'
                    WHEN date_format(dataAgendada, '%w') = '5' THEN 'Sexta'
                    WHEN date_format(dataAgendada, '%w') = '6' THEN 'Sabado'
                END AS diaSemana,
                dataAgendada AS dtAgOrd,
                SUBSTRING(texto, 1, 40) AS texto,
                situacao
           FROM getar_lembre
          WHERE situacao != 'temporario'
                AND dataAgendada >= CURDATE()
                AND situacao = 'ativo' 
                AND dest='pregis'
       ORDER BY dtAgOrd ASC;
SELECT * FROM getar_lembre;


/**
**
*/
             SELECT cod,
                    remt col3,
                    date_format(dataAgendada, '%d/%m/%Y') AS col1,
                    CASE 
                        WHEN date_format(dataAgendada, '%w') = '0' THEN 'Domingo'
                        WHEN date_format(dataAgendada, '%w') = '1' THEN 'Segunda'
                        WHEN date_format(dataAgendada, '%w') = '2' THEN 'Terca'
                        WHEN date_format(dataAgendada, '%w') = '3' THEN 'Quarta'
                        WHEN date_format(dataAgendada, '%w') = '4' THEN 'Quinta'
                        WHEN date_format(dataAgendada, '%w') = '5' THEN 'Sexta'
                        WHEN date_format(dataAgendada, '%w') = '6' THEN 'Sabado'
                    END AS col2,
                    dataAgendada dtAgOrd,
                    SUBSTRING(texto, 1,40) descr,
                    situacao
               FROM getar_lembre
              WHERE situacao != 'temporario'
                     AND cod = 27
           ORDER BY dtAgOrd ASC;

           SELECT SUBSTRING(texto, 1,40) descr,
                    cod
             FROM getar_lembre
            WHERE situacao != 'temporario'
                  AND DATE_FORMAT(dataAgendada, '%d/%m/%Y') = '27/11/2016';


SELECT * FROM getar_lembre;
UPDATE getar_lembre SET situacao= 'inativo';

             SELECT SUBSTRING(texto, 1,40) descr,
                    
                    cod
               FROM getar_lembre
              WHERE situacao = 'ativo'
                    AND DATE_FORMAT(dataAgendada, '%d/%m/%Y') = '25/01/2017';

         SELECT DATE_FORMAT(dataagd, '%d') dia,
                SUBSTRING(texto, 1,40) descr,
                dataagd,
                cod
           FROM getar_lembre
          WHERE situ = 'ativo'
                AND DATE_FORMAT(dataagd, '%m/%Y') = '03/2017'
        ORDER BY dia;

/**
** MENSAGEM
** Manutencao da tabela
**/

SELECT * FROM getar_mens ORDER BY cod DESC;
SELECT * FROM getar_mens WHERE dest= 'all_admin';
DELETE FROM getar_mens WHERE dest= 'all_admin';
TRUNCATE TABLE getar_mens;

        SELECT texto,
               `data`
          FROM getar_mens
         WHERE dest= 'all_admin'
           AND situacao= 'ativo'
           AND lida= FALSE ;

     SELECT mens.cod,
            mens.titulo,
            (SELECT cad.nome
              FROM  getar_control ctl,
                    getar_cad cad
              WHERE ctl.codcad = cad.cod
                AND ctl.nick = mens.remt) nomeremt,
            mens.remtemail,
            (SELECT cad.nome
              FROM  getar_control ctl,
                    getar_cad cad
              WHERE ctl.codcad = cad.cod
                AND ctl.nick = mens.dest) nomedest,
            mens.destemail,
            mens.data,
            mens.texto,
            mens.situ
       FROM getar_mens mens
      WHERE mens.cod = 118;
