/***
** limpeza dos temporarios em todos os projetos
*/
DELETE FROM getar_projetos WHERE 'situacao' = 'temporario';
DELETE FROM getar_pedidos WHERE 'situacao' = 'temporario';
DELETE FROM getar_tarefas WHERE 'situacao' = 'temporario';
DELETE FROM eletro_projetos WHERE 'situacao' = 'temporario';
DELETE FROM getar_opera WHERE 'situacao' = 'temporario';
DELETE FROM eletro_pedidos WHERE 'situacao' = 'temporario';
DELETE FROM eletro_tarefas WHERE 'situacao' = 'temporario';
DELETE FROM getar_lembre WHERE 'situ' = 'temporario';
DELETE FROM getar_artgch WHERE 'situacao' = 'temporario';
DELETE FROM estoque WHERE 'situacao' = 'temporario';
DELETE FROM equipo WHERE 'situ' = 'temporario';
DELETE FROM ordem WHERE 'situ' = 'temporario';
DELETE FROM conta_carne WHERE 'obs' = 'temporario';
DELETE FROM getar_contacor WHERE 'situacao' = 'temporario';
DELETE FROM estobs WHERE 'texto' = '.';

TRUNCATE TABLE getar_reglog;

SELECT * FROM getar_reglog;

SELECT * FROM getar_lembre LIMIT 3;
SELECT * FROM getar_mens LIMIT 3;

SELECT * FROM estpedidoitem WHERE codest = 1911;

# para pegar os 'temporio'
        SELECT est.cod,
               est.descr,
               est.situacao
          FROM estoque est
         WHERE situacao = 'ativo';
SELECT cod, descr, situacao FROM estoque LIMIT 5;
SELECT COUNT(*) FROM estoque WHERE situacao = 'normal';
UPDATE estoque SET situacao = 'normal' WHERE situacao = 'ativo';

        SELECT est.cod,
               est.descr,
               est.situacao,
               obs.cod codobs,
               obs.texto
          FROM estoque est,
               estobs obs
         WHERE est.cod = obs.codestq
               AND est.situacao='temporario';

/**
** a tabela de Atividades operacionais estava fora desta limpeza
**/
SELECT * FROM getar_opera WHERE situacao = 'temporario';

/**
** Em 7/02/2019 optei por eliminar registros da tabela getar_tarefas mais antigos, permanecando somente os de 2018
** ate o momento havia registros apartir de 2008
**/
SELECT * FROM getar_tarefas WHERE DATE_FORMAT('data', '%Y') ='2009';
SELECT * FROM getar_tarefas WHERE DATE_FORMAT('data', '%Y') IN('2008', '2009', '2010', '2011', '2012', '2013');
SELECT COUNT(*) FROM getar_tarefas WHERE DATE_FORMAT('data', '%Y') IN('2008', '2009', '2010', '2011', '2012', '2013');
SELECT COUNT(*) FROM getar_tarefas WHERE DATE_FORMAT('data', '%Y') ='2017';

DELETE FROM getar_tarefas WHERE DATE_FORMAT('data', '%Y') IN('2008', '2009', '2010', '2011', '2012', '2013');
DELETE FROM getar_tarefas WHERE DATE_FORMAT('data', '%Y') IN('2014', '2015', '2016', '2017');

/**
** eliminando registros de placa de maquina de lavar roupas
**/
SELECT * FROM equipo WHERE marca = 'Electrolux';# são 113 registros
SELECT CONCAT(cod, ', ') FROM equipo WHERE marca = 'Electrolux';# são 113 registros
DELETE FROM equipo WHERE cod IN(7, 
8, 
9, 
...
180, 
183);

# pesquisando quais tem OSs
        SELECT eqp.cod codeqp,
               eqp.marca,
               eqp.modelo,
               ord.cod codos
          FROM equipo eqp,
               ordem ord
         WHERE ord.codeqp = eqp.cod
               AND eqp.marca = 'Electrolux'; # são 114 registros
# pegando os códigos para o DELETE
        SELECT CONCAT(ord.cod, ', ') codos
          FROM equipo eqp,
               ordem ord
         WHERE ord.codeqp = eqp.cod
               AND eqp.marca = 'Electrolux';
DELETE FROM ordem WHERE cod IN(7, 
9, 
10, 
... 
192, 
193, 
198);

# pesquisando as tarefas das quais tem OSs
        SELECT eqp.cod codeqp,
               eqp.marca,
               eqp.modelo,
               ord.cod codos,
               tarf.cod codtarf
          FROM equipo eqp,
               ordem ord,
               ordem_tarf tarf
         WHERE ord.codeqp = eqp.cod
               AND ord.cod = tarf.codos
               AND eqp.marca = 'Electrolux'; # são 124 registros
# pegando códigas das tarefas para o SQL
# CONCAT(codobs, ', ')
        SELECT CONCAT(tarf.cod, ', ') codtarf
          FROM equipo eqp,
               ordem ord,
               ordem_tarf tarf
         WHERE ord.codeqp = eqp.cod
               AND ord.cod = tarf.codos
               AND eqp.marca = 'Electrolux';
DELETE FROM ordem_tarf WHERE cod IN(13, 
14, 
...
265, 
266);

# pesquisando as observações das quais tem OSs
        SELECT eqp.cod codeqp,
               eqp.marca,
               eqp.modelo,
               ord.cod codos,
               obs.codobs
          FROM equipo eqp,
               ordem ord,
               ordem_obs obs
         WHERE ord.codeqp = eqp.cod
               AND ord.cod = obs.codord
               AND eqp.marca = 'Electrolux'; # são 55 registros
DELETE FROM ordem_obs WHERE codobs IN(SELECT obs.codobs
                                        FROM equipo eqp,
                                             ordem ord,
                                             ordem_obs obs
                                       WHERE ord.codeqp = eqp.cod
                                             AND ord.cod = obs.codord
                                             AND eqp.marca = 'Electrolux');# erro 
# criando tabele temporaria para

INSERT INTO codobstemp (cod) VALUES (SELECT obs.codobs
                                        FROM equipo eqp,
                                             ordem ord,
                                             ordem_obs obs
                                       WHERE ord.codeqp = eqp.cod
                                             AND ord.cod = obs.codord
                                             AND eqp.marca = 'Electrolux');
CREATE VIEW codobstemp AS 
                    SELECT obs.codobs
                     FROM equipo eqp,
                          ordem ord,
                          ordem_obs obs
                    WHERE ord.codeqp = eqp.cod
                          AND ord.cod = obs.codord
                          AND eqp.marca = 'Electrolux';
SELECT * FROM codobstemp;
DELETE FROM ordem_obs WHERE codobs IN(SELECT * FROM codobstemp);# Código do erro 1443, estado do SQL HY000: The definition of table 'codobstemp' prevents operation DELETE on table 'ordem_obs'.
SELECT CONCAT(codobs, ', ') FROM codobstemp;# depois foi almente de 20 para 53 linhas, selecionar tudo e colar abaixo
DELETE FROM ordem_obs WHERE codobs IN(
5, 
4, 
9, 
11, 
13, 
14, 
15, 
22, 
23, 
24, 
25, 
38, 
27, 
26, 
29, 
30, 
31, 
32, 
33, 
34, 
35, 
37, 
45, 
104, 
66, 
82, 
83, 
85, 
86, 
88, 
89, 
91, 
92, 
97, 
94, 
98, 
99, 
103, 
101, 
102, 
105, 
106, 
107, 
110, 
108, 
109, 
111, 
112, 
116, 
126, 
125, 
128);


# pesquisando pedidos de venda para as OSs de placas de maquina de lavar roupa
        SELECT eqp.cod codeqp,
               eqp.marca,
               eqp.modelo,
               ord.cod codos,
               cab.cod
          FROM equipo eqp,
               ordem ord,
               estpedidocab cab
         WHERE ord.codeqp = eqp.cod
               AND ord.cod = cab.ospro
               AND eqp.marca = 'Electrolux'; # 21 registros

/**
codeqp	marca	modelo	codos	cod
28	Electrolux	LTC15W	27	31
42	Electrolux	LTD06	44	104
43	Electrolux	LTE06	45	110
44	Electrolux	LTE07	46	125
44	Electrolux	LTE07	46	126
46	Electrolux	LTE06	48	152
47	Electrolux	LTE06	49	154
53	Electrolux	LTE12	55	200
55	Electrolux	LT60	57	221
57	Electrolux	LT60	59	276
58	Electrolux	LT60	60	280
84	Electrolux	LBU15	93	21
85	Electrolux	LT15F	95	22
99	Electrolux	LTE08	105	23
144	Electrolux	LP12Q	149	32
154	Electrolux	LT15F	159	33
158	Electrolux	LTC15W	163	34
167	Electrolux	LTE12	176	40
169	Electrolux	LBU15B	179	41
180	Electrolux	MEG41	193	44
*/

# delete do itens dos pedidos das OSs 
DELETE FROM estpedidoitem WHERE codped IN(31, 104, 110, 125, 126, 152, 154, 200, 221, 276, 280, 21, 22, 23, 32, 33, 34, 40, 41, 44);
DELETE FROM estpedidocab WHERE cod IN(31, 104, 110, 125, 126, 152, 154, 200, 221, 276, 280, 21, 22, 23, 32, 33, 34, 40, 41, 44);

/**
** Estatisticas do banco GETARTESTE pelo PHPMyAdmin EM 07/07/2024
** 34.268 registros
** 8.4MB
**/

# Exemplo a ser trabalhado: Equipamento 148, ordem 153
# Placa de Potencia-Maq. Lavar - Electrolux - LT15F - SAB Telecom 
SELECT * FROM ordem_tarf WHERE codos =153;# 0
SELECT * FROM ordem_obs WHERE codord =153;# 0
SELECT cod, codforn, tipo FROM estpedidocab WHERE ospro = 153;# 0
DELETE FROM ordem WHERE cod = 153;

# OS008
SELECT COUNT(*) numtarf FROM ordem_tarf WHERE codos =8; # 0 tarefas, provevelmente já foram limpas 
SELECT COUNT(8) numobs FROM ordem_obs WHERE codord = 8; # 1 Obs
DELETE FROM ordem_obs WHERE codord = 8;
SELECT * FROM ordem WHERE cod = 8;
DELETE FROM ordem WHERE cod = 8;

SELECT cod, codforn, tipo FROM estpedidocab WHERE ospro = 8;

# 143
SELECT * FROM ordem_tarf WHERE codos =143;# 1
SELECT * FROM ordem_obs WHERE codord =143;# 1
SELECT cod, codforn, tipo FROM estpedidocab WHERE ospro = 143;# 0
DELETE FROM ordem WHERE cod = 143;