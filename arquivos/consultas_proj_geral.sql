(SELECT pd.cod,
       pd.codproj,
       'eletro' tipoProj,
       pj.nome,
       pd.titulo,
       pd.resp,
       pd.dataini,
       date_format(pd.dataini, '%d/%m/%Y') AS dataAgendada,
       date_format(pd.dataclc, '%d/%m/%Y') AS dataAgendada,
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
       AND pd.situ = 'a')
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

SELECT * FROM getar_tarefas WHERE cod IN(700, 701, 702, 703, 704, 705);
SELECT * FROM getar_tarefas ORDER BY cod ASC;
SELECT * FROM getar_pedidos WHERE cod = 183;
SELECT * FROM eletro_tarefas WHERE cod = 13;
