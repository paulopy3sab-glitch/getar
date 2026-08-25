/**
** PROJETOS PROGRAMACAO
** CRIACAO E DESCRICAO DAS TABELAS ENVOLVIDAS
*/
# ALTER TABLE getar_projetos ENGINE= InnoDB;
# ALTER TABLE getar_pedidos ENGINE= InnoDB;
# ALTER TABLE getar_tarefas ENGINE= InnoDB;

# ALTER TABLE eletro_projetos ADD CONSTRAINT fk_cadproel FOREIGN KEY (`cliente`) REFERENCES getar_cad (cod);
# SQL abaixo deu erro 1215 pq o campo projeto na tabela pedido era VARCHAR
# ALTER TABLE `getar_pedidos` CHANGE `projeto` `projeto` INT NULL DEFAULT NULL;
# ALTER TABLE getar_pedidos ADD CONSTRAINT fk_codproj FOREIGN KEY (projeto) REFERENCES getar_projetos (cod);
# SELECT * FROM getar_tarefas WHERE cod IN(609, 610, 611);
# ALTER TABLE `getar_tarefas` CHANGE `pedido` `pedido` INT NULL DEFAULT NULL;
# ALTER TABLE getar_tarefas ADD CONSTRAINT fk_cdpedido FOREIGN KEY (`pedido`) REFERENCES getar_pedidos (cod);
# ALTER TABLE getar_pedidos ADD CONSTRAINT fk_rppedido FOREIGN KEY (`resp`) REFERENCES getar_control (nick);
# SELECT * FROM getar_tarefas WHERE resp = "";
# UPDATE getar_tarefas SET resp='pregis' WHERE cod IN(550, 551, 552);
# ALTER TABLE getar_tarefas ADD CONSTRAINT fk_rptarefa FOREIGN KEY (`resp`) REFERENCES getar_control (nick);

# UNIFICACAO DE TABELAS DE PROJETOS
ALTER TABLE `getar_projetos` ADD `tag` VARCHAR(20) NULL DEFAULT NULL AFTER `cod`;

SHOW CREATE TABLE getar_projetos;
CREATE TABLE `getar_projetos` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(20) NOT NULL,
  `codant` int(11) NOT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  `datareg` date DEFAULT NULL,
  `descr` text,
  `situacao` varchar(60) DEFAULT 'a',
  PRIMARY KEY (`cod`),
  KEY `fk_cadprojprog` (`cliente`),
  CONSTRAINT `fk_cadprojprog` FOREIGN KEY (`cliente`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

SHOW CREATE TABLE getar_pedidos;
CREATE TABLE `getar_pedidos` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=640 DEFAULT CHARSET=latin1

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
) ENGINE=InnoDB AUTO_INCREMENT=4776 DEFAULT CHARSET=latin1;

SELECT * FROM getar_projetos ORDER BY cod DESC LIMIT 10;
SELECT * FROM getar_projetos WHERE cod =98;

INSERT INTO getar_pedidos (resp, situacao, projeto, datareg)
                         VALUES ('pregis', 'temporario', '58', CURDATE());
SELECT * FROM getar_pedidos ORDER BY cod DESC;
SELECT * FROM getar_pedidos WHERE cod=637;

SELECT cod, resp, situacao, doc FROM getar_pedidos ORDER BY cod DESC;
SELECT nome FROM getar_projetos WHERE cod =1;

# resgatando projeto do OCXO
SELECT * FROM eletro_projetos WHERE cod= 20;# OCXO
SELECT * FROM eletro_pedidos WHERE codproj= 20;# OCXO
SELECT * FROM eletro_pedidos WHERE cod= 67;

/**
** ACERTOS DE TIMEZONE
**/
SET timezone= '-3:00';
INSERT INTO getar_tarefas (status, resp, pedido, data, horaini, fatura, doc)
                         VALUES ('a', 'pregis', 258, CURDATE(), CURTIME(), '1', 'Descricao inicial da Tarefa: 
 
Arquivos envolvidos: 
 
Documentacao em anexo:');
SELECT * FROM getar_tarefas WHERE DATE_FORMAT(`data`, '%d/%m/%Y') = '02/03/2017';
SELECT * FROM mysql.time_zone_name WHERE Name LIKE '%Brazil%';

/*
Listagem dos pedido
*/
        SELECT ped.cod,
               ped.titulo titulo,
               date_format(ped.dataini, '%d/%m/%Y'),
               CASE
                   WHEN `prior` = 'a' THEN 'Urgente'
                   WHEN `prior` = 'b' THEN 'Alta'
                   WHEN `prior` = 'c' THEN 'M&eacute;dia'
                   WHEN `prior` = 'd' THEN 'Baixa'
               END prioridade,
               ped.doc,
               CASE 
                   WHEN ped.situacao = 'e' THEN 'Espera'
                   WHEN ped.situacao = 't' THEN 'Estudos'
                   WHEN ped.situacao = 'a' THEN 'Andamento'
                   WHEN ped.situacao = 'c' THEN 'Conclu&iacute;do'
                   WHEN ped.situacao = 'f' THEN 'Fechado'
                   WHEN ped.situacao = 'n' THEN 'Negocia&ccedil;&atilde;o'
                   WHEN ped.situacao = 'x' THEN 'Cancelado'
               END as situacao,
               pj.situacao situproj
          FROM getar_pedidos ped,
               getar_projetos pj
         WHERE ped.projeto = pj.cod
               AND ped.projeto= 1
               AND ped.situacao NOT IN('x', 'c')
        ORDER BY situacao, prioridade, dataini;

/*
Detalhamento de um pedido
*/
    SELECT date_format(data, '%d/%m/%Y') dia,
           date_format(horaini, '%k:%i') hora_ini,
           date_format(horafim, '%k:%i') hora_fim,
           doc,
           resp,
           pedido,
           CASE
               WHEN fatura THEN 'sim'
               ELSE 'nao'
           END fatu,
           CASE 
                WHEN status = 'c' THEN 'concluido'
                WHEN status = 't' THEN 'andamento'
                WHEN status = 'a' THEN 'andamento'
           END as st
      FROM getar_tarefas
     WHERE cod= 610;

SELECT projetos.nome AS nome,
                        projetos.cod AS cod,
                        tarefas.pedido AS codPedido
                   FROM getar_pedidos AS pedidos,
                        getar_projetos AS projetos,
                       getar_tarefas AS tarefas
                  WHERE
                        projetos.cod= pedidos.projeto
                        AND pedidos.cod= tarefas.pedido
                        AND tarefas.cod= 610;

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

/**
** Consulta pedidos abertos e vencidos
**/
        SELECT pedido.cod,
               projeto.nome,
               projeto.cod codproj,
               DATE_FORMAT(pedido.dataini, '%d/%m/%Y') dataini,
               pedido.prior,
               pedido.titulo,
               SUBSTRING(pedido.doc, 1, 20) AS doc,
               pedido.situacao,
               CASE
                   WHEN pedido.dataclc < CURDATE() THEN 'vencido'
                   WHEN pedido.dataini <= CURDATE() THEN 'aberto'
               END status
          FROM getar_pedidos  AS pedido,
               getar_projetos AS projeto
         WHERE pedido.situacao NOT IN( 'c', 't', 'x', 'e')
               AND projeto.situacao != 'f'
               AND projeto.cod = pedido.projeto
               AND (pedido.dataclc < CURDATE() OR pedido.dataini <= CURDATE())
               AND pedido.resp = 'pregis'
      ORDER BY situacao, prior, dataini;

        SELECT cod,
               titulo,
               resp,
               'prior',
               projeto,
               DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
               DATE_FORMAT(dataini, '%d/%m/%Y') dataini,
               DATE_FORMAT(dataini, '%d/%m/%Y') dataini,
               fatura,
               doc,
               situacao
          FROM getar_pedidos
         WHERE cod= 175;

/**
*
*/
SELECT * FROM getar_tarefas ORDER BY cod DESC;
SELECT * FROM getar_tarefas WHERE cod IN(4582, 4583, 4585);
SELECT * FROM getar_tarefas WHERE cod =5025;
SELECT * FROM getar_tarefas WHERE status= 'temporario';
SELECT * FROM getar_projetos ORDER BY cod DESC;
SELECT * FROM getar_projetos WHERE cod=96;
SELECT * FROM getar_tarefas WHERE pedido = 285 ORDER BY cod DESC;
SELECT * FROM getar_pedidos WHERE codproj = 128;
SELECT * FROM getar_pedidos WHERE cod = 878;


         SELECT cod,
                resp,
                doc,
                date_format(data, '%d/%m/%Y') dia,
                date_format(horaini, '%k:%i') hora_ini,
                date_format(horafim, '%k:%i') hora_fim,
                date_format(SUBTIME(horafim, horaini), '%k:%i') tempotrab,
                status
           FROM getar_tarefas
          WHERE status != 'temporario'
                AND resp= 'pregis'
                AND pedido = '205'
                AND resp= 'pregis'
       ORDER BY cod DESC;

        SELECT (@t1 := SUM((TIME_TO_SEC(horafim) - TIME_TO_SEC(horaini)))) tempo,
               (@t2 := TRUNCATE(@t1/ 3600, 0)) horas,
               TRUNCATE(((@t1/ 3600) - @t2)* 60, 0) minutos
          FROM getar_tarefas
         WHERE status != 'temporario'
               AND pedido = '205'
               AND resp= 'pregis';

 SELECT date_format(data, '%d/%m/%Y') dia,
                        date_format(horaini, '%k:%i') hora_ini,
                        date_format(horafim, '%k:%i') hora_fim,
                        doc,
                        resp,
                        pedido,
                        CASE
                            WHEN fatura THEN 'sim'
                            ELSE 'nao'
                        END fatu,
                        (SELECT doc FROM getar_pedidos WHERE cod = pedido) doc_pedido,
                        status as situ
                   FROM getar_tarefas
                  WHERE cod= 1065;

# ******************************************************************************
         SELECT ped.cod,
                ped.titulo titulo,
                pj.cod projeto,
                date_format(ped.dataini, '%d/%m/%Y') dataini,
                (SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))), '%H:%i') FROM getar_tarefas trf WHERE pedido= ped.cod AND trf.status != 'x') AS tothora,
                CASE
                    WHEN `prior` = 'a' THEN 'Urgente'
                    WHEN `prior` = 'b' THEN 'Alta'
                    WHEN `prior` = 'c' THEN 'M&eacute;dia'
                    WHEN `prior` = 'd' THEN 'Baixa'
                END prioridade,
                ped.doc,
                CASE 
                    WHEN ped.situacao = 'e' THEN 'Espera'
                    WHEN ped.situacao = 't' THEN 'Estudos'
                    WHEN ped.situacao = 'a' THEN 'Andamento'
                    WHEN ped.situacao = 'c' THEN 'Conclu&iacute;do'
                    WHEN ped.situacao = 'f' THEN 'Fechado'
                    WHEN ped.situacao = 'n' THEN 'Negocia&ccedil;&atilde;o'
                    WHEN ped.situacao = 'x' THEN 'Cancelado'
                END as situacao,
                pj.situacao situproj
           FROM getar_pedidos ped,
                getar_projetos pj
          WHERE ped.projeto = pj.cod
                AND  ped.resp = 'pregis'
                AND ped.situacao NOT IN('c', 'x')
       ORDER BY situacao, prioridade, dataini;

/**
** Unificacao de tabelas
**/
SELECT cod, tag, codant FROM getar_projetos WHERE cod= 67;
SELECT cod, tag, codant, situacao FROM getar_projetos WHERE situacao= 'a';
SELECT * FROM eletro_pedidos WHERE codproj= 3;# projeto 3- Novicio, codigo atual 90
SELECT * FROM getar_pedidos WHERE codproj= 67;


SELECT * FROM getar_pedidos WHERE doc LIKE '%osci%';
SELECT * FROM getar_pedidos WHERE titulo LIKE '%osci%';
SELECT * FROM eletro_pedidos WHERE doc LIKE '%ML 125%';

# tarefas
SELECT * FROM eletro_tarefas WHERE codped = 66;
SELECT * FROM getar_tarefas WHERE codped =;

# importacoes
INSERT INTO `getar_projetos` (`tag`, `codant`, `nome`, `cliente`, `datareg`, `descr`, `situacao`) VALUES
('PE004', 4, 'Equipamentos de Shack e Instrumentação', 273, '2014-07-11', 'Pequenos equipamentos e ferramentas para uso no shack da estação e complemento de laboratório.', 'a');

INSERT INTO getar_pedidos (codproj, resp, titulo, prior, datareg, dataini, dataclc, fatu, doc, situacao)
     VALUES (98, 'pregis', 'Manutenção Laboratório', 'c', '2020-11-11', '2021-01-01', '2021-06-30', '0', '*********************************************************************
** Aqui todas as atividade pertinentes a manutenção do laboratório **
*********************************************************************', 'a');


INSERT INTO getarsab.getar_tarefas (codped, resp, dataexc, horaini, horafim, doc, situacao) 
	VALUES (296, 'pregis', '2020-08-05', '18:17:00', '18:58:00', 'Remarcação das escalas do knobs do plugin RF Section
 
Documentacao em anexo:', 'c');


INSERT INTO `getar_pedidos` (`cod`, `titulo`, `resp`, `situacao`, `prior`, `codproj`, `datareg`, `dataini`, `dataclc`, `fatu`, `doc`)
 VALUES (324, 'Placas Banco Alta tensão', 'pregis', 'espera', 'media', '86', '2021-08-09', '2021-08-09', '2021-08-09', '0',
 'Projeto e fabricação de placas para os bancos de alta tensão de rádio e lineares válvulados. Como o FT-101x, FT-901DM, TS-830, TS-520 e lineares como o FL=2200 e o TL-922');
# tarefas



# projetos eletronicos
INSERT INTO `eletro_projetos` (`cod`, `tag`, `nome`, `datareg`, `cliente`, `descr`, `situacao`) VALUES
(1, '', 'Frequencimetro PY3SAB', '2014-07-11', 273, 'Frequencímetro para uso em rádio comunicação\r\no e montagens. Projeto cadastrado apenas para efeito de registro', 'a'),
(2, '', 'Serelpe QRP', '2014-07-11', 273, 'Montagem do QRP Serelepe aproveitando as placas que um amigo radioamador me deu.', 'f'),
(3, '', 'Novicio QRP 80m', '2014-07-11', 273, 'Montagem e teste do QRP Novicio SSB', 'a'),
(4, '', 'Equipamentos de Shack e Instrumentação', '2014-07-11', 273, 'Pequenos equipamentos e ferramentas para uso no shack da estação e complemento de laboratório.', 'a'),
(5, '', 'Equipamentos Testes Maquina Lavar', '2014-12-02', 273, 'Estudos e confecção de kits, placas e técnicas para teste em placa de potencia e interface para máquinas de lavar roupa e microondas', 'f'),
(6, '', 'Linear VHF 2m', '2014-12-17', 273, 'Linear para poder transmitir com o HT FT23R com saída queimada.\r\nUsar os transistores que tenho em estoque ou posso adquirir com facilidade. Não importa se pouca potencia.\r\nEsperar a chega de novos 2N3866 para lançar um pedido novo passando a limpo a placa do PA e confeccionando nova do Relé sem o filtro de saída PI e com transistor(s) para autocomutação.\r\n\r\nAcompanhar artigo: http://localhost/getar02/index.php?st=artigos&pag=edit&codartg=107', 'f'),
(7, '', 'Fonte PY3SAB 20A-13.8V', '2015-01-10', 273, 'Fonte de 20A para a estação PY3SAB.\r\nUma alternativa é aproveitar o transformador de micro-ondas já bobinado\r\nRemontar com mais capricho a fonte linear de 2A já confeccionada, ela e boa ainda para acionar a recepção do PX e o FT23R.\r\nEstudar uma modificação na fonte chaveada de computador, colocando os filtros necessários e estudar pelo datasheet do controlador principal a possibilidade de fixar ela em 13,8V', 'a'),
(9, '', 'Acoplador Antenas', '2015-04-10', 273, 'Acoplador e chaveador com relés e chaves sucatas de placas de máquina lavar roupa e micro-ondas.\r\nVer artigo:\r\nhttp://getarschw.schw.com.br/index.php?st=artigos&pag=leitura&codartg=119', 'e'),
(10, '', 'Off Topic - Montagem 125Moto ML', '2015-04-13', 273, 'Montagem da minha moto 125ML que esta em Teutonia.\r\nApenas para registrar os estudos e o pedido de peças.', 'x'),
(11, '', 'Estudos Eletrônicos', '2015-07-01', 841, 'Pequenos projetos didáticos', 'f'),
(12, '', 'Duplo Voz Link Zello', '2016-03-05', 273, 'Duplo vox, placa de comando para link Zello a ser implantado em Teutônia', 'a'),
(13, '', 'Alteração de Frequencia Cristais', '2017-02-28', 2, 'Estudos de como alterar frequencia de cristais pizoeltricos.', 'f'),
(14, '', 'Placas e Modulos', '2017-12-10', 2, 'placas para atualização de rádios e equipamentos', 'a'),
(15, '', 'Gerador de RF', '2018-02-04', 2, 'Para uso no laboratório', 'a'),
(16, '', 'Fontes de Bancada', '2018-08-17', 2, 'Fonte simétrica variável para teste de amplificadores, fonte chaveada para 50A, ', 'a'),
(17, '', 'Carga Eletronica', '2020-05-02', 2, 'Um projeto que seja simples para testar fontes lineares e chaveadas.\r\nAs medidas de corrente e tensão podem ser feitas por multimetros ou um amperimetro de kit', 'a'),
(18, '', 'Spectrum Analyzer HP', '2020-07-29', 2, 'Revisão do conjunto HP 8555A, 8554B, 8552A', 'a'),
(19, '', 'SDR No PC', '2020-07-31', 2, 'Instalar e configuras o SDR emprestado do Fabio no Smirna', 'f'),
(20, '', 'Oscilador de Referencia OCXO', '2020-08-09', 2, 'Montar e colocar em funcioanamente sincronizando frequencímetro TR-5143C e Gerador LG 3236', 'f'),
(21, '', 'Modulo M51943', '2020-09-19', 2, 'Módulo para substituir o M51943 nos radios FT-990', 'a');

# Teste nos SQL em uso
         SELECT proj.nome AS nomeproj,
                proj.cod AS codproj,
                ped.titulo
           FROM getar_pedidos AS ped,
                getar_projetos_nv AS proj
          WHERE proj.codant= ped.codproj
                AND proj.tag = 'PE001'
                AND ped.cod= 291;

SELECT * FROM estpedidocab WHERE cod IN(148,322);
SELECT * FROM estpedidocab WHERE cod = 46;
SELECT cod FROM estpedidocab WHERE ospro = 297 AND tipo='consumo';

         SELECT cb.cod codpedido,
                (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM getar_projetos pj, getar_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro AND cb.tipo='consumo') projeto,
                (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                estq.descr,
                estq.cod,
                pd.codest,
                pd.qt,
                (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                pd.custo,
                cb.situ,
                cb.tipo,
                pd.situ situitem
           FROM estoque estq,
                estpedidocab cb,
                estpedidoitem pd
          WHERE estq.cod = pd.codest
                AND pd.codped = cb.cod
                AND cb.tipo = 'consumo'
                AND cb.cod = 322
         ORDER BY codpedido, descr;

# padrao discritivo
         SELECT ped.cod,
                ped.titulo titulo,
                proj.cod codproj,
                date_format(ped.dataini, '%d/%m/%Y') dataini,
                (SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))), '%H:%i') FROM getar_tarefas trf WHERE codped= ped.cod AND trf.situacao != 'x') AS tothora,
                CASE
                    WHEN `prior` = 'urgente' THEN 'Urgente'
                    WHEN `prior` = 'alta' THEN 'Alta'
                    WHEN `prior` = 'media' THEN 'Média'
                    WHEN `prior` = 'baixa' THEN 'Baixa'
                END prioridade,
                ped.doc,
                CASE 
                    WHEN ped.situacao = 'espera' THEN 'Espera'
                    WHEN ped.situacao = 'estudos' THEN 'Estudos'
                    WHEN ped.situacao = 'andamento' THEN 'Andamento'
                    WHEN ped.situacao = 'concluido' THEN 'Concluído'
                    WHEN ped.situacao = 'fechado' THEN 'Fechado'
                    WHEN ped.situacao = 'negociacao' THEN 'Negociação'
                    WHEN ped.situacao = 'cancelado' THEN 'Cancelado'
                END as situacao,
                proj.situacao situproj
           FROM getar_pedidos ped,
                getar_projetos proj
          WHERE ped.codproj = proj.cod
                # AND ped.situacao NOT IN('temporario', 'x', 'c')
                # AND proj.tag = 'PP064'
                # AND proj.cod =64
       ORDER BY situacao, prioridade, dataini;
# pedidos
UPDATE getar_pedidos SET situacao= 'espera' WHERE situacao = 'e';
UPDATE getar_pedidos SET situacao= 'estudo' WHERE situacao = 't';
UPDATE getar_pedidos SET situacao= 'andamento' WHERE situacao = 'a';
UPDATE getar_pedidos SET situacao= 'concluido' WHERE situacao = 'c';
UPDATE getar_pedidos SET situacao= 'fechado' WHERE situacao = 'f';
UPDATE getar_pedidos SET situacao= 'negociacao' WHERE situacao = 'n';
UPDATE getar_pedidos SET situacao= 'cancelado' WHERE situacao = 'x';

ALTER TABLE `getar_pedidos` CHANGE `prior` `prior` CHAR(20) DEFAULT 'baixa';

UPDATE getar_pedidos SET prior= 'urgente' WHERE prior = 'a';
UPDATE getar_pedidos SET prior= 'alta' WHERE prior = 'b';
UPDATE getar_pedidos SET prior= 'media' WHERE prior = 'c';
UPDATE getar_pedidos SET prior= 'baixa' WHERE prior = 'd';

# Projetos
UPDATE getar_projetos SET situacao= 'espera' WHERE situacao = 'e';
UPDATE getar_projetos SET situacao= 'estudo' WHERE situacao = 's';
UPDATE getar_projetos SET situacao= 'andamento' WHERE situacao = 'a';
UPDATE getar_projetos SET situacao= 'fechado' WHERE situacao = 'f';
UPDATE getar_projetos SET situacao= 'negociacao' WHERE situacao = 'n';
UPDATE getar_projetos SET situacao= 'cancelado' WHERE situacao = 'x';

# Tarefas
SELECT * FROM getar_tarefas;
UPDATE getar_tarefas SET situacao= 'andamento' WHERE situacao= 'a';
UPDATE getar_tarefas SET situacao= 'concluido' WHERE situacao= 'c';
UPDATE getar_tarefas SET situacao= 'cancelada' WHERE situacao= 'x';


        SELECT  tar.cod AS cod,
                proj.nome AS proj,
                ped.titulo AS ped,
                'andamento' AS situ
          FROM getar_tarefas tar,
               getar_pedidos ped,
               getar_projetos proj
         WHERE tar.codped = ped.cod
               AND ped.codproj = proj.cod
               AND tar.situacao = 'a'
               AND tar.resp  = 'pregis';

/**
** Relatorio de tarefas
** Arquivo relato_tarefas.php
**/
     SELECT codtarf,
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
      WHERE (DATE_FORMAT(tar.dataexc, '%m')= '09')
            AND (DATE_FORMAT(tar.dataexc, '%Y')= '2021')
            AND tar.situacao = 'concluido'
            AND tar.codped = ped.cod
            AND ped.codproj = proj.cod
 UNION(SELECT tar.cod codtarf,
            date_format(tar.dataexec, '%d/%m/%Y') dia,
            tar.dataexec AS diaSemana,
            TIMEDIFF (tar.horafim, tar.horaini) tempo,
            tar.horaini,
            tar.tecn resp,
            CONCAT('OS ', tar.codos) projeto,
            ' ' pedido
       FROM ordem_tarf tar
      WHERE (DATE_FORMAT(tar.dataexec, '%m')= '09')
            AND (DATE_FORMAT(tar.dataexec, '%Y')= '2021')
            AND tar.situ = 'concluida')) AS grp
 ORDER BY dia, horaini;

/**
** Listage de tarefas operacionais nas boas vindas
**/

     SELECT pedido.cod,
            projeto.tag,
            projeto.nome,
            projeto.cod codproj,
            DATE_FORMAT(pedido.dataini, '%d/%m/%Y') dataini,
            CASE
                WHEN pedido.prior = 'urgente' THEN 'Urgente'
                WHEN pedido.prior = 'alta' THEN 'Alta'
                WHEN `prior` = 'media' THEN 'M&eacute;dia'
                WHEN `prior` = 'baixa' THEN 'Baixa'
            END prioridade,
            pedido.titulo,
            pedido.situacao
       FROM getar_pedidos  AS pedido,
            getar_projetos AS projeto
      WHERE pedido.situacao NOT IN( 'concluido', 'estudo', 'cancelado', 'espera')
            AND projeto.situacao != 'fechado'
            AND projeto.cod = pedido.codproj
            AND (pedido.dataclc < CURDATE() OR pedido.dataini <= CURDATE())
            AND projeto.cod IN(64, 86)# compativel versao antiga
            # 64= Administrativo 86= Equipamento de Shack
            AND pedido.resp = 'pregis'
   ORDER BY situacao, prior, dataini;

SELECT tag FROM getar_projetos prj, getar_pedidos ped WHERE prj.cod= ped.codproj AND ped.cod=288;

         SELECT cod,
                titulo,
                resp,
                prior,
                codproj,
                DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                dataini,
                dataclc,
                fatu,
                doc,
                (SELECT cod FROM estpedidocab WHERE ospro = 306 LIMIT 1) codpedcons,
                (SELECT COUNT(*) FROM estpedidocab WHERE ospro = 306) numcodpedcons,
                situacao
           FROM getar_pedidos
          WHERE cod=306;
SELECT cod FROM estpedidocab WHERE ospro = 306 LIMIT 1;
SELECT COUNT(*) FROM estpedidocab WHERE ospro = 306;