/**
** SQL de apoio e estudos para as Ordens de Serviço
** @author Paulo Regis
**/


/**
** CONSULTAS 
**/
# para edicao
         SELECT cod codos,
                (SELECT trf.cod FROM ordem_tarf trf WHERE trf.codos = ord.cod AND trf.situ= 'andamento' LIMIT 1) codtarf,
                (SELECT GROUP_CONCAT(cod ORDER BY cod DESC) FROM ordem WHERE codeqp = ord.codeqp) osante, # OSs anteriores
                codcli,
                resp,
                (SELECT nome 
                   FROM getar_cad cad
                  WHERE codcli = cad.cod) cliente,
                valcb,
                fatu,
                vndacs,
                DATE_FORMAT(entd, '%d/%m/%Y') entd,
                DATE_FORMAT(saida, '%d') diasd,
                DATE_FORMAT(saida, '%m') messd,
                DATE_FORMAT(saida, '%Y') anosd,
                DATE_FORMAT(datafcd, '%d') diafcd,
                DATE_FORMAT(datafcd, '%m') mesfcd,
                DATE_FORMAT(datafcd, '%Y') anofcd,
                DATE_FORMAT(inicio, '%d') diaini,
                DATE_FORMAT(inicio, '%m') mesini,
                DATE_FORMAT(inicio, '%Y') anoini,
                fila,
                (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
                (SELECT MAX(fila)+ 10 FROM ordem) proxfila,
                (SELECT CONCAT(eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                   FROM equipo eq
                  WHERE eq.cod = codeqp) equipamento,
                codeqp,
                situequip,
                recla,
                encr,
                serv,
                situ
           FROM ordem ord
          WHERE cod= 510;

#  para OSs por proprietario
         SELECT eqp.cod codeqp,
                ord.cod OS,
                cad.nome cliente,
                eqp.descr,
                eqp.marca,
                eqp.modelo,
                ord.situ situos,
                eqp.situ situeqp
           FROM equipo eqp,
                getar_cad cad,
                ordem ord
          WHERE eqp.codcli = cad.cod
                AND eqp.cod = ord.codeqp
                AND cad.nome LIKE 'GIBSON%';
/**
* Equipamentos
*/
SELECT * FROM equipo WHERE cod = 654;
SELECT * FROM equipo WHERE descr LIKE 'Fonte%';
SELECT * FROM equipo ORDER BY cod DESC;
SELECT * FROM ordem ORDER BY cod DESC;
SELECT * FROM ordem WHERE cod = 671;

# para observacoes de um equipamento
     SELECT cod,
            codcli,
            (SELECT CASE
                        WHEN cad.clasf = 'c' THEN 'cli'
                        WHEN cad.clasf NOT IN('c') THEN 'naocli'
                    END 
               FROM getar_cad cad
              WHERE codcli = cad.cod) stcad,
            (SELECT nome 
               FROM getar_cad cad
              WHERE codcli = cad.cod) nome,
            hist,
            descr,
            marca,
            modelo,
            serial,
            acess,
            (SELECT texto FROM ordem_obs WHERE codeqp = cod LIMIT 1) eqpobs,
            situ
       FROM equipo
      WHERE cod= 680;

# 
        SELECT eqp.cod,
               cad.nome,
               eqp.descr,
               eqp.marca,
               eqp.modelo
          FROM equipo eqp,
               getar_cad cad
         WHERE eqp.codcli = cad.cod
               AND eqp.descr LIKE 'Fonte%';

SELECT * FROM ordem_obs WHERE 1=1 ORDER BY codobs DESC LIMIT 5;
ALTER TABLE ordem_obs ADD codeqp INT(11) COMMENT 'Codigo da obs para o equipamento' AFTER codord;
SELECT texto FROM ordem_obs WHERE codeqp = 680 LIMIT 1;

/**
** OS fechadas por mes
**/
        SELECT ord.cod,
               ord.datafcd,
               ord.situ
          FROM ordem ord
         WHERE ord.cod IN (SELECT DISTINCT codos FROM ordem_tarf WHERE DATE_FORMAT(dataexec, '%m/%Y') = '03/2023')
               AND ord.situ = 'fechada';# 9 OSs em marco de 2023, esta parecenco certo

SELECT cod, codcli, saida, datafcd, situ FROM ordem WHERE cod= 481;
SELECT dataexec FROM ordem_tarf WHERE codos= 715 ORDER BY dataexec DESC LIMIT 1;
UPDATE ordem SET datafcd= (SELECT dataexec FROM ordem_tarf WHERE codos= 499 ORDER BY dataexec DESC LIMIT 1) WHERE cod= 499;

        SELECT dataexec,
               DATE_FORMAT(dataexec, '%d') diafcd,
               DATE_FORMAT(dataexec, '%m') mesfcd,
               DATE_FORMAT(dataexec, '%Y') anofcd
          FROM ordem_tarf
         WHERE codos= 499
      ORDER BY dataexec DESC LIMIT 1;

        SELECT DISTINCT ord.cod,
               ord.datafcd,
               trf.dataexec,
               ord.situ
          FROM ordem ord,
               ordem_tarf trf
         WHERE ord.cod= trf.codos
               AND DATE_FORMAT(trf.dataexec, '%m/%Y') = '03/2023'
               AND ord.situ = 'fechada';# repete varias vezes para a mesmo OS


SELECT DISTINCT codos FROM ordem_tarf WHERE DATE_FORMAT(.dataexec, '%m/%Y') = '03/2023';
SELECT * FROM ordem_tarf WHERE cod= 7630;
# Pesqusisa por OS pagas total ou parcial
SELECT REGEXP_SUBSTR(descr, 'O[a-z]+') FROM getar_contacor WHERE descr LIKE '%OS6%';
SELECT REGEXP_SUBSTR(descr, '6[1-9]+') cod FROM getar_contacor WHERE descr LIKE '% OS6%';

        SELECT cod,
               situ
          FROM ordem
         WHERE situ = 'aberta'
               AND cod IN (SELECT REGEXP_SUBSTR(descr, '6[1-9]+') cod FROM getar_contacor WHERE descr LIKE '%OS6%');

/**
** para pesquisa por modelo
**/
    SELECT eqp.cod codeqp,
           eqp.descr descr,
           eqp.marca marca,
           eqp.modelo modelo,
           cad.nome cliente,
           ord.cod codos,
           ord.situ situos,
           ord.situ situos
      FROM equipo eqp,
           getar_cad cad,
           ordem ord
     WHERE eqp.codcli = cad.cod
           AND eqp.cod = ord.codeqp
           # AND eqp.descr LIKE '%FL%';
           AND eqp.modelo LIKE '%FP-%';

SELECT * FROM equipo WHERE modelo LIKE '%FL%';
SELECT * FROM equipo WHERE descr LIKE 'Compu%';
SELECT * FROM equipo WHERE serial = '07972';
SELECT * FROM equipo WHERE cod = 319;
SELECT * FROM equipo WHERE codcli = 1004;

SELECT * FROM ordem WHERE codeqp= 277;
SELECT * FROM ordem WHERE cod= 446;
SELECT * FROM ordem WHERE cod IN(388,387,386,389); 

/*
** INSERINDO EQUIPOS E OS
*/
INSERT INTO equipo (cod, codcli, hist, descr, marca, modelo, serial, acess, situ)
            VALUES (NULL, '781', '0', 'Placa Potencia-Maq. Lavar', 'Electrolux', 'LTC15-AW', NULL, 'Interface 64500135', 'ativo');
INSERT INTO ordem (cod, situ, valcb, situequip, vndacs, entd, saida, codcli, codeqp, recla, encr, serv)
           VALUES (NULL, 'aberta', NULL, 'Normal', NULL, '2014-07-01', NULL, '781', '7', 'LEDs que n�o apagam', NULL, NULL);
INSERT INTO ordem (cod, situ, valcb, situequip, vndacs, entd, saida, codcli, codeqp, recla, encr, serv)
           VALUES (334, 'aberta', NULL, 'Normal', NULL, '2014-07-01', NULL, '781', '308', 'Revisao', NULL, NULL);
# situ da ordem= aberta, fechada, cancelada
INSERT INTO ordem (cod, codcli, entd, codeqp, situ)
            VALUES (NULL, (SELECT codcli FROM equipo WHERE cod = 1), CURDATE(), 1, 'temporario');
INSERT INTO ordem_obs (codobs, codord, texto) VALUES('', 25, 'Dois LNK306 novos apresentaram fuga ap�s serem intalados no placa, provavelmente porque a lampada teste n�o segurou suficientemente a corrente');
SELECT * FROM equipo WHERE situ = 'temporario';
SELECT * FROM equipo WHERE modelo LIKE '%148GTL%';
SELECT * FROM equipo WHERE modelo LIKE 'FT-%' AND descr LIKE '%VHF%';
SELECT * FROM equipo WHERE descr LIKE 'Computador%';
SELECT * FROM equipo WHERE cod = 641;
SELECT * FROM equipo WHERE codcli = 966;
SELECT * FROM equipo ORDER BY cod DESC;
# procurar ordens para o equipamento
SELECT cod AS codos FROM ordem od WHERE codeqp = 177;
SELECT * FROM ordem WHERE cod = 361;

UPDATE equipo SET situ= 'sucata' WHERE descr LIKE 'PLACA%';
UPDATE equipo SET situ= 'sucata' WHERE descr LIKE 'Interface%';

/*
** CONSULTANDO OS
*/
        SELECT od.cod,
               (SELECT nome FROM getar_cad WHERE cod= od.codcli) cliente,
               eq.descr,
               eq.modelo,
               eq.marca,
               od.inicio,
               od.entd entrada,
               od.situ
          FROM ordem od,
               equipo eq
          WHERE od.codeqp = eq.cod
                AND od.situ IN('aberta', 'espera')
                # AND od.situ IN('aberta')
       ORDER BY od.inicio ASC;

SELECT * FROM ordem WHERE situ = 'cancelada';
SELECT COUNT(*) FROM ordem WHERE situ = 'aberta';
SELECT COUNT(*) FROM ordem WHERE situ = 'espera';
SELECT * FROM ordem WHERE resp <> 'pregis';
SELECT * FROM ordem ORDER BY cod DESC;
SELECT * FROM ordem WHERE codcli = 997;# consultando OSs cliente
SELECT * FROM ordem WHERE cod = 642;
SELECT * FROM equipo ORDER BY cod DESC;
SELECT * FROM equipo WHERE cod=384;
SELECT * FROM ordem WHERE cod IN(160, 154, 158, 153, 157, 155, 156);
UPDATE ordem SET resp = 'pregis' WHERE situ = 'aberta';
UPDATE ordem SET situ= 'cancelada' WHERE situ = 'aberta';

SELECT COUNT(*) FROM ordem WHERE situ = 'aberta';
SELECT COUNT(*) FROM ordem WHERE situ = ;
SELECT cod, situ FROM ordem WHERE inicio = '000-00-00' AND situ IN('aberta', 'espera');


# ------------------------------------

            SELECT cod,
                   codcli,
                   (SELECT CASE
                               WHEN cad.clasf = 'c' THEN 'cli'
                               WHEN cad.clasf NOT IN('c') THEN 'naocli'
                           END 
                      FROM getar_cad cad
                     WHERE codcli = cad.cod) stcad,
                   (SELECT nome 
                      FROM getar_cad cad
                     WHERE codcli = cad.cod) cliente,
                   valcb,
                   vndacs,
                   entd,
                   saida,
                   (SELECT CONCAT(eq.descr, ' - ', eq.marca)
                      FROM equipo eq
                     WHERE eq.cod = codeqp) equipamento,
                   codeqp,
                   situequip,
                   recla,
                   encr,
                   serv,
                   situ
              FROM ordem od
             WHERE cod= 19;
UPDATE ordem SET codcli = 781 WHERE cod = 19;

/**
** Consultando uma OS
*/
                 SELECT cod codos,
                        (SELECT trf.cod FROM ordem_tarf trf WHERE trf.codos= ord.cod AND trf.situ= 'andamento') codtarf,
                        codcli,
                        resp,
                        (SELECT nome 
                           FROM getar_cad cad
                          WHERE codcli = cad.cod) cliente,
                        valcb,
                        fatu,
                        vndacs,
                        DATE_FORMAT(entd, '%d/%m/%Y') entd,
                        DATE_FORMAT(saida, '%d') diasd,
                        DATE_FORMAT(saida, '%m') messd,
                        DATE_FORMAT(saida, '%Y') anosd,
                        DATE_FORMAT(datafcd, '%d') diafcd,
                        DATE_FORMAT(datafcd, '%m') mesfcd,
                        DATE_FORMAT(datafcd, '%Y') anofcd,
                        datafcd,
                        (SELECT CONCAT(eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                           FROM equipo eq
                          WHERE eq.cod = codeqp) equipamento,
                        codeqp,
                        situequip,
                        recla,
                        encr,
                        serv,
                        situ
                   FROM ordem ord
                  WHERE cod= 243;

SELECT * FROM ordem_tarf WHERE cod= 1269;
SELECT * FROM ordem_tarf WHERE situ= 'andamento';


SELECT * FROM ordem WHERE cod = 25;
SELECT cod FROM estpedidocab WHERE ospro = 25;

/**
** CONSULTANDO EQUIPAMENTO
*/
             SELECT cod,
                    codcli,
                    (SELECT CASE
                                WHEN cad.clasf = 'c' THEN 'cli'
                                WHEN cad.clasf NOT IN('c') THEN 'naocli'
                            END 
                       FROM getar_cad cad
                      WHERE codcli = cad.cod) stcad,
                    (SELECT nome 
                       FROM getar_cad cad
                      WHERE codcli = cad.cod) cliente,
                    hist,
                    descr,
                    marca,
                    modelo,
                    serial,
                    acess,
                    situ
               FROM equipo 
              WHERE cod = 1;
                    # situ NOT IN('temporario');


         SELECT od.cod,
                (SELECT nome FROM getar_cad WHERE cod= od.codcli) cliente,
                eq.descr,
                eq.marca,
                DATE_FORMAT(od.entd, '%d/%m/%Y') entrada,
                (SELECT codret FROM ordem_ret WHERE codord = od.cod) OS_ret,
                od.fatu,
                od.situ
           FROM ordem od,
                equipo eq
           WHERE od.codeqp = eq.cod
             ORDER BY descr, entrada DESC;
SELECT ord.cod FROM equipo eqp, ordem ord WHERE ord.codeqp = eqp.cod AND eqp.codcli= 944;
SELECT cod, descr, marca, modelo, (SELECT nome FROM getar_cad WHERE cod= codcli) nome FROM equipo WHERE descr LIKE('Compu%');
SELECT * FROM equipo WHERE cod= 597;
SELECT * FROM equipo ORDER BY cod DESC;
SELECT * FROM ordem_obs ORDER BY codord;
SELECT * FROM ordem WHERE cod= 518;
SELECT * FROM ordem ORDER BY cod;
SELECT * FROM ordem_obs WHERE texto= '';
UPDATE ordem_obs SET texto = ' 2 LNK306 novos apresentaram fuga ...' WHERE codord=8;
DELETE FROM ordem_obs WHERE texto= ''; 

/**
** INSERINDO TAREFAS A ORDEM
*/
INSERT INTO ordem_tarf (codos, tecn, dataexec, horaini, horafim, descr, situ)
                 VALUES(63, 'pregis', CURDATE(), '20:20', '21:00', 'Testes na fonte. Tudo OK', 'concluida');
INSERT INTO ordem_tarf (codos, tecn, dataexec, horaini, horafim, descr, situ)
                 VALUES(58, 'pregis', '2014-10-08', '13:00', '14:00', 'Estudos e testes cuidadosos com lampada teste', 'concluida');
SELECT cod, codos, dataexec, horaini, horafim FROM ordem_tarf WHERE descr LIKE('%benzina%');
SELECT cod, codos, dataexec, horaini, horafim FROM ordem_tarf WHERE codos= 661;
SELECT cod, codos, dataexec, horaini, horafim FROM ordem_tarf WHERE cod IN(7543, 7544, 7545, 7546, 7547);
SELECT codos, dataexec, horaini, horafim FROM ordem_tarf WHERE cod= 7418;
SELECT horaini, descr FROM ordem_tarf WHERE codos= 289 AND tecn = 'pregis';
SELECT horaini, horafim, descr, dataexec, situ FROM ordem_tarf WHERE codos= 289 AND situ NOT IN('concluida');

# detalhando todas as tarefas de uma OS
     SELECT cod,
            DATE_FORMAT(dataexec, '%d/%m/%Y') dataexec,
            DATE_FORMAT(horaini, '%k:%i') horaini,
            TIMEDIFF(horafim, horaini) AS tempo,
            '-',
            horaini,
            horafim,
            tecn,
            descr,
            situ
       FROM ordem_tarf
      WHERE codos = 284
            AND situ = 'concluida';
            
             SELECT trf.codos,
                    (SELECT nome FROM getar_cad cad WHERE ord.codcli = cad.cod) nome,
                    eqp.descr,
                    eqp.marca,
                    eqp.modelo,
                    # ---,
                    trf.situ,
                    trf.tecn
               FROM ordem_tarf trf,
                    ordem ord,
                    equipo eqp
              WHERE trf.codos = ord.cod
                    AND ord.codeqp = eqp.cod
                    AND trf.situ = 'andamento'
                    AND trf.tecn= 'pregis';
SELECT * FROM ordem_tarf WHERE situ= 'andamento';

# calculando horas trabalhadas
SELECT DATE_FORMAT(SEC_TO_TIME(SUM(SEC_TO_TIME(TIMEDIFF(horafim, horaini)))), '%H:%i') AS tothora FROM ordem_tarf WHERE codos = 325;
SELECT TRUNCATE((SUM(TIMEDIFF(horafim, horaini))/8255), 0) AS tothora FROM ordem_tarf WHERE codos = 615;
SELECT DATE_FORMAT(SEC_TO_TIME(TIMEDIFF(horafim, horaini)), '%H:%i') AS tothora FROM ordem_tarf WHERE cod = 607;
SELECT SEC_TO_TIME(TIMEDIFF(horafim, horaini)) AS tempo FROM ordem_tarf WHERE cod = 607;
SELECT TIMEDIFF(horafim, horaini) AS tempo FROM ordem_tarf WHERE cod IN(528, 529);
SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))) AS tempo FROM ordem_tarf WHERE cod = 607;

# Encontrando um tarefa mal fechada
SELECT DATE_FORMAT(horafim, '%H:%i') FROM ordem_tarf WHERE cod = 6875;
SELECT * FROM ordem_tarf WHERE cod = 6875;
SELECT horafim FROM ordem_tarf WHERE codos = 655 AND DATE_FORMAT(horafim, '%H:%i') = '00:00';

        SELECT ord.cod codos,
               trf.cod codtarf,
               CASE
                   WHEN DATE_FORMAT(trf.horafim, '%H:%i') = '00:00' THEN 'ERRO'
                   WHEN DATE_FORMAT(trf.horafim, '%H:%i') <> '00:00' THEN 'OK'
               END horafim
          FROM ordem_tarf trf,
               ordem ord
         WHERE ord.cod = trf.codos
               AND ord.situ IN('aberta', 'espera')
               AND trf.situ = 'concluida'
               AND DATE_FORMAT(trf.horafim, '%H:%i') = '00:00';
SELECT * FROM  ordem_tarf ORDER BY cod DESC LIMIT 10;

# SQL usado na listagem das tarefas
     SELECT cod,
            DATE_FORMAT(dataexec, '%d/%m/%Y') dataexec,
            DATE_FORMAT(horaini, '%k:%i') horaini,
            TIMEDIFF(horafim, horaini) AS tempo,
            tecn,
            descr
       FROM ordem_tarf
      WHERE codos = 284
            AND situ = 'concluida';
# SQL usada para totalizar as horas
     SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))), '%H:%i') AS tothora
       FROM ordem_tarf WHERE codos= 325;

SELECT DATE_FORMAT(SUM(TIMEDIFF(horafim, horaini)), '%H') FROM ordem_tarf WHERE codos= 325; # null

        SELECT SUM(DATE_FORMAT((TIMEDIFF(horafim, horaini)), '%H')) hora,
               SUM(DATE_FORMAT((TIMEDIFF(horafim, horaini)), '%i')) minu
          FROM ordem_tarf
         WHERE codos= 284;
               AND situ = 'concluida'; 

SELECT * FROM ordem_tarf WHERE cod= 4706;

/**
** Trabalhando com hashtag #
** extract rashtags from text mysql
https://dev.mysql.com/doc/refman/8.0/en/regexp.html#function_regexp-substr
**/
SELECT cod, codos, descr FROM ordem_tarf WHERE descr LIKE ('%#%');
SELECT cod, codos, descr FROM ordem_tarf WHERE cod = 7018;
SELECT cod, codos, REGEXP_SUBSTR(descr, '#[a-z]+') AS TAG FROM ordem_tarf WHERE cod IN (6892, 6891, 6890, 6889, 6888);
SELECT cod, codos, REGEXP_SUBSTR(descr, '#[a-z]+') AS TAG FROM ordem_tarf WHERE codos = 717;
# contando o numero de hashtag por tarefa, não pode ser maior do que 1 por TRARF
SELECT COUNT(*) FROM ordem_tarf WHERE descr LIKE ('%#%') AND cod = 6892;

SELECT codobs, codord, REGEXP_SUBSTR(texto, '#[a-z]+') hashtage FROM ordem_obs WHERE codord= 600;
SELECT codobs, codord, REGEXP_SUBSTR(texto, '#[a-z]+') hashtage FROM ordem_obs ORDER BY codobs DESC LIMIT 20;

        SELECT codobs,
               codord,
               hashtag
               FROM (SELECT codobs, codord, REGEXP_SUBSTR(texto, '#[a-z]+') hashtag FROM ordem_obs ORDER BY codobs DESC LIMIT 20) xxx
               WHERE hashtag LIKE ('%#%');
# WHERE hashtag = '#soalinhamento';
        # WHERE codord= 672; #soalinhamento

# passando para a listagem em uso
SELECT ord.cod,
                    cad.nome cliente,
                    ord.retorno,
                    ord.fila,
                    (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
                    DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
                    DATE_FORMAT(ord.entd, '%d/%m/%Y') entrada,
                    REGEXP_SUBSTR(obs.texto, '#[a-z]+') hashtag,
                    cad.nome nome,
                    eqp.descr descr,
                    eqp.marca marca,
                    eqp.modelo modelo,
                ord.situ
               FROM ordem ord,
                    ordem_obs obs,
                    getar_cad cad,
                    equipo eqp
              WHERE ord.cod = obs.codord
                    AND ord.codcli = cad.cod
                    AND ord.codeqp = eqp.cod
                         # inicio complemento
                         AND ord.cod IN (SELECT 
               codord
               FROM (SELECT codobs, codord, REGEXP_SUBSTR(texto, '#[a-z]+') hashtag FROM ordem_obs) xxx
               WHERE hashtag LIKE ('%#%'))
               AND ord.situ IN ('aberta', 'espera')
               # fim complemento
                 ORDER BY fila ASC;
# Pequisas tipo IA, para ajudar a ver defeitos semelhantes nas tarefas
SELECT * FROM ordem_tarf WHERE descr LIKE('%baixa potencia%');

       SELECT trf.cod codtarf,
              ord.cod codos,
              eqp.modelo modelo,
              trf.descr descr
         FROM ordem_tarf trf,
              ordem ord,
              equipo eqp
        WHERE ord.codeqp = eqp.cod
              AND ord.cod = trf.codos
              AND eqp.modelo = 'IC-706MKII'
              AND trf.descr LIKE('%driver%');

/**
** Estudo sobre data de inicio e enfileiramento
**/
ALTER TABLE ordem ADD `inicio` DATE DEFAULT NULL COMMENT 'Data prevista inicio trabalhos' AFTER `entd`;
ALTER TABLE ordem ADD `fila` INT(11) DEFAULT NULL COMMENT 'Infileiramento' AFTER `situ`;
ALTER TABLE `ordem` CHANGE `fila` `fila` INT(11) NULL DEFAULT '0' COMMENT 'Infileiramento';

# ***************************************
SELECT cod, entd, inicio, saida, datafcd, situ FROM ordem WHERE cod= 230;
SELECT cod, entd, inicio, fila, situ FROM ordem WHERE situ IN('espera', 'aberta') ORDER BY inicio ASC, situ ASC;
SELECT cod, entd, inicio, fila, situ FROM ordem WHERE situ = 'programada' ORDER BY inicio ASC, situ ASC;
SELECT cod, entd, inicio, fila, saida, datafcd, situ FROM ordem WHERE situ = 'aberta' ORDER BY entd ASC;
SELECT cod, entd, inicio, fila, saida, datafcd, situ FROM ordem WHERE situ = 'aberta' ORDER BY fila ASC;
UPDATE ordem SET saida= NULL, datafcd= NULL WHERE cod= 230;
UPDATE ordem SET saida= NULL, datafcd= NULL WHERE situ IN('espera', 'aberta');
UPDATE ordem SET inicio= '2025-11-19' WHERE situ = 'programada' AND inicio='2025-10-30';
SELECT cod, entd, inicio, saida, datafcd, situ FROM ordem WHERE cod= 230;
SELECT cod, entd, inicio, fila, situ FROM ordem WHERE inicio ='2025-08-11';
SELECT cod, entd, inicio, fila, situ FROM ordem WHERE cod IN(431,639);
SELECT cod, entd, inicio, fila, situ FROM ordem WHERE situ = 'programada';

# Avaliando OS por ordem de entrada, indepedente de possicao fila
       SELECT ord.cod,
              (SELECT nome FROM getar_cad WHERE cod= ord.codcli) cliente,
              eqp.descr AS descr,
              CONCAT(eqp.marca, '/', eqp.modelo) AS marca,
              DATE_FORMAT(ord.entd, '%d/%m/%Y') entd,
              DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
              (SELECT TRUNCATE((SUM(TIMEDIFF(horafim, horaini))/8255), 0) FROM ordem_tarf WHERE codos = ord.cod) tothoras,
              ord.fila,
              ord.situ
         FROM ordem ord,
              equipo eqp
        WHERE ord.codeqp = eqp.cod
              AND ord.situ = 'aberta'
     ORDER BY ord.entd ASC; 

# Ordenando fila conforme data de entrada
        SELECT ord.cod,
               eqp.modelo,
               ord.entd,
               ord.inicio,
               ord.fila,
               ord.situ
          FROM ordem ord,
               equipo eqp
         WHERE ord.fila NOT IN(0)
               AND ord.codeqp = eqp.cod
      ORDER BY ord.fila ASC;
SELECT cod, fila FROM ordem WHERE fila >0 AND fila <50;

SELECT cod, entd, inicio, fila, saida, datafcd, situ FROM ordem WHERE fila NOT IN(0) ORDER BY fila ASC;

# 
        SELECT od.cod,
               od.entd,
               od.inicio,
               CASE
                   WHEN od.fila = 0 THEN 'nf'
                   WHEN od.fila > 0 THEN od.fila
               END fila,
               (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <od.fila AND fila NOT IN(0)) ord,
               od.saida,
               od.datafcd,
               od.situ
          FROM ordem od
         WHERE od.situ IN('espera', 'aberta')
        ORDER BY fila; 


SELECT cod, fila, situ FROM ordem WHERE cod IN(550, 551);
SELECT cod, fila, situ FROM ordem WHERE fila> 0;

SELECT COUNT(*) nm FROM ordem WHERE fila= 10;
SELECT COUNT(*) nm FROM ordem od WHERE fila <30 AND fila NOT IN(0);

# Classficando os empurra fila
SELECT cod, fila, situequip, situ FROM ordem WHERE cod = 511;
SELECT cod, fila, codeqp, situequip, situ FROM ordem WHERE situequip = 'ruim';
SELECT DISTINCT situequip FROM ordem LIMIT 20;
SELECT situ FROM equipo LIMIT 20;

        SELECT cod,
               entd,
               inicio,
               fila,
               saida,
               datafcd,
               situ
          FROM ordem
         WHERE fila IS NOT NULL
               AND inicio <= CURDATE()
               AND situ IN('espera', 'aberta');

        UNION (SELECT cod,
                      entd,
                      inicio,
                      100 fila,
                      saida,
                      datafcd,
                      situ
                 FROM ordem
                WHERE fila IS NULL
                      AND situ IN('espera', 'aberta'))
      ORDER BY fila ASC, inicio ASC, situ ASC;

/**
* Para o calendario
**/
               SELECT DISTINCT(DATE_FORMAT(inicio, '%m')) mes,
                      DATE_FORMAT(inicio, '%Y') ano,
                      inicio # para ordenar
                 FROM ordem
                WHERE situ IN('aberta', 'programada')
                      AND DATE_FORMAT(inicio, '%Y') = DATE_FORMAT(CURDATE(), '%Y')
             ORDER BY inicio ASC;

# [estudo] Listagem da OS trabalhadas por dia
               SELECT DISTINCT(DATE_FORMAT(trf.dataexec, '%m')) mes,
                      DATE_FORMAT(trf.dataexec, '%Y') ano,
                      trf.dataexec inicio # para ordenar
                 FROM ordem ord,
                      ordem_tarf trf
                WHERE ord.cod = trf.codos
                      AND trf.situ = 'concluida'
                      AND DATE_FORMAT(trf.dataexec, '%m/%Y') = DATE_FORMAT(CURDATE(), '%m/%Y')
             ORDER BY inicio ASC;
SELECT cod, codos, dataexec, situ FROM ordem_tarf ORDER BY cod DESC LIMIT 6;

# ver tambem funcao OSMes() na funcoes_os.php
             SELECT DISTINCT ord.cod,
                    DATE_FORMAT(trf.dataexec, '%d') dia
               FROM  ordem ord,
                     ordem_tarf trf
              WHERE ord.cod = trf.codos
                    AND DATE_FORMAT(trf.dataexec, '%m/%Y') = '06/2024'
                    AND trf.situ = 'concluida'
              ORDER BY dia;

# ordenando somente por data inicio
        SELECT cod OS,
               DATE_FORMAT(entd, '%m/%y') entrada,
               DATE_FORMAT(inicio, '%m/%y') inicio,
               (SELECT nome FROM getar_cad WHERE cod = ord.codcli) cliente,
               (SELECT modelo FROM equipo WHERE cod= ord.codeqp) equipamento
          FROM ordem ord
         WHERE situ IN('aberta', 'aberta')
      ORDER BY inicio ASC;

SELECT MAX(fila) FROM ordem;


/**
** Re-programando OSs
**/
SELECT cod, situ, inicio FROM ordem WHERE DATE_FORMAT(inicio, '%d/%m/%Y')='29/05/2022';

UPDATE ordem SET inicio='2023-04-17' WHERE DATE_FORMAT(inicio, '%d/%m/%Y')='10/04/2023' AND situ='aberta';

UPDATE ordem SET inicio='2023-01-23' WHERE cod IN(540,541);

UPDATE ordem SET inicio='2023-09-11' WHERE cod = 584;

UPDATE ordem SET inicio='2023-10-11' WHERE inicio='2023-09-13' AND situ NOT IN('fechada', 'cancelada', 'espera');

SELECT cod, inicio, codeqp FROM ordem WHERE situ = 'fechada';
SELECT cod, inicio, codeqp FROM ordem WHERE situ = 'cancelada';
SELECT cod, inicio, codeqp FROM ordem WHERE situ = 'espera';
SELECT cod, inicio, fila, codeqp, situ FROM ordem WHERE situ = 'programada';
SELECT cod, inicio, fila, codeqp, situ FROM ordem ORDER BY cod DESC;
SELECT * FROM equipo ORDER BY cod DESC;
SELECT cod, fila, retorno, situ FROM ordem WHERE cod= 574;

# vendo erros de infileiramento
SELECT cod, fila, inicio FROM ordem WHERE fila> 0 AND situ = 'aberta' ORDER BY inicio ASC, fila ASC;
SELECT cod, fila, inicio FROM ordem WHERE fila> 0 AND situ NOT IN('aberta');
UPDATE ordem SET fila=0 WHERE fila> 0 AND situ NOT IN('aberta');
UPDATE ordem SET situ = 'cancelada' WHERE situ = 'programada';

# empurrando todas X semanas
UPDATE ordem SET dtrepro = inicio WHERE fila NOT IN(0); # campo temporario
# UPDATE ordem SET inicio = DATE_ADD(dtrepro, INTERVAL 2 WEEK) WHERE fila NOT IN(0); # todas
UPDATE ordem SET inicio = DATE_ADD(dtrepro, INTERVAL 2 WEEK) WHERE fila NOT IN(0) AND inicio > '2024-03-25'; # apartir de X data


# listando OSs enfileradas mas pela data inicio: estao desordenadas
        SELECT cod,
               inicio,
               entd,
               codeqp,
               fila
          FROM ordem
         WHERE fila <> 0
               OR cod IN(570)
      ORDER BY inicio ASC;

# Com descricao Equipamento e Proprietario
        SELECT ord.cod,
               ord.inicio,
               ord.codeqp,
               (SELECT modelo FROM equipo WHERE cod = ord.codeqp) modelo,
               (SELECT nome FROM getar_cad WHERE cod = ord.codcli) proprietario,
               ord.fila
          FROM ordem ord
         WHERE ord.fila <> 0
      ORDER BY ord.inicio ASC;

# listatando OSs com tags nas observacoes
SELECT * FROM ordem_obs WHERE texto LIKE('%#soh_revisão/alinhamento%');
SELECT * FROM ordem_obs WHERE texto LIKE('%#com_pesquisa_defeito%');

        SELECT ord.cod,
               eqp.marca,
               eqp.descr,
               cad.nome,
               ord.entd,
               ord.inicio
        FROM ordem ord,
             ordem_obs obs,
             getar_cad cad,
             equipo eqp
       WHERE ord.cod = obs.codord
             AND ord.codeqp = eqp.cod
             AND ord.codcli = cad.cod
             # AND obs.texto LIKE('%#soh_revisão/alinhamento%')
             AND obs.texto LIKE('%#pra_avaliar%')
             # AND obs.texto LIKE('%#com_pesquisa_defeito%')
            ORDER BY ord.cod;

# listando OS em fila
        SELECT ord.cod,
               ord.fila,
               (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
               DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
               DATE_FORMAT(ord.entd, '%d/%m/%Y') entd,
               cad.nome nome,
               eqp.descr descr,
               eqp.modelo modelo
          FROM ordem ord,
               getar_cad cad,
               equipo eqp
         WHERE ord.codcli = cad.cod
               AND ord.codeqp = eqp.cod
               AND ord.fila NOT IN(0)
         ORDER BY fila;

# listando OS paga em aberta
        SELECT ord.cod,
               ord.fila,
               (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
               DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
               DATE_FORMAT(ord.entd, '%d/%m/%Y') entd,
               cad.nome nome,
               eqp.descr descr,
               eqp.modelo modelo
          FROM ordem ord,
               getar_cad cad,
               equipo eqp
         WHERE ord.codcli = cad.cod
               AND ord.codeqp = eqp.cod
               AND ord.valcb > 0
               AND ord.situ = 'aberta'
         ORDER BY fila;
# pagamento parcial, soh registrado na Obs
        SELECT obs.codord
          FROM ordem_obs obs,
               ordem ord
        WHERE obs.codord = ord.cod
              AND obs.texto LIKE('% paga%')
              AND ord.situ= 'aberta'
              AND ord.valcb = 0;

# Somando +7 dias na data de inicio
SELECT DATE_ADD("2017-08-25", INTERVAL 10 DAY);

# atualizando campo dtrepro
UPDATE ordem SET dtrepro = inicio WHERE fila NOT IN(0);
# reprogramando com base no campo dtrepro
UPDATE ordem SET inicio = DATE_ADD(dtrepro, INTERVAL 8 WEEK) WHERE fila NOT IN(0);

UPDATE ordem SET dtrepro = inicio WHERE cod IN(594);

UPDATE ordem SET inicio = DATE_ADD(dtrepro, INTERVAL 1 MONTH) WHERE cod IN(594);
UPDATE ordem SET inicio = DATE_ADD(dtrepro, INTERVAL 1 WEEK) WHERE cod IN(594);
UPDATE ordem SET inicio = DATE_ADD(dtrepro, INTERVAL 7 DAY) WHERE fila NOT IN(0);

SELECT GROUP_CONCAT(cod ORDER BY cod DESC) FROM ordem WHERE codeqp = 497;

INSERT INTO ordem (cod, codcli, entd, inicio, codeqp, resp, situ)
           VALUES (NULL, (SELECT codcli FROM equipo WHERE cod = 497), CURDATE(), CURDATE(), 497,'pregis', 'temporario');

/**
** CORRIGINDO ERROS
**/
      SELECT ord.cod AS cod,
            (SELECT nome FROM getar_cad WHERE cod= ord.codcli) cliente,
            eqp.descr AS descr,
            CONCAT(eqp.marca, '/', eqp.modelo) AS marca,
            DATE_FORMAT(ord.entd, '%d/%m/%Y') entd,
            DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
            CASE
                WHEN fila = 0 THEN 9999
                WHEN fila > 0 THEN fila
            END fila,
            (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
            ord.retorno,
            ord.situ
       FROM ordem ord,
            equipo eqp
      WHERE ord.codeqp = eqp.cod
            AND ord.situ IN('aberta', 'programada')
            AND ord.inicio <= CURDATE()
            AND ord.resp = 'pregis'
    ORDER BY fila ASC, inicio DESC;

     SELECT cad.nome,
            cad.cpcn,
            cad.endr,
            cad.bairro,
            cad.cep,
            cad.cidade,
            cad.estado,
            cad.pais
      FROM ordem ord,
           getar_cad cad
     WHERE ord.codcli = cad.cod
           AND ord.cod= 544;

     SELECT cad.nome,
            cad.cpcn,
            cad.endr,
            cad.bairro,
            cad.cep,
            cad.cidade,
            cad.estado,
            (SELECT fn.numero FROM getar_fones fn WHERE fn.codcli = cad.cod LIMIT 1) fone,
            cad.pais
      FROM ordem ord,
           getar_cad cad
     WHERE ord.codcli = cad.cod
           AND ord.cod= 552;

SELECT cod FROM ordem WHERE situ= 'aberta' ORDER BY cod DESC LIMIT 1;

SELECT cod FROM estpedidocab WHERE tipo = 'venda' AND ospro = 645;

 SELECT eqp.cod codeqp,                
                        cad.nome cliente,
                        eqp.descr,
                        eqp.marca,
                        eqp.modelo,
                        ord.cod codos,
                        ord.situ situos,
                        eqp.situ situeqp
                   FROM equipo eqp,
                        getar_cad cad,
                        ordem ord
                  WHERE eqp.codcli = cad.cod
                        AND eqp.cod = ord.codeqp
                        AND eqp.situ NOT IN('sucata')
                        AND ord.situ NOT IN('cancelada')
                        AND eqp.situ NOT IN('temporario')
                  ORDER BY eqp.cod DESC
                  LIMIT 20;

# ERRO AO PESQUISAR DADOS!!
# Unknown column 'eqp.nome' in 'order clause'
                 SELECT eqp.cod codeqp,                
                        cad.nome cliente,
                        eqp.descr,
                        eqp.marca,
                        eqp.modelo,
                        ord.cod codos,
                        ord.situ situos,
                        eqp.situ situeqp
                   FROM equipo eqp,
                        getar_cad cad,
                        ordem ord
                  WHERE eqp.codcli = cad.cod
                        AND eqp.cod = ord.codeqp
                        # AND eqp.situ NOT IN('sucata')
                        # AND ord.situ NOT IN('cancelada')
                        AND eqp.situ NOT IN('temporario')
                        # AND eqp.descr LIKE 'FT-100D%' 
                        AND eqp.modelo LIKE 'FT-100D%' 
                  ORDER BY eqp.modelo ASC
                  LIMIT 20;

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
) ENGINE=InnoDB AUTO_INCREMENT=726 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Cadastro dos equipamento consertado nas OS';