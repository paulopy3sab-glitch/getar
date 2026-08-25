/**
** ver estrutura das tabelas em:incio_projeletro.sql
**/


/*
*** listagem de projetos
*/
         SELECT cod,
                nome,
                SUBSTRING((SELECT nome FROM getar_cad WHERE cod= proj.cliente ), 1, 20) AS cliente,
                SUBSTRING(descr, 1, 20) AS descr,
                DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                CASE
                   WHEN situacao = 'n' THEN 'negociacao'
                   WHEN situacao = 'e' THEN 'em estudos'
                   WHEN situacao = 's' THEN 'em espera'
                   WHEN situacao = 'a' THEN 'em andamento'
                   WHEN situacao = 'f' THEN 'fechado'
                   WHEN situacao = 'x' THEN 'cancelado'
               END situacao,
               CASE 
                   WHEN situ IN('f', 'x') THEN 'n'
                   ELSE 's'
               END editavel
           FROM eletro_projetos proj
          WHERE situacao NOT IN('temporario', 'fechado', 'cancelado');
          # AND situacao = 'a' ORDER BY nome ASC;
          
/* CONSULTA RAPIDA */
        SELECT cod,
               nome,
               DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
               situacao
          FROM eletro_projetos proj
         WHERE situacao NOT IN('temporario', 'x', 'f');

SELECT * FROM eletro_projetos;
/*
Listagem dos pedido
*/
INSERT INTO eletro_pedidos (titulo, resp, prioridade, fatu, doc, situacao, codproj, datareg, dataini, dataclc)
                         VALUES ('Pedido Novo', 'pregis', 'b', 0, '', 'temporario', 13, CURDATE(), CURDATE(), CURDATE());
SELECT * FROM eletro_pedidos WHERE codproj= 15;

     SELECT ped.cod codped,
            prj.nome nome_proj,
            ped.codproj projeto,
            dataini,
            prioridade,
            titulo,
            ped.situacao
       FROM eletro_projetos prj,
            eletro_pedidos ped
      WHERE prj.cod = ped.codproj
            AND ped.situacao != 'temporario'
            AND codproj= 1
            # AND resp = 'pregis'
            # AND situ NOT IN('c', 'x') 
     ORDER BY ped.situacao, prioridade, dataini;


/**
**Detalhamento de um pedido
**/
    SELECT date_format(dataexc, '%d/%m/%Y') dia,
           date_format(horaini, '%k:%i') hora_ini,
           date_format(horafim, '%k:%i') hora_fim,
           doc,
           resp,
           codped,
           CASE 
                WHEN situacao = 'c' THEN 'concluido'
                WHEN situacao = 't' THEN 'andamento'
                WHEN situacao = 'a' THEN 'andamento'
           END as st
      FROM eletro_tarefas
     WHERE cod= 19;

SELECT * FROM eletro_tarefas WHERE cod= 629;

      SELECT SUM((TIME_TO_SEC(horafim) - TIME_TO_SEC(horaini))) tempo,
             horaini,
             horafim,
             situacao
        FROM eletro_tarefas
       WHERE situacao NOT IN('x', 'temporario')
             AND codped = '39';

SELECT * FROM eletro_tarefas WHERE cod = 799;
SELECT * FROM eletro_tarefas WHERE cod= 773;
SELECT * FROM eletro_pedidos WHERE cod = 14;
SELECT * FROM eletro_pedidos ORDER BY cod DESC;
SELECT * FROM eletro_projetos WHERE cod = 5;
SELECT * FROM eletro_tarefas WHERE codped = 57;# V3.0
SELECT * FROM eletro_tarefas WHERE cod = 690;# V3.0
SELECT * FROM eletro_tarefas WHERE codped = 61;# V4.0
DELETE FROM eletro_pedidos WHERE cod = 22;

INSERT INTO eletro_pedidos (titulo, resp, codproj, datareg, dataini, dataclc, situacao)
                        VALUES ('Titulo do Pedido em SQL', 'pregis', 15, CURDATE(), CURDATE(), CURDATE() , 'temporario');
INSERT INTO eletro_tarefas (resp, codped, dataexc, horaini, doc, situacao)
                    VALUES ('pregis', 45, CURDATE(), CURTIME(), 'Descricao', 'temporario');
SELECT cod, codped, dataexc, horaini, horafim, situacao FROM eletro_tarefas ORDER BY cod DESC LIMIT 5;
ALTER TABLE `eletro_tarefas` CHANGE `horaini` `horaini` TIME NULL DEFAULT NULL;
ALTER TABLE `eletro_tarefas` CHANGE `horafim` `horafim` TIME NULL DEFAULT NULL;

                 SELECT pj.nome AS nomeproj,
                        pj.cod AS codproj,
                        pd.titulo,
                        pd.cod AS codped
                   FROM eletro_pedidos AS pd,
                        eletro_projetos AS pj,
                        eletro_tarefas AS tr
                  WHERE pj.cod= pd.codproj
                        AND pd.cod= tr.codped
                        AND tr.cod= 186;

SELECT projetos.nome AS nome,
                        projetos.cod AS cod,
                        tarefas.pedido AS codPedido
                   FROM getar_pedidos AS pedidos,
                        getar_projetos AS projetos,
                       getar_tarefas AS tarefas
                  WHERE
                        projetos.cod= pedidos.projeto
                        AND pedidos.cod= tarefas.pedido
                        AND tarefas.cod= 610

              SELECT cod,
                    nome,
                    SUBSTRING((SELECT nome FROM getar_cad WHERE cod= proj.cliente ), 1, 20) AS cliente,
                    SUBSTRING(descr, 1, 20) AS descr,
                    DATE_FORMAT(datareg, '%d/%m/%Y') datareg
               FROM getar_projetos proj
              WHERE situacao != 'temporario';

            SELECT nome,
                   SUBSTRING((SELECT nome FROM getar_cad WHERE cod= cliente ), 1, 20) AS cliente,
                   descr,
                   DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                   CASE
                       WHEN situacao = 'n' THEN 'negociacao'
                       WHEN situacao = 'e' THEN 'em estudos'
                       WHEN situacao = 's' THEN 'em espera'
                       WHEN situacao = 'a' THEN 'em andamento'
                       WHEN situacao = 'f' THEN 'fechado'
                       WHEN situacao = 'x' THEN 'cancelado'
                   END situacao,
                   CASE 
                       WHEN situacao IN('f', 'x') THEN 'n'
                       ELSE 's'
                   END editavel
              FROM getar_projetos
             WHERE cod='58';

/***/
        SELECT (SELECT nome
                            FROM getar_cad cad
                           WHERE ctl.codcad = cad.cod) AS nome,
               ctl.nick
          FROM getar_control ctl
            WHERE ctl.nick = 'pregis';

         SELECT proj.nome AS projeto,
                proj.cod AS codproj,
                ped.titulo 
           FROM eletro_pedidos ped,
                eletro_projetos AS proj
          WHERE proj.cod= ped.codproj
                AND ped.cod= 33; 


/**
** Consulta pedidos abertos e vencidos
**/
        SELECT pedido.cod,
               projeto.nome,
               DATE_FORMAT(pedido.dataini, '%d/%m/%Y') dataini,
               pedido.prior,
               pedido.titulo,
               SUBSTRING(pedido.doc, 1, 20) AS doc,
               pedido.dataini,
               pedido.dataclc,
               pedido.situ,
               CASE
                   WHEN pedido.dataclc < CURDATE() THEN 'vencido'
                   WHEN pedido.dataini <= CURDATE() THEN 'aberto'
               END status
          FROM eletro_pedidos AS pedido, 
               eletro_projetos AS projeto
         WHERE pedido.situ IN('a', 'e')
               AND projeto.situ <> 'f' # nao listar pedidos de projeto FECHADO
               AND projeto.cod = pedido.codproj
               AND (pedido.dataclc < CURDATE() OR pedido.dataini <= CURDATE())
               AND pedido.resp = 'pregis'
      ORDER BY situ, prior, dataini;

/**
** ACOMPANHAMENTO DE UM PEDIDO DE COMPONENTES PARA O PEDIDO ELETRONICO
**/
SELECT cod, situ FROM estpedidocab;

     SELECT pd.coditem,
            cb.cod codpedido,
            estq.descr,
            estq.cod,
            pd.codest,
            pd.qt,
            pd.custo,
            cb.situ
       FROM estoque estq,
            estpedidocab cb,
            estpedidoitem pd
      WHERE estq.cod = pd.codest
            AND pd.codped = cb.cod
            AND cb.ospro = 46
     ORDER BY descr;

SELECT * FROM estpedidocab WHERE ospro=46;
SELECT * FROM estpedidoitem WHERE codped= 126;
SELECT * FROM estpedidocab WHERE cod=126;


# detalhamento de um pedido
                SELECT cod,
                       titulo,
                       resp,
                       'prior',
                       codproj,
                       DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                       DATE_FORMAT(dataini, '%d/%m/%Y') dataini,
                       DATE_FORMAT(dataclc, '%d/%m/%Y') dataclc,
                       fatu,
                       doc,
                       situ
                  FROM eletro_pedidos
                 WHERE cod= 2;

/**
* teste e acompanhamentos
*/
       SELECT cod,
                        titulo,
                        resp,
                        prioridade,
                        codproj,
                        DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                        dataini,
                        dataclc,
                        fatu,
                        doc,
                        situacao
                   FROM eletro_pedidos
                  WHERE cod=3;

             SELECT cod,
                    (SELECT nome
                       FROM eletro_projetos
                     WHERE cod = ped.codproj) nome_proj,
                    ped.codproj projeto,
                    (SELECT cod FROM estpedidocab WHERE ospro = ped.cod AND tipo= 'consumo' AND situ NOT IN ('cancelado')) pedconsumo,
                    dataini,
                    (SELECT DATE_FORMAT(SEC_TO_TIME(SUM(SEC_TO_TIME(TIMEDIFF(horafim, horaini)))), '%H:%i') FROM eletro_tarefas WHERE codped= ped.cod) AS tothora,
                    prioridade,
                    titulo,
                    situacao
               FROM eletro_pedidos ped
              WHERE situacao != 'temporario'
               AND codproj= 1 
             ORDER BY situacao, prioridade, dataini;
# duracao por tarefa
SELECT cod, dataexc, horaini, horafim, TIMEDIFF(horafim, horaini) AS dura FROM eletro_tarefas WHERE codped = 33;
SELECT DATE_FORMAT(SEC_TO_TIME(SUM(SEC_TO_TIME(TIMEDIFF(horafim, horaini)))), '%H:%i') AS tothora FROM eletro_tarefas WHERE codped = 33;

         SELECT cod,
                (SELECT nome
                   FROM eletro_projetos
                 WHERE cod = ped.codproj) nome_proj,
                ped.codproj projeto,
                (SELECT cod FROM estpedidocab WHERE ospro = ped.cod AND tipo= 'consumo' AND situ NOT IN ('cancelado')) pedconsumo,
                dataini,
                prioridade,
                titulo,
                situacao
           FROM eletro_pedidos ped
          WHERE situacao != 'temporario'
          AND cod= '33'
         ORDER BY situacao, prioridade, dataini;

        SELECT cod, situ FROM estpedidocab WHERE ospro = 33 AND tipo= 'consumo' AND situ NOT IN ('cancelado');



     SELECT cod,
            titulo,
            resp,
            prioridade prior,
            codproj,
            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
            dataini,
            dataclc,
            fatu,
            doc,
            situacao
       FROM eletro_pedidos
      WHERE codproj= 4;

         SELECT cod,
                (SELECT nome
                   FROM eletro_projetos
                  WHERE cod = ped.codproj) nome_proj,
                ped.codproj projeto,
                (SELECT cod FROM estpedidocab WHERE ospro = ped.cod AND tipo= 'consumo' AND situ NOT IN ('cancelado')) pedconsumo,
                (SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))), '%H:%i') FROM eletro_tarefas WHERE codped= ped.cod AND situacao != 'x') AS tothora,
                DATE_FORMAT(dataini, '%d/%m/%Y') dataini,
                CASE
                    WHEN prioridade= 'a' THEN 'Urgente'
                    WHEN prioridade= 'b' THEN 'Alta'
                    WHEN prioridade= 'c' THEN 'M&eacute;dia'
                    WHEN prioridade= 'd' THEN 'Baixa'
                END prioridade,
                titulo,
                CASE
                    WHEN situacao = 't' THEN 'em estudos'
                    WHEN situacao = 'e' THEN 'em espera'
                    WHEN situacao = 'a' THEN 'em andamento'
                    WHEN situacao = 'c' THEN 'concluido'
                    WHEN situacao = 'x' THEN 'cancelado'
                END situacao
           FROM eletro_pedidos ped
          WHERE codproj= 9
            AND resp = 'pregis'  
       ORDER BY situacao, prioridade, dataini;