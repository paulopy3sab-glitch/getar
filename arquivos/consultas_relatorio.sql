/**
** RELATORIO DE TAREFAS
**/
    SELECT  @mes := '12', @ano := '2021'; # carregamento do mes e ano
                 SELECT codtarf,
                        tipo,
                        dia,
                        CASE 
                            WHEN date_format(diaSemana, '%w') = '0' THEN 'Domingo'
                            WHEN date_format(diaSemana, '%w') = '1' THEN 'Segunda'
                            WHEN date_format(diaSemana, '%w') = '2' THEN 'Terca'
                            WHEN date_format(diaSemana, '%w') = '3' THEN 'Quarta'
                            WHEN date_format(diaSemana, '%w') = '4' THEN 'Quinta'
                            WHEN date_format(diaSemana, '%w') = '5' THEN 'Sexta'
                            WHEN date_format(diaSemana, '%w') = '6' THEN 'Sabado'
                        END AS diaSemana,
                        tempo,
                        horaini,
                        resp,
                        projeto,
                        pedido
                  FROM (
                 SELECT tar.cod codtarf,
                        'Proj' tipo,
                        date_format(tar.dataexc, '%d/%m/%Y') dia,
                        tar.dataexc AS diaSemana,
                        CASE 
                            WHEN tar.horafim = 0 THEN 'Tarefa nao finalizada'
                            WHEN tar.horafim <> 0 THEN TIMEDIFF (tar.horafim, tar.horaini)
                        END tempo,
                        tar.horaini,
                        tar.resp,
                        proj.nome projeto,
                        ped.titulo pedido
                   FROM getar_tarefas tar,
                        getar_pedidos ped,
                        getar_projetos proj
                  WHERE (DATE_FORMAT(tar.dataexc, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexc, '%Y')= @ano)
                        AND tar.situacao = 'concluido'
                        AND tar.codped = ped.cod
                        AND ped.codproj = proj.cod
             UNION(SELECT tar.cod codtarf,
                        'OS' tipo,
                        date_format(tar.dataexec, '%d/%m/%Y') dia,
                        tar.dataexec AS diaSemana,
                        TIMEDIFF (tar.horafim, tar.horaini) tempo,
                        tar.horaini,
                        tar.tecn resp,
                        CONCAT('OS ', tar.codos) projeto,
                        ' ' pedido
                   FROM ordem_tarf tar
                  WHERE (DATE_FORMAT(tar.dataexec, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexec, '%Y')= @ano)
                        AND tar.situ = 'concluida')
                    UNION(SELECT tar.cod codtarf,
                        'Oper' tipo,
                        date_format(tar.dataexc, '%d/%m/%Y') dia,
                        tar.dataexc AS diaSemana,
                        TIMEDIFF (tar.horafim, tar.horaini) tempo,
                        tar.horaini,
                        tar.resp resp,
                        opr.nome projeto,
                        ' ' pedido
                   FROM getar_opera opr,
                        getar_tarfopera tar
                  WHERE opr.cod = tar.cod
                        AND (DATE_FORMAT(tar.dataexc, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexc, '%Y')= @ano)
                        AND tar.situacao = 'concluida')) AS grp
             ORDER BY dia, horaini;
# desmenbramento da SQL
# tarefas eletronico
     SELECT tar.cod codtarf,
            date_format(tar.dataexc, '%d/%m/%Y') dia,
            tar.dataexc AS diaSemana,
            CASE 
                WHEN tar.horafim = 0 THEN 'Tarefa nao finalizada'
                WHEN tar.horafim <> 0 THEN TIMEDIFF (tar.horafim, tar.horaini)
            END tempo,
            tar.resp,
            proj.nome projeto,
            ped.titulo pedido
       FROM eletro_tarefas tar,
            eletro_pedidos ped,
            eletro_projetos proj
      WHERE (DATE_FORMAT(tar.dataexc, '%m')= '07')# muda variavel @mes
            AND (DATE_FORMAT(tar.dataexc, '%Y')='2020')# muda variavel @ano
            AND tar.situacao = 'c'
            AND tar.codped = ped.cod
            AND ped.codproj = proj.cod;

SELECT * FROM eletro_tarefas WHERE cod= 855 AND horafim = 0;
# tarefas de programacao
SELECT date_format(tar.data, '%d/%m/%Y') dia,
                        tar.data AS diaSemana,
                        TIMEDIFF (tar.horafim, tar.horaini) tempo,
                        tar.resp,
                        proj.nome projeto,
                        ped.titulo pedido
                   FROM getar_tarefas tar,
                        getar_pedidos ped,
                        getar_projetos proj
                  WHERE (DATE_FORMAT(tar.data, '%m')= '10')# muda variavel @mes
                        AND (DATE_FORMAT(tar.data, '%Y')= '2016')# muda variavel @ano
                        AND tar.status = 'c'
                        AND tar.resp= 'pregis'
                        AND tar.pedido = ped.cod
                        AND ped.projeto = proj.cod;

SELECT * FROM getar_tarefas WHERE (DATE_FORMAT(data, '%m')= '10')# muda variavel @mes
                        AND (DATE_FORMAT(data, '%Y')= '2016');
# tarefas OS
SELECT date_format(tar.dataexec, '%d/%m/%Y') dia,
                        tar.dataexec AS diaSemana,
                        TIMEDIFF (tar.horafim, tar.horaini) tempo,
                        tar.tecn resp,
                        CONCAT('OS ', tar.codos) projeto,
                        ' ' pedido
                   FROM ordem_tarf tar
                  WHERE (DATE_FORMAT(tar.dataexec, '%m')= '10')# muda variavel @mes
                        AND (DATE_FORMAT(tar.dataexec, '%Y')= '2016')# muda variavel @ano
                        AND tar.situ = 'concluida'
                        AND tar.tecn;
# tarefas operacionais
                SELECT tar.cod codtarf,
                        'Oper' tipo,
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
                        AND (DATE_FORMAT(tar.dataexc, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexc, '%Y')= @ano)
                        AND tar.situacao = 'concluida'
                        AND tar.resp='sofia2t';
# sem o nome do projeto
                SELECT tar.cod codtarf,
                        'Oper' tipo,
                        date_format(tar.dataexc, '%d/%m/%Y') dia,
                        tar.dataexc AS diaSemana,
                        TIMEDIFF (tar.horafim, tar.horaini) tempo,
                        tar.horaini,
                        tar.resp resp,
                        ' ' projeto,
                        ' ' pedido
                   FROM getar_tarfopera tar
                  WHERE (DATE_FORMAT(tar.dataexc, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexc, '%Y')= @ano)
                        AND tar.situacao = 'concluido';
/**
** PLANEJAMENTO DE PROJETOS
**/
        (SELECT pd.cod,
                pd.codproj,
                'eletro' tipoProj,
                pj.nome,
                pd.titulo,
                pd.resp,
                pd.dataini,
                date_format(pd.dataini, '%d/%m/%Y') AS dataAgendada,
                date_format(pd.dataclc, '%d/%m/%Y') AS dataFim,
                CASE 
                    WHEN date_format(pd.dataini, '%w') = '0' THEN 'Domingo'
                    WHEN date_format(pd.dataini, '%w') = '1' THEN 'Segunda'
                    WHEN date_format(pd.dataini, '%w') = '2' THEN 'Terca'
                    WHEN date_format(pd.dataini, '%w') = '3' THEN 'Quarta'
                    WHEN date_format(pd.dataini, '%w') = '4' THEN 'Quinta'
                    WHEN date_format(pd.dataini, '%w') = '5' THEN 'Sexta'
                    WHEN date_format(pd.dataini, '%w') = '6' THEN 'Sabado'
                END AS diaSemana
           FROM eletro_pedidos pd,
                eletro_projetos pj
          WHERE pj.cod = pd.codproj
                AND pd.situacao = 'a')
         UNION(
         SELECT pd.cod,
                pd.projeto,
                'proga' tipoProj,
                pj.nome,
                pd.titulo,
                pd.resp,
                pd.dataini,                     
                date_format(pd.dataini, '%d/%m/%Y') AS dataAgendada,
                date_format(pd.dataclc, '%d/%m/%Y') AS dataFim,
                CASE 
                    WHEN date_format(pd.dataini, '%w') = '0' THEN 'Domingo'
                    WHEN date_format(pd.dataini, '%w') = '1' THEN 'Segunda'
                    WHEN date_format(pd.dataini, '%w') = '2' THEN 'Terca'
                    WHEN date_format(pd.dataini, '%w') = '3' THEN 'Quarta'
                    WHEN date_format(pd.dataini, '%w') = '4' THEN 'Quinta'
                    WHEN date_format(pd.dataini, '%w') = '5' THEN 'Sexta'
                    WHEN date_format(pd.dataini, '%w') = '6' THEN 'Sabado'
                END AS diaSemana
           FROM getar_pedidos pd,
                getar_projetos pj
          WHERE pj.cod = pd.projeto
                AND pd.situacao = 'a')
         ORDER BY dataini;


/**
** AREA DE TESTE
**/
    SELECT date_format(tar.dataexec, '%d/%m/%Y') dia,
           # tar.date_format(horaini, '%k:%i') hora_ini01,
           # tar.date_format(horafim, '%k:%i') hora_fim01,
           TIMEDIFF (tar.horafim, tar.horaini) tempo,
           tar.tecn resp,
           tar.codos projeto,
           ' ' pedido
      FROM ordem_tarf tar
     WHERE (DATE_FORMAT(tar.dataexec, '%m')= @mes)
           AND (DATE_FORMAT(tar.dataexec, '%Y')= @ano)
           AND tar.situ = 'concluida';

SELECT * FROM eletro_tarefas WHERE (DATE_FORMAT(dataexc, '%m')= '11');
SELECT * FROM ordem_tarf WHERE (DATE_FORMAT(dataexec, '%m')= '10');


     SELECT dia,
            CASE 
                WHEN date_format(diaSemana, '%w') = '0' THEN 'Domingo'
                WHEN date_format(diaSemana, '%w') = '1' THEN 'Segunda'
                WHEN date_format(diaSemana, '%w') = '2' THEN 'Terca'
                WHEN date_format(diaSemana, '%w') = '3' THEN 'Quarta'
                WHEN date_format(diaSemana, '%w') = '4' THEN 'Quinta'
                WHEN date_format(diaSemana, '%w') = '5' THEN 'Sexta'
                WHEN date_format(diaSemana, '%w') = '6' THEN 'Sabado'
            END AS diaSemana,
            tempo,
            resp,
            projeto,
            pedido
      FROM (
     SELECT date_format(tar.dataexc, '%d/%m/%Y') dia,
            tar.dataexc AS diaSemana,
            TIMEDIFF (tar.horafim, tar.horaini) tempo,
            tar.resp,
            proj.nome projeto,
            ped.titulo pedido
       FROM getar_tarefas tar,
            getar_pedidos ped,
            getar_projetos proj
      WHERE # (DATE_FORMAT(tar.dataexc, '%m')= '2')
            # AND (DATE_FORMAT(tar.dataexc, '%Y')='2021')
            # AND tar.situacao = 'concluido'
            tar.situacao = 'concluido'
            AND tar.codped = ped.cod
            AND ped.codproj = proj.cod)AS grp
     ORDER BY dia;

SELECT * FROM getar_tarefas WHERE 1=1 LIMIT 5;
# cacando os relatorios de tarefas em excel
SELECT cod, doc FROM getar_tarefas WHERE doc LIKE '%relato%';
/**
** SQL em producao
**/
         SELECT cad.nome,
                ctl.nick
          FROM  getar_control ctl,
                getar_cad cad
          WHERE ctl.codcad = cad.cod
                AND cad.situacao = 'ativo';